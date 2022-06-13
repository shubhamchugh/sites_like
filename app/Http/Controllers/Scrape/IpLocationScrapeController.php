<?php

namespace App\Http\Controllers\Scrape;

use App\Models\Post;
use App\Models\IpRecord;
use App\Http\Controllers\Controller;
use Stevebauman\Location\Facades\Location;

class IpLocationScrapeController extends Controller
{
    public function ip_location_scrape()
    {

        $domain = Post::where('is_ip_location', 'pending')
            ->where('post_type', 'listing')
            ->orderBy('status', 'ASC')
            ->first();

        $domain->update([
            'is_ip_location' => 'scraping',
        ]);

        $ip_location = Location::get($domain->ip);

        if ($ip_location) {
            $ip_location_store = IpRecord::updateOrCreate(['post_id' => $domain->id], [
                'country_name' => $ip_location->countryName,
                'country_code' => $ip_location->countryCode,
            ]);

            $domain->update([
                'is_ip_location' => 'done',
            ]);
            return $ip_location_store;
        } else {
            $domain->update([
                'is_ip_location' => 'fail',
            ]);
            echo "something bad with this $domain->slug Ip Address location";
        }

    }
}
