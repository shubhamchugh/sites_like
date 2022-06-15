<?php

namespace App\Http\Controllers\Scrape;

use App\Models\Post;
use App\Models\SeoAnalyzer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SeoAnalyzerScrapeController extends Controller
{
    public function seo_analyzer_scrape(Request $request)
    {

        $status = !empty($request->status) ? $request->status : "pending";

        $domain = Post::where('is_seo_analyzer', $status)
            ->where('post_type', 'listing')
            ->orderBy('status', 'ASC')
            ->first();

        if (empty($domain)) {
            return "No Record Found Please check Database";
        }

        $domain->update([
            'is_seo_analyzer' => 'scraping',
        ]);

        $seoAnalyzer = seoAnalyzer($domain->slug);

        if (empty($seoAnalyzer) && 'pending' !== $status) {
            $domain->update([
                'is_seo_analyzer' => 'discard',
            ]);
            echo "Something bad with analyzing seo of $domain->slug";
            die;
        }

        if (empty($seoAnalyzer)) {
            $domain->update([
                'is_seo_analyzer' => 'fail',
            ]);
            echo "Something bad with analyzing seo of $domain->slug";
            die;
        }

        $seo_analyzer_store = SeoAnalyzer::updateOrCreate(['post_id' => $domain->id], [
            'language'           => (!empty($seoAnalyzer['language'])) ? $seoAnalyzer['language'] : null,
            'loadtime'           => (!empty($seoAnalyzer['loadtime'])) ? $seoAnalyzer['loadtime'] : null,
            'codeToTxtRatio'     => (!empty($seoAnalyzer['full_page']['codeToTxtRatio']['ratio'])) ? $seoAnalyzer['full_page']['codeToTxtRatio']['ratio'] : null,
            'word_count'         => (!empty($seoAnalyzer['full_page']['word_count'])) ? $seoAnalyzer['full_page']['word_count'] : null,
            'keywords'           => (!empty($seoAnalyzer['full_page']['keywords'])) ? $seoAnalyzer['full_page']['keywords'] : null,
            'longTailKeywords'   => (!empty($seoAnalyzer['full_page']['longTailKeywords'])) ? $seoAnalyzer['full_page']['longTailKeywords'] : null,
            'headers'            => (!empty($seoAnalyzer['full_page']['headers'])) ? $seoAnalyzer['full_page']['headers'] : null,
            'links'              => (!empty($seoAnalyzer['full_page']['links'])) ? $seoAnalyzer['full_page']['links'] : null,
            'images'             => (!empty($seoAnalyzer['full_page']['images'])) ? $seoAnalyzer['full_page']['images'] : null,
            'domain_title'       => (!empty($seoAnalyzer['title'])) ? $seoAnalyzer['title'] : null,
            'domain_description' => (!empty($seoAnalyzer['description'])) ? $seoAnalyzer['description'] : null,
        ]);

        $domain->update([
            'is_seo_analyzer' => 'done',
        ]);

        return $seo_analyzer_store;
    }
}
