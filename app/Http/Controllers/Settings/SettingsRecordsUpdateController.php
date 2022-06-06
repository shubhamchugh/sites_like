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
            'google_forms_contact'  => 'http://google.com/form',
            'home_h1_title'         => 'Frequently Asked Questions & Answers Related to Attorney',
            'home_page_description' => 'example.com is a crowd sourced law website dedicated to providing legal information and resources for all types of law-related topics.',
            'head_code'             => '',
            'bellow_title_ads'      => '',
            'about_us'              => 'FAQ is an open global project. Our aim is to provide explanations of possible technical topics and problem solving techniques in the form of questions and answers. We hope that our project will provide people with understanding difficult problems, how to solve them, through the engineering perspective.',
            'privacy'               => '',
            'disclaimer'            => '',
            'before_title'          => '',
            'after_title'           => '',
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
