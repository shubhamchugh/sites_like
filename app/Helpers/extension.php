<?php

use Spatie\Dns\Dns;
use Iodev\Whois\Factory;
use Illuminate\Support\Str;
use Spatie\SslCertificate\SslCertificate;
use MadeITBelgium\SeoAnalyzer\SeoFacade as SEO;

if (!function_exists('remove_http')) {
    function remove_http($url)
    {
        $disallowed = array('http://', 'https://');
        foreach ($disallowed as $d) {
            if (strpos($url, $d) === 0) {
                return str_replace($d, '', $url);
            }
        }
        return $url;
    }
}

if (!function_exists('sslCertificate')) {
    function sslCertificate($domain)
    {
        try {
            $certificate                       = SslCertificate::createForHostName($domain);
            $response['getDomain']             = $certificate->getDomain(); // returns "spatie.be"
            $response['getIssuer']             = $certificate->getIssuer(); // returns "Let's Encrypt Authority X3"
            $response['isValid']               = $certificate->isValid(); // returns true if the certificate is currently valid
            $response['validFromDate']         = $certificate->validFromDate()->toDateTimeString(); // returns a Carbon instance Carbon
            $response['expirationDate']        = $certificate->expirationDate()->toDateTimeString(); // returns a Carbon instance Carbon
            $response['lifespanInDays']        = $certificate->lifespanInDays(); // return the amount of days between  validFromDate and expirationDate
            $response['expirationdays']        = $certificate->expirationDate()->diffInDays(); // returns an int
            $response['getSignatureAlgorithm'] = $certificate->getSignatureAlgorithm(); // returns a string
            $response['getOrganization']       = $certificate->getOrganization(); // returns the organization name when available
            $response['getAdditionalDomains']  = $certificate->getAdditionalDomains(); // returns ["spatie.be", "www.spatie.be]
            $response['getFingerprint']        = $certificate->getFingerprint(); // returns a fingerprint for the certificate
            $response['getFingerprintSha256']  = $certificate->getFingerprintSha256(); // returns a SHA256 fingerprint
            return $response;
        } catch (\Throwable$th) {
            return null;
        }
    }
}

if (!function_exists('seoAnalyzer')) {
    function seoAnalyzer($domain)
    {
        try {
            $analyze = SEO::analyze($domain);
            if (!empty($analyze)) {

                if (empty($analyze['description'])) {
                    try {
                        $tags = get_meta_tags('http://' . $domain);
                    } catch (\Throwable$th) {
                        $tags['twitter:description'] = null;
                    }
                    $analyze['description'] = (!empty($tags['twitter:description'])) ? $tags['twitter:description'] : null;
                }

                if (empty($analyze['description'])) {
                    $analyze['description'] = Str::words($analyze['main_text']['text'], 50);
                }

                return $analyze;
            }
        } catch (\Throwable$th) {
            return null;
        }

        return null;
    }
}

if (!function_exists('alexa_rank')) {
    function alexa_rank($domain)
    {
        $xml = simplexml_load_file("http://data.alexa.com/data?cli=10&url=" . $domain);
        if (isset($xml->SD)) {
            $alexaData            = simplexml_load_file("http://data.alexa.com/data?cli=10&url=" . $domain);
            $alexa['globalRank']  = isset($alexaData->SD->POPULARITY) ? $alexaData->SD->POPULARITY->attributes()->TEXT : 0;
            $alexa['CountryRank'] = isset($alexaData->SD->COUNTRY) ? $alexaData->SD->COUNTRY->attributes() : 0;
            return json_decode(json_encode($alexa), true);
        } else {
            return null;
        }
    }
}

if (!function_exists('whois')) {
    function whois($domain)
    {
        $whois                    = Factory::get()->createWhois();
        $response                 = $whois->lookupDomain($domain);
        $info                     = $whois->loadDomainInfo($domain);
        $result['text']           = $response->text;
        $result['creationDate']   = (!empty($info->creationDate)) ? date("Y-m-d", $info->creationDate) : null;
        $result['expirationDate'] = (!empty($info->expirationDate)) ? date("Y-m-d", $info->expirationDate) : null;
        $result['owner']          = (!empty($info->owner)) ? $info->owner : "";
        $result['info']           = $info;
        return $result;
    }
}

if (!function_exists('dns_records')) {
    function dns_records($domain)
    {
        $result_final['A']     = null;
        $result_final['AAAA']  = null;
        $result_final['CNAME'] = null;
        $result_final['NS']    = null;
        $result_final['SOA']   = null;
        $result_final['MX']    = null;
        $result_final['SRV']   = null;
        $result_final['TXT']   = null;
        $result_final['CAA']   = null;

        $dns = new Dns();

        try {
            $dns->getRecords($domain, 'A');
            $result['A'] = $dns->getRecords($domain, 'A');
        } catch (\Throwable$th) {
            $result['A'] = null;
        }

        try {
            $dns->getRecords($domain, 'AAAA');
            $result['AAAA'] = $dns->getRecords($domain, 'AAAA');
        } catch (\Throwable$th) {
            $result['AAAA'] = null;
        }

        try {
            $dns->getRecords($domain, 'CNAME');
            $result['CNAME'] = $dns->getRecords($domain, 'CNAME');
        } catch (\Throwable$th) {
            $result['CNAME'] = null;
        }

        try {
            $dns->getRecords($domain, 'NS');
            $result['NS'] = $dns->getRecords($domain, 'NS');
        } catch (\Throwable$th) {
            $result['NS'] = null;
        }

        try {
            $dns->getRecords($domain, 'SOA');
            $result['SOA'] = $dns->getRecords($domain, 'SOA');
        } catch (\Throwable$th) {
            $result['SOA'] = null;
        }

        try {
            $dns->getRecords($domain, 'MX');
            $result['MX'] = $dns->getRecords($domain, 'MX');
        } catch (\Throwable$th) {
            $result['MX'] = null;
        }

        try {
            $dns->getRecords($domain, 'SRV');
            $result['SRV'] = $dns->getRecords($domain, 'SRV');
        } catch (\Throwable$th) {
            $result['SRV'] = null;
        }

        try {
            $dns->getRecords($domain, 'TXT');
            $result['TXT'] = $dns->getRecords($domain, 'TXT');
        } catch (\Throwable$th) {
            $result['TXT'] = null;
        }

        try {
            $dns->getRecords($domain, 'CAA');
            $result['CAA'] = $dns->getRecords($domain, 'CAA');
        } catch (\Throwable$th) {
            $result['CAA'] = null;
        }

        if (!empty($result['A'])) {
            foreach ($result['A'] as $value) {
                $value               = $value->toArray();
                $result_final['A'][] = $value['ip'];
            }
            $result_final['A'] = implode("\n", $result_final['A']);
        }

        if (!empty($result['AAAA'])) {
            foreach ($result['AAAA'] as $value) {
                $value                  = $value->toArray();
                $result_final['AAAA'][] = $value['ipv6'];
            }
            $result_final['AAAA'] = implode("\n", $result_final['AAAA']);
        }

        if (!empty($result['CNAME'])) {
            foreach ($result['CNAME'] as $value) {
                $value                   = $value->toArray();
                $result_final['CNAME'][] = $value['host'];
            }
            $result_final['CNAME'] = implode("\n", $result_final['CNAME']);
        }

        if (!empty($result['NS'])) {
            foreach ($result['NS'] as $value) {
                $value                = $value->toArray();
                $result_final['NS'][] = $value['target'];
            }
            $result_final['NS'] = implode("\n", $result_final['NS']);
        }

        if (!empty($result['SOA'])) {
            foreach ($result['SOA'] as $value) {
                $value                 = $value->toArray();
                $result_final['SOA'][] = $value['rname'];
            }
            $result_final['SOA'] = implode("\n", $result_final['SOA']);
        }

        if (!empty($result['MX'])) {
            foreach ($result['MX'] as $value) {
                $value                = $value->toArray();
                $result_final['MX'][] = $value['target'];
            }
            $result_final['MX'] = implode("\n", $result_final['MX']);
        }

        if (!empty($result['SRV'])) {
            foreach ($result['SRV'] as $value) {
                $value                 = $value->toArray();
                $result_final['SRV'][] = $value['target'];
            }
            $result_final['SRV'] = implode("\n", $result_final['SRV']);
        }

        if (!empty($result['TXT'])) {
            foreach ($result['TXT'] as $value) {
                $value                 = $value->toArray();
                $result_final['TXT'][] = $value['txt'];
            }
            $result_final['TXT'] = implode("\n", $result_final['TXT']);
        }

        if (!empty($result['CAA'])) {
            foreach ($result['CAA'] as $value) {
                $value                 = $value->toArray();
                $result_final['CAA'][] = $value['value'];
            }
            $result_final['CAA'] = implode("\n", $result_final['CAA']);
        }

        $result_final['ip'] = (!empty($result['A'][0])) ? $result['A'][0]->toArray() : null;

        return $result_final;
    }
}
