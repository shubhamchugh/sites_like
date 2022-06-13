<?php

namespace App\Http\Controllers\Scrape;

use App\Models\Post;
use App\Models\Attribute;
use App\Http\Controllers\Controller;

class AlexaRankScrapeController extends Controller
{
    public function alexa_rank_scrape()
    {

        $domain = Post::where('is_alexa', 'pending')
            ->where('post_type', 'listing')
            ->orderBy('status', 'ASC')
            ->first();

        $domain->update([
            'is_alexa' => 'scraping',
        ]);

        $alexa = alexa_rank($domain->slug);

        if (!empty($alexa)) {
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
        } else {
            $domain->update([
                'is_alexa' => 'fail',
            ]);

            echo "Alexa rank Not Found Please refresh and check Next record";
        }

    }
}
