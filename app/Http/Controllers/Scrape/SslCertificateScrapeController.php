<?php

namespace App\Http\Controllers\Scrape;

use App\Models\Post;
use App\Models\SslCertificate;
use App\Http\Controllers\Controller;

class SslCertificateScrapeController extends Controller
{
    public function ssl_certificate_scrape()
    {
        $domain = Post::where('is_ssl', 'pending')
            ->where('post_type', 'listing')
            ->orderBy('status', 'ASC')
            ->first();

        $domain->update([
            'is_ssl' => 'scraping',
        ]);

        $ssl = sslCertificate($domain->slug);

        if (!empty($ssl)) {
            $ssl_store = SslCertificate::updateOrCreate(['post_id' => $domain->id], [
                'issuer'                => $ssl['getIssuer'],
                'getSignatureAlgorithm' => $ssl['getSignatureAlgorithm'],
                'getOrganization'       => $ssl['getOrganization'],
                'getAdditionalDomains'  => $ssl['getAdditionalDomains'],
                'getFingerprint'        => $ssl['getFingerprint'],
                'getFingerprintSha256'  => $ssl['getFingerprintSha256'],
                'validFromDate'         => $ssl['validFromDate'],
                'expirationDate'        => $ssl['expirationDate'],
                'isValid'               => $ssl['isValid'],
            ]);
            $domain->update([
                'is_ssl' => 'done',
            ]);
            return $ssl_store;
        } else {
            $domain->update([
                'is_ssl' => 'fail',
            ]);
            echo "Something Bad with $domain->slug SSL";
        }
    }
}
