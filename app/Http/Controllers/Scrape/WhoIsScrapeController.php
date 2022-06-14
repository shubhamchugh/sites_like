<?php

namespace App\Http\Controllers\Scrape;

use App\Models\Post;
use App\Models\WhoIsRecord;
use App\Http\Controllers\Controller;

class WhoIsScrapeController extends Controller
{
    public function who_is_scrape()
    {
        $domain = Post::where('is_whois', 'pending')
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

        if (!empty($whois)) {
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
        } else {
            $domain->update([
                'is_whois' => 'fail',
            ]);
            echo "Something Bad with whois for $domain->slug";
        }

    }
}
