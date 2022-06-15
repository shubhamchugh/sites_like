<?php

namespace App\Http\Controllers\Scrape;

use App\Models\Post;
use App\Models\DnsDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DnsRecordScrapeController extends Controller
{
    public function dns_record_scrape(Request $request)
    {
        $status = !empty($request->status) ? $request->status : "pending";

        $domain = Post::where('is_dns', $status)
            ->where('post_type', 'listing')
            ->orderBy('status', 'ASC')
            ->first();

        if (empty($domain)) {
            return "No Record Found Please check Database";
        }

        $domain->update([
            'is_dns' => 'scraping',
        ]);

        $dns_records = dns_records($domain->slug);

        if (empty($dns_records) && 'pending' !== $status) {
            $domain->update([
                'is_dns' => 'discard',
            ]);
            echo "Something bad with analyzing DNS Record of $domain->slug";
            die;
        }

        if (empty($dns_records)) {
            $domain->update([
                'is_dns' => 'fail',
            ]);
            echo "Something bad with analyzing DNS Record of $domain->slug";
            die;
        }

        $dns_records_store = DnsDetail::updateOrCreate(['post_id' => $domain->id], [
            'A'     => (!empty($dns_records['A'])) ? $dns_records['A'] : null,
            'AAAA'  => (!empty($dns_records['AAAA'])) ? $dns_records['AAAA'] : null,
            'CNAME' => (!empty($dns_records['CNAME'])) ? $dns_records['CNAME'] : null,
            'NS'    => (!empty($dns_records['NS'])) ? $dns_records['NS'] : null,
            'SOA'   => (!empty($dns_records['SOA'])) ? $dns_records['SOA'] : null,
            'MX'    => (!empty($dns_records['MX'])) ? $dns_records['MX'] : null,
            'SRV'   => (!empty($dns_records['SRV'])) ? $dns_records['SRV'] : null,
            'TXT'   => (!empty($dns_records['TXT'])) ? $dns_records['TXT'] : null,
            'CAA'   => (!empty($dns_records['CAA'])) ? $dns_records['CAA'] : null,
        ]);
        $domain->update([
            'is_dns' => 'done',
        ]);

        if (!empty($dns_records['ip'])) {

            Post::updateOrCreate(['id' => $domain->id], [
                'ip' => (!empty($dns_records['ip']['ip'])) ? $dns_records['ip']['ip'] : null,
            ]);

        }

        return $dns_records_store;
    }
}
