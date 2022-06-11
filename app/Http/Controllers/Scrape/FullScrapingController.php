<?php

namespace App\Http\Controllers\Scrape;

use Pdp\Domain;
use App\Models\Post;
use App\Models\IpRecord;
use App\Models\Attribute;
use App\Models\DnsDetail;
use App\Models\SeoAnalyzer;
use App\Models\WhoIsRecord;
use App\Models\SourceDomain;
use App\Models\SslCertificate;
use App\Models\PostAlternative;
use App\Helpers\Scrape\Get_Alter;
use App\Helpers\Scrape\Get_Domain;
use App\Http\Controllers\Controller;
use App\Helpers\Scrape\Get_Screenshot;
use Stevebauman\Location\Facades\Location;

class FullScrapingController extends Controller
{

    public function scrape()
    {
        $domain_source = SourceDomain::where('status', 'pending')->first();

        if (empty($domain_source)) {
            return "No record found in source domain table";
        }

        $domain_source->update([
            'status' => 'scraping',
        ]);

        $primary_domain = Get_Domain::get_registrableDomain($domain_source->domain);

        $wappalyzer = shell_exec("wappalyzer $primary_domain[httpUrl]");
        $wappalyzer = json_decode($wappalyzer, true);
        dd($wappalyzer);
        $alter = Get_Alter::site_like_scrape($primary_domain['url']);

        $ssl = sslCertificate($primary_domain['url']);

        $alexa = alexa_rank($primary_domain['url']);

        $seoAnalyzer = seoAnalyzer($primary_domain['url']);

        $whois = whois($primary_domain['url']);

        $wappalyzer = shell_exec("wappalyzer $primary_domain[httpUrl]");

        $post_exist = Post::where('slug', $primary_domain['url'])->first();

        $dns_records = dns_records($primary_domain['url']);

        $ip_location = Location::get($dns_records['ip']['ip']);

        $screenshot = Get_Screenshot::screenshot_wasabi($primary_domain['url']);

        if (!empty($post_exist)) {
            $post_exist->update([
                'status' => 'publish',
            ]);
            $primary_domain_id = $post_exist->id;
        } else {
            $primary_domain_result = Post::firstOrCreate([
                'slug'   => trim($primary_domain['url']),
                'status' => 'publish',
            ]);
            $primary_domain_id = $primary_domain_result->id;
        }

        if ('OK' == $alter['status']) {

            foreach ($alter['alter'] as $domain_alter) {

                $post[] = Post::firstOrCreate([
                    'post_type' => 'listing',
                    'slug'      => trim($domain_alter),
                ]);
            }

            foreach ($post as $post_data) {

                PostAlternative::firstOrCreate([
                    'post_id'           => $primary_domain_id,
                    'post_alternate_id' => $post_data->id,
                ]);
            }
        }

        if (!empty($ssl)) {
            SslCertificate::updateOrCreate(['post_id' => $primary_domain_id], [
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
        }

        if (!empty($alexa)) {
            Attribute::updateOrCreate(['post_id' => $primary_domain_id], [
                'alexa_rank'         => $alexa['globalRank'][0],
                'alexa_country'      => $alexa['CountryRank']['@attributes']['NAME'],
                'alexa_country_code' => $alexa['CountryRank']['@attributes']['CODE'],
                'alexa_country_rank' => $alexa['CountryRank']['@attributes']['RANK'],
            ]);
        }

        if (!empty($seoAnalyzer)) {

            SeoAnalyzer::updateOrCreate(['post_id' => $primary_domain_id], [
                'language'           => $seoAnalyzer['language'],
                'loadtime'           => $seoAnalyzer['loadtime'],
                'codeToTxtRatio'     => $seoAnalyzer['full_page']['codeToTxtRatio']['ratio'],
                'word_count'         => $seoAnalyzer['full_page']['word_count'],
                'keywords'           => $seoAnalyzer['full_page']['keywords'],
                'longTailKeywords'   => $seoAnalyzer['full_page']['longTailKeywords'],
                'headers'            => $seoAnalyzer['full_page']['headers'],
                'links'              => $seoAnalyzer['full_page']['links'],
                'images'             => $seoAnalyzer['full_page']['images'],
                'domain_title'       => $seoAnalyzer['title'],
                'domain_description' => $seoAnalyzer['description'],
            ]);
        }

        if (!empty($whois)) {
            $whois_info = $whois['info'];
            $whois_info = $whois_info->toArray();

            WhoIsRecord::updateOrCreate(['post_id' => $primary_domain_id], [

                'text'           => $whois['text'],
                'whoisServer'    => $whois_info['whoisServer'],
                'nameServers'    => $whois_info['nameServers'],
                'creationDate'   => $whois['creationDate'],
                'expirationDate' => $whois['expirationDate'],
                'updatedDate'    => date("Y-m-d", $whois_info['updatedDate']),
                'states'         => $whois_info['states'],
                'owner'          => $whois['owner'],
                'registrar'      => $whois_info['registrar'],
                'dnssec'         => $whois_info['dnssec'],
            ]);
        }

        if (!empty($dns_records)) {
            DnsDetail::updateOrCreate(['post_id' => $primary_domain_id], [
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
        }

        if (!empty($dns_records['ip'])) {

            Post::updateOrCreate(['id' => $primary_domain_id], [
                'ip'        => $dns_records['ip']['ip'],
                'thumbnail' => $screenshot['thumbnail'],
                'favicon'   => $screenshot['favicon'],
            ]);
        }

        if ($ip_location) {
            IpRecord::updateOrCreate(['post_id' => $primary_domain_id], [
                'country_name' => $ip_location->countryName,
                'country_code' => $ip_location->countryCode,
            ]);
        }

        if (!empty($wappalyzer)) {

        }

        $domain_source->update([
            'status' => 'success',
        ]);
    }

}
