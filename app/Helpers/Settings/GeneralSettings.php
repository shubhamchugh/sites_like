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
                Text::make('Home Page Description', 'home_page_description'),
                Text::make('Google Form Link', 'google_forms_contact'),
                Text::make('Title Above Content', 'title_above_content'),
                Text::make('Title Bellow Content', 'title_bellow_content'),
                Text::make('Title prefix', 'title_prefix'),
                Text::make('TItle Suffix', 'title_suffix'),

                Textarea::make('Head Code', 'head_code'),
                Textarea::make('Bellow Title Ads', 'bellow_title_ads'),

                Text::make('Permalink Prefix', 'permalink_prefix'),

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
