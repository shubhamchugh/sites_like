<?php

namespace App\Helpers\Settings;

use Laravel\Nova\Panel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Textarea;

class GeneralSettings
{
    public static function settings()
    {
        // Using an array
        \Outl1ne\NovaSettings\NovaSettings::addSettingsFields([
            Panel::make('Settings', [

                Text::make('Site Name', 'site_name'),
                Text::make('Home Page Title', 'home_title'),
                Text::make('After Title', 'before_title'),
                Text::make('After Title', 'after_title'),
                Text::make('Google Form Link', 'google_forms_contact'),

                Textarea::make('Head Code', 'head_code'),
                Textarea::make('Bellow Title Ads', 'bellow_title_ads'),
                Textarea::make('About Us', 'about_us'),
                Textarea::make('Privacy', 'privacy'),
                Textarea::make('Disclaimer', 'disclaimer'),

                Image::make('Logo', 'logo')
                    ->disableDownload()
                    ->deletable(false)
                    ->hideFromIndex()
                    ->acceptedTypes('.jpg', '.png')
                    ->maxWidth(100)
                    ->storeOriginalName('logo')
                    ->store(function (Request $request, $model) {
                        $filename = $request->logo->getClientOriginalName();
                        $request->logo->storeAs('public', $filename);
                        return [
                            'logo'      => $filename,
                            'logo_name' => $request->logo->getClientOriginalName(),
                        ];
                    }),

            ]),
        ]);
    }
}
