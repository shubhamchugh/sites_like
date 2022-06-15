<?php

namespace App\Http\Controllers\Scrape;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\SslCertificate;
use App\Http\Controllers\Controller;

class SslCertificateScrapeController extends Controller
{
    public function ssl_certificate_scrape(Request $request)
    {

        $status = !empty($request->status) ? $request->status : "pending";

        $domain = Post::where('is_ssl', $status)
            ->where('post_type', 'listing')
            ->orderBy('status', 'ASC')
            ->first();

        if (empty($domain)) {
            return "No Record Found Please check Database";
        }

        $domain->update([
            'is_ssl' => 'scraping',
        ]);

        $ssl = sslCertificate($domain->slug);

        if (empty($ssl) && 'pending' !== $status) {
            $domain->update([
                'is_ssl' => 'discard',
            ]);
            echo "Something bad with analyzing SSL of $domain->slug";
            die;
        }

        if (empty($ssl)) {
            $domain->update([
                'is_ssl' => 'fail',
            ]);
            echo "Something bad with analyzing SSL of $domain->slug";
            die;
        }

        $ssl_store = SslCertificate::updateOrCreate(['post_id' => $domain->id], [
            'issuer'                => (!empty($ssl['getIssuer'])) ? $ssl['getIssuer'] : null,
            'getSignatureAlgorithm' => (!empty($ssl['getSignatureAlgorithm'])) ? $ssl['getSignatureAlgorithm'] : null,
            'getOrganization'       => (!empty($ssl['getOrganization'])) ? $ssl['getOrganization'] : null,
            'getAdditionalDomains'  => (!empty($ssl['getAdditionalDomains'])) ? $ssl['getAdditionalDomains'] : null,
            'getFingerprint'        => (!empty($ssl['getFingerprint'])) ? $ssl['getFingerprint'] : null,
            'getFingerprintSha256'  => (!empty($ssl['getFingerprintSha256'])) ? $ssl['getFingerprintSha256'] : null,
            'validFromDate'         => (!empty($ssl['validFromDate'])) ? $ssl['validFromDate'] : null,
            'expirationDate'        => (!empty($ssl['expirationDate'])) ? $ssl['expirationDate'] : null,
            'isValid'               => (!empty($ssl['isValid'])) ? $ssl['isValid'] : null,
        ]);
        $domain->update([
            'is_ssl' => 'done',
        ]);
        return $ssl_store;

    }
}
