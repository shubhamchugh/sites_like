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
                'is_alexa' => 'discard',
            ]);
            echo "Something bad with analyzing Alexa Rank of $domain->slug";
            die;
        }

        if (empty($alexa)) {
            $domain->update([
                'is_alexa' => 'fail',
            ]);
            echo "Something bad with analyzing Alexa Rank of $domain->slug";
            die;
        }

        $alexa_detail_store = Attribute::updateOrCreate(['post_id' => $domain->id], [
            'alexa_rank'         => (!empty($alexa['globalRank'][0])) ? $alexa['globalRank'][0] : null,
            'alexa_country'      => (!empty($alexa['CountryRank']['@attributes']['NAME'])) ? $alexa['CountryRank']['@attributes']['NAME'] : null,
            'alexa_country_code' => (!empty($alexa['CountryRank']['@attributes']['CODE'])) ? $alexa['CountryRank']['@attributes']['CODE'] : null,
            'alexa_country_rank' => (!empty($alexa['CountryRank']['@attributes']['RANK'])) ? $alexa['CountryRank']['@attributes']['RANK'] : null,
        ]);

        $domain->update([
            'is_alexa' => 'done',
        ]);

        return $alexa_detail_store;

    }
}
