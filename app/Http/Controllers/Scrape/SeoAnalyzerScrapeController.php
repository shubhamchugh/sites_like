<?php

namespace App\Http\Controllers\Scrape;

use App\Models\Post;
use App\Models\SeoAnalyzer;
use App\Http\Controllers\Controller;

class SeoAnalyzerScrapeController extends Controller
{
    public function seo_analyzer_scrape()
    {
        $domain = Post::where('is_seo_analyzer', 'pending')
            ->where('post_type', 'listing')
            ->orderBy('status', 'ASC')
            ->first();

        $domain->update([
            'is_seo_analyzer' => 'scraping',
        ]);

        $seoAnalyzer = seoAnalyzer($domain->slug);

        if (!empty($seoAnalyzer)) {

            $seo_analyzer_store = SeoAnalyzer::updateOrCreate(['post_id' => $domain->id], [
                'language'           => $seoAnalyzer['language'],
                'loadtime'           => $seoAnalyzer['loadtime'],
                'codeToTxtRatio'     => $seoAnalyzer['full_page']['codeToTxtRatio']['ratio'],
                'word_count'         => $seoAnalyzer['full_page']['word_count'],
                'keywords'           => $seoAnalyzer['full_page']['keywords'],
                'longTailKeywords'   => $seoAnalyzer['full_page']['longTailKeywords'],
                'headers'            => $seoAnalyzer['full_page']['headers'],
                'links'              => $seoAnalyzer['full_page']['links'],
                'images'             => $seoAnalyzer['full_page']['images'],
                'domain_title'       => $seoAnalyzer['title'],
                'domain_description' => $seoAnalyzer['description'],
            ]);
            $domain->update([
                'is_seo_analyzer' => 'done',
            ]);
            return $seo_analyzer_store;
        } else {
            $domain->update([
                'is_seo_analyzer' => 'fail',
            ]);
            echo "Something bad with analyzing seo with $domain->slug";
        }
    }
}
