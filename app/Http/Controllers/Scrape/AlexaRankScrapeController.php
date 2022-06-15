<?php

namespace App\Http\Controllers\Scrape;

use App\Models\Post;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AlexaRankScrapeController extends Controller
{
    public function alexa_rank_scrape(Request $request)
    {

        $status = !empty($request->status) ? $request->status : "pending";

        $domain = Post::where('is_alexa', $status)
            ->where('post_type', 'listing')
            ->orderBy('status', 'ASC')
            ->first();

        if (empty($domain)) {
            return "No Record Found Please check Database";
        }

        $domain->update([
            'is_alexa' => 'scraping',
        ]);

        $alexa = alexa_rank($domain->slug);

        if (empty($alexa) && 'pending' !== $status) {
            $domain->update([
                'is_seo_analyzer' => 'discard',
            ]);
            echo "Something bad with analyzing seo with $domain->slug";
            die;
        }

        if (empty($alexa)) {
            $domain->update([
                'is_seo_analyzer' => 'fail',
            ]);
            echo "Something bad with analyzing seo with $domain->slug";
            die;
        }

        $alexa_detail_store = Attribute::updateOrCreate(['post_id' => $domain->id], [
            'alexa_rank'         => $alexa['globalRank'][0],
            'alexa_country'      => $alexa['CountryRank']['@attributes']['NAME'],
            'alexa_country_code' => $alexa['CountryRank']['@attributes']['CODE'],
            'alexa_country_rank' => $alexa['CountryRank']['@attributes']['RANK'],
        ]);

        $domain->update([
            'is_alexa' => 'done',
        ]);

        return $alexa_detail_store;

    }
}
