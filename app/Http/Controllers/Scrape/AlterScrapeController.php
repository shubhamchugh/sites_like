<?php

namespace App\Http\Controllers\Scrape;

use App\Models\Post;
use App\Models\SourceDomain;
use App\Models\PostAlternative;
use App\Helpers\Scrape\Get_Alter;
use App\Helpers\Scrape\Get_Domain;
use App\Http\Controllers\Controller;

class AlterScrapeController extends Controller
{
    public function alter_scrape()
    {
        $domain_source = SourceDomain::where('status', 'pending')->first();

        if (empty($domain_source)) {
            return "No record found in source domain table";
        }

        $domain_source->update([
            'status' => 'scraping',
        ]);

        $primary_domain = Get_Domain::get_registrableDomain($domain_source->domain);

        $post_exist = Post::where('slug', $primary_domain['url'])->first();

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

        $alter = Get_Alter::site_like_scrape($primary_domain['url']);

        if ('OK' == $alter['status']) {

            $i = 1;
            echo "<h1>Domain Added or Get Id</h1>";
            foreach ($alter['alter'] as $domain_alter) {

                $domain_alter = Get_Domain::get_registrableDomain(trim($domain_alter));
                $post[]       = Post::firstOrCreate([
                    'slug' => $domain_alter['url'],
                ]);

                $count = $i++;
                echo "$count: $domain_alter[url]<br>";
            }

            $i = 1;
            echo "<h1>Relation Created</h1>";
            foreach ($post as $post_data) {

                PostAlternative::firstOrCreate([
                    'post_id'           => $primary_domain_id,
                    'post_alternate_id' => $post_data->id,
                ]);
                $count = $i++;
                echo "$count: $primary_domain_id ----> $post_data->id<br>";

            }
        }

        $domain_source->update([
            'status' => 'success',
        ]);

    }
}
