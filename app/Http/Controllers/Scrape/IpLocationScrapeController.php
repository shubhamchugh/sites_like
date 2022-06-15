<?php

namespace App\Http\Controllers\Scrape;

use App\Models\Post;
use App\Models\IpRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stevebauman\Location\Facades\Location;

class IpLocationScrapeController extends Controller
{
    public function ip_location_scrape(Request $request)
    {

        $status = !empty($request->status) ? $request->status : "pending";

        $domain = Post::where('is_ip_location', $status)
            ->where('post_type', 'listing')
            ->orderBy('status', 'ASC')
            ->first();

        if (empty($domain)) {
            return "No Record Found Please check Database";
        }

        $domain->update([
            'is_ip_location' => 'scraping',
        ]);

        $ip_location = Location::get($domain->ip);

        if (empty($ip_location) && 'pending' !== $status) {
            $domain->update([
                'is_ip_location' => 'discard',
            ]);
            echo "Something bad with analyzing Ip Location of $domain->slug";
            die;
        }

        if (empty($ip_location)) {
            $domain->update([
                'is_ip_location' => 'fail',
            ]);
            echo "Something bad with analyzing Ip Location of $domain->slug";
            die;
        }

        $ip_location_store = IpRecord::updateOrCreate(['post_id' => $domain->id], [
            'country_name' => (!empty($ip_location->countryName)) ? $ip_location->countryName : null,
            'country_code' => (!empty($ip_location->countryCode)) ? $ip_location->countryCode : null,
        ]);

        $domain->update([
            'is_ip_location' => 'done',
        ]);
        return $ip_location_store;

    }
}
