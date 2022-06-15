<?php

namespace App\Http\Controllers\Scrape;

use App\Models\Post;
use App\Models\WhoIsRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WhoIsScrapeController extends Controller
{
    public function who_is_scrape(Request $request)
    {

        $status = !empty($request->status) ? $request->status : "pending";

        $domain = Post::where('is_whois', $status)
            ->where('post_type', 'listing')
            ->orderBy('status', 'ASC')
            ->first();

        if (empty($domain)) {
            return "No Record Found Please check Database";
        }

        $domain->update([
            'is_whois' => 'scraping',
        ]);

        $whois = whois($domain->slug);

        if (empty($whois) && 'pending' !== $status) {
            $domain->update([
                'is_seo_analyzer' => 'discard',
            ]);
            echo "Something bad with analyzing seo with $domain->slug";
            die;
        }

        if (empty($whois)) {
            $domain->update([
                'is_seo_analyzer' => 'fail',
            ]);
            echo "Something bad with analyzing seo with $domain->slug";
            die;
        }

        $whois_info = $whois['info'];
        $whois_info = $whois_info->toArray();

        $whois_store = WhoIsRecord::updateOrCreate(['post_id' => $domain->id], [

            'text'           => $whois['text'],
            'whoisServer'    => $whois_info['whoisServer'],
            'nameServers'    => $whois_info['nameServers'],
            'creationDate'   => $whois['creationDate'],
            'expirationDate' => $whois['expirationDate'],
            'updatedDate'    => (!empty($whois_info['updatedDate'])) ? date("Y-m-d", $whois_info['updatedDate']) : null,
            'states'         => $whois_info['states'],
            'owner'          => $whois['owner'],
            'registrar'      => $whois_info['registrar'],
            'dnssec'         => $whois_info['dnssec'],
        ]);

        $domain->update([
            'is_whois' => 'done',
        ]);
        return $whois_store;

    }
}
