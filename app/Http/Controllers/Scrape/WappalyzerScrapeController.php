<?php

namespace App\Http\Controllers\Scrape;

use App\Models\Post;
use App\Models\Technology;
use Illuminate\Http\Request;
use App\Helpers\Scrape\Get_Domain;
use App\Http\Controllers\Controller;
use App\Models\TechnologyPostRelation;

class WappalyzerScrapeController extends Controller
{
    public function wappalyzer_scrape(Request $request)
    {
        $status = !empty($request->status) ? $request->status : "pending";

        $domain = Post::where('is_wappalyzer', $status)
            ->where('post_type', 'listing')
            ->orderBy('status', 'ASC')
            ->first();

        if (empty($domain)) {
            return "No Record Found Please check Database";
        }

        $domain->update([
            'is_wappalyzer' => 'scraping',
        ]);

        $primary_domain = Get_Domain::get_registrableDomain($domain->slug);

        $wappalyzer = shell_exec("wappalyzer $primary_domain[httpUrl]");

        $wappalyzer = json_decode($wappalyzer, true);

        if (empty($wappalyzer['technologies']) && 'pending' !== $status) {
            $domain->update([
                'is_wappalyzer' => 'discard',
            ]);
            echo "Something bad with analyzing wappalyzer of  $domain->slug";
            die;
        }

        if (empty($wappalyzer['technologies'])) {
            $domain->update([
                'is_wappalyzer' => 'fail',
            ]);
            echo "Something bad with analyzing wappalyzer of  $domain->slug";
            die;
        }

        echo "<h1>Technology in DataBase</h1>";
        foreach ($wappalyzer['technologies'] as $technology) {
            $technology_database = Technology::updateOrCreate([
                'name'    => (!empty($technology['name'])) ? $technology['name'] : null,
                'slug'    => $technology['slug'],
                'website' => (!empty($technology['website'])) ? $technology['website'] : null,
                'icon'    => (!empty($technology['icon'])) ? $technology['icon'] : null,
            ]);
            $technology_database_id = $technology_database->id;

            echo "$technology_database->id: $technology_database->name<br>";

            TechnologyPostRelation::updateOrCreate([
                'post_id'       => $domain->id,
                'technology_id' => $technology_database_id,
                'confidence'    => (!empty($technology['confidence'])) ? $technology['confidence'] : null,
                'version'       => (!empty($technology['version'])) ? $technology['version'] : null,
            ]);

            echo "(Technology Post Relations) Post id: $domain->id ---> Technology id:  $technology_database_id<br><br>";
        }
        $domain->update([
            'is_wappalyzer' => 'done',
        ]);

    }
}
