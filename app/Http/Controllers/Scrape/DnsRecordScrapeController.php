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
                'is_seo_analyzer' => 'discard',
            ]);
            echo "Something bad with analyzing seo with $domain->slug";
            die;
        }

        if (empty($dns_records)) {
            $domain->update([
                'is_seo_analyzer' => 'fail',
            ]);
            echo "Something bad with analyzing seo with $domain->slug";
            die;
        }

        $dns_records_store = DnsDetail::updateOrCreate(['post_id' => $domain->id], [
            'A'     => $dns_records['A'],
            'AAAA'  => $dns_records['AAAA'],
            'CNAME' => $dns_records['CNAME'],
            'NS'    => $dns_records['NS'],
            'SOA'   => $dns_records['SOA'],
            'MX'    => $dns_records['MX'],
            'SRV'   => $dns_records['SRV'],
            'TXT'   => $dns_records['TXT'],
            'CAA'   => $dns_records['CAA'],
        ]);
        $domain->update([
            'is_dns' => 'done',
        ]);

        if (!empty($dns_records['ip'])) {

            Post::updateOrCreate(['id' => $domain->id], [
                'ip' => $dns_records['ip']['ip'],
            ]);

        }

        return $dns_records_store;
    }
}
