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
                'is_whois' => 'discard',
            ]);
            echo "Something bad with analyzing whois of $domain->slug";
            die;
        }

        if (empty($whois)) {
            $domain->update([
                'is_whois' => 'fail',
            ]);
            echo "Something bad with analyzing whois of $domain->slug";
            die;
        }

        $whois_info = $whois['info'];
        $whois_info = $whois_info->toArray();

        $whois_store = WhoIsRecord::updateOrCreate(['post_id' => $domain->id], [

            'text'           => (!empty($whois['text'])) ? $whois['text'] : null,
            'whoisServer'    => (!empty($whois_info['whoisServer'])) ? $whois_info['whoisServer'] : null,
            'nameServers'    => (!empty($whois_info['nameServers'])) ? $whois_info['nameServers'] : null,
            'creationDate'   => (!empty($whois['creationDate'])) ? $whois['creationDate'] : null,
            'expirationDate' => (!empty($whois['expirationDate'])) ? $whois['expirationDate'] : null,
            'updatedDate'    => (!empty($whois_info['updatedDate'])) ? date("Y-m-d", $whois_info['updatedDate']) : null,
            'states'         => (!empty($whois_info['states'])) ? $whois_info['states'] : null,
            'owner'          => (!empty($whois['owner'])) ? $whois['owner'] : null,
            'registrar'      => (!empty($whois_info['registrar'])) ? $whois_info['registrar'] : null,
            'dnssec'         => (!empty($whois_info['dnssec'])) ? $whois_info['dnssec'] : null,
        ]);

        $domain->update([
            'is_whois' => 'done',
        ]);
        return $whois_store;

    }
}
