<?php

namespace App\Http\Controllers\Scrape;

use App\Models\Post;
use App\Models\DnsDetail;
use App\Http\Controllers\Controller;

class DnsRecordScrapeController extends Controller
{
    public function dns_record_scrape()
    {
        $domain = Post::where('is_dns', 'pending')
            ->where('post_type', 'listing')
            ->orderBy('status', 'ASC')
            ->first();

        $domain->update([
            'is_dns' => 'scraping',
        ]);

        $dns_records = dns_records($domain->slug);

        if (!empty($dns_records)) {
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

        } else {
            $domain->update([
                'is_dns' => 'fail',
            ]);
            echo "Something bad with Dns record of $domain ->slug";
            die;
        }

        if (!empty($dns_records['ip'])) {

            Post::updateOrCreate(['id' => $domain->id], [
                'ip' => $dns_records['ip']['ip'],
            ]);

        }

        return $dns_records_store;
    }
}
