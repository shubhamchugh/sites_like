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

        if (!empty($wappalyzer['technologies'])) {
            echo "<h1>Technology in DataBase</h1>";
            foreach ($wappalyzer['technologies'] as $technology) {
                $technology_database = Technology::updateOrCreate([
                    'name'    => $technology['name'],
                    'slug'    => $technology['slug'],
                    'website' => $technology['website'],
                    'icon'    => $technology['icon'],
                ]);
                $technology_database_id = $technology_database->id;

                echo "$technology_database->id: $technology_database->name<br>";

                TechnologyPostRelation::updateOrCreate([
                    'post_id'       => $domain->id,
                    'technology_id' => $technology_database_id,
                    'confidence'    => $technology['confidence'],
                    'version'       => $technology['version'],
                ]);

                echo "(Technology Post Relations) Post id: $domain->id ---> Technology id:  $technology_database_id<br><br>";
            }
            $domain->update([
                'is_wappalyzer' => 'done',
            ]);
        } else {
            $domain->update([
                'is_wappalyzer' => 'fail',
            ]);
            echo "something bad with finding technology for $domain->slug";
        }

    }
}
