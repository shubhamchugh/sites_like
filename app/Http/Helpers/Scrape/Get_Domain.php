<?php

namespace App\Http\Helpers\Scrape;

use Pdp\Rules;
use Pdp\Domain;

class Get_Domain
{
    public static function get_registrableDomain($domain)
    {
        $url     = trim($domain);
        $url     = remove_http($url);
        $httpUrl = 'http://' . $url;

        $sourceDomain = parse_url($httpUrl);

        $domain_url = $sourceDomain['host']; // domain name with subdomain

        $publicSuffixList = Rules::fromPath(public_path('public_suffix_list.dat'));
        $domain_url       = Domain::fromIDNA2008($domain_url);

        $result = $publicSuffixList->resolve($domain_url);

        $value['url']     = $result->registrableDomain()->toString();
        $value['httpUrl'] = $httpUrl;
        return $value;
    }
}
