<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
    public function test()
    {
        // $domain = "http://technofizi.net";
        // $ss     = "wappalyzer $domain";

        // print_r($wap);
        // $screenshot = Get_Screenshot::screenshot_wasabi("technofizi.net");

        // $favicon = "https://www.google.com/s2/favicons?domain=technofizi.net";

        // $favicon = file_get_contents($favicon);

        // $faviconName   = Str::slug('technofizi.net', '-') . '.png';
        // $faviconPath   = 'favicon/' . $faviconName;
        // $faviconStatus = Storage::disk('wasabi')->put($faviconPath, $favicon);

        // dd(dns_records("mozilla.org"));

        // $position = Location::get('103.59.75.141');
        // dd($position);

        // $dns     = new Dns();
        // $records = $dns->getRecords('technofizi.net');
        // dd($records); // returns only A records

        // $whois = whois("beebom.com");
        // dd($whois);
        // $dd = Get_Alter::site_like_scrape('technofizi.net');

        // $topLevelDomains = TopLevelDomains::fromPath(public_path('tlds-alpha-by-domain.txt'));
        // $domain          = Domain::fromIDNA2008('www.PreF.OkiNawA.jP');
        // dd($domain);

        // // Creating default configured client
        // $whois = Factory::get()->createWhois();

        // // Getting parsed domain info
        // $info = $whois->loadDomainInfo("technofizi.net");
        // print_r(json_encode($info));

        // $certificate = SslCertificate::createForHostName('stackoverflow.com', 30, false);

        // $data = shell_exec('dig +short stackoverflow.com
        // ');

        // $valid = preg_match('\b((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(\.|$)){4}\b', $data);
        // $dns = new Dns();

        // $ARecord = $dns->getRecords('stackoverflow.com'); // returns all available dns records
        // dd($certificate->expirationDate());
        // SSLTABLE::create([
        //     'expirationDate' => $certificate->expirationDate(),
        // ]);

    }
}
