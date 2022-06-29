<?php

namespace App\Http\Controllers\Scrape;

use App\Models\SourceDomain;
use Illuminate\Http\Request;
use App\Helpers\Scrape\Get_Domain;
use App\Http\Controllers\Controller;

class DuplicateCheckerController extends Controller
{
    public function publish_duplicate(Request $request)
    {

        $status = !empty($request->status) ? $request->status : "pending";
        $start  = (!empty($request->start)) ? $request->start : 0;
        $end    = (!empty($request->end)) ? $request->end : 999999999999999999;
        $count  = (!empty($request->count)) ? $request->count : 20;

        $domain_source = SourceDomain::where('status', $status)->whereBetween('id', [$start, $end])->limit($count)->get();

        if (($domain_source->isEmpty())) {
            return "No record found in source domain table";
        }

        foreach ($domain_source as $domain_source_data) {

            $primary_domain = Get_Domain::get_registrableDomain($domain_source_data->domain);

            $domain_source_data->update([
                'status' => 'checking',
            ]);

            echo "<h1>$primary_domain[url]<h1>";
            echo "status update checking for $primary_domain[url]<br>";

            $post_exist = SourceDomain::where('status', 'success')->where('domain', $primary_domain['url'])->first();

            if (!empty($post_exist)) {
                $domain_source_data->update([
                    'status' => 'AlreadyScraped',
                ]);
                echo "$primary_domain[url] status update AlreadyScraped<br>";
            } else {
                $domain_source_data->update([
                    'status' => 'checked',
                ]);

                echo "status update checked for $primary_domain[url] ready for scraping<br><br><br><br>";
            }

        }
    }
}
