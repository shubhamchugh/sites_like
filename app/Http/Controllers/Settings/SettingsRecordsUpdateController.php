<?php

namespace App\Http\Controllers\Settings;

use App\Models\Settings;
use App\Http\Controllers\Controller;

class SettingsRecordsUpdateController extends Controller
{
    public function __invoke()
    {
        $data = [
            'site_name'             => 'Website Name',
            'home_title'            => 'Home Title',
            'home_page_description' => '',
            'google_forms_contact'  => 'http://google.com/form',
            'head_code'             => '',
            'bellow_title_ads'      => '',
            'title_above_content'   => '',
            'title_bellow_content'  => '',
            'title_prefix'          => '',
            'title_suffix'          => '',
            'permalink_prefix'      => 'similar',

        ];

        foreach ($data as $name => $payload) {
            $exist = Settings::where('key', $name)->first();
            if (empty($exist)) {
                Settings::create([
                    'key'   => $name,
                    'value' => $payload,
                ]);
            } else {
                echo "$name Already in Database</br>";
            }
        }
    }
}
