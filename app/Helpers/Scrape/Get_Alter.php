<?php

namespace App\Helpers\Scrape;

use Illuminate\Support\Facades\Http;

class Get_Alter
{
    public static function site_like_scrape($domain)
    {

        $sourceDomain = 'https://www.sitelike.org/similar/' . $domain . '/';

        $html = Http::get($sourceDomain)->body();

        $response = new \DOMDocument();
        libxml_use_internal_errors(true); //disable libxml errors

        $response->loadHTML($html);
        libxml_clear_errors(); //remove errors for yucky html

        $response->preserveWhiteSpace = false;
        $response->saveHTML();

        $response_xpath = new \DOMXPath($response);

        $alternative_urls = $response_xpath->query('//*[@id="MainContent_pnlMain"]/div[5]/div[1]/div[*]/div/div[2]/a[1]');

        if (!empty($alternative_urls->length)) {
            foreach ($alternative_urls as $alternative_url) {
                $alternatives['alter'][] = $alternative_url->nodeValue;
            }

            $alternatives['status'] = "OK";
            return $alternatives;
        } else {
            $alternatives['status'] = 'fail';
            return $alternatives;
        }
    }
}
