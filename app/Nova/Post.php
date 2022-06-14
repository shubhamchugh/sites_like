<?php

namespace App\Nova;

use App\Nova\SeoAnalyzer;
use Manogi\Tiptap\Tiptap;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\ID;
use App\Nova\SslCertificate;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Http\Requests\NovaRequest;
use OsTheNeo\NovaFields\BelongsToManyField;

class Post extends Resource
{

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Post Management';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Post::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'slug';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'slug',
    ];

    //* Post Status
    public function status()
    {
        $status_pluck = \App\Models\Post::pluck('status')->unique();

        foreach ($status_pluck as $key) {
            $status[$key] = Str::upper($key);
        }
        return $status;
    }

    public function is_wappalyzer()
    {
        $is_wappalyzer_pluck = \App\Models\Post::pluck('is_wappalyzer')->unique();

        foreach ($is_wappalyzer_pluck as $key) {
            $status[$key] = Str::upper($key);
        }
        return $status;
    }

    public function is_ssl()
    {
        $is_ssl_pluck = \App\Models\Post::pluck('is_ssl')->unique();

        foreach ($is_ssl_pluck as $key) {
            $status[$key] = Str::upper($key);
        }
        return $status;
    }

    public function is_alexa()
    {
        $is_alexa_pluck = \App\Models\Post::pluck('is_alexa')->unique();

        foreach ($is_alexa_pluck as $key) {
            $status[$key] = Str::upper($key);
        }
        return $status;
    }

    public function is_seo_analyzer()
    {
        $is_seo_analyzer_pluck = \App\Models\Post::pluck('is_seo_analyzer')->unique();

        foreach ($is_seo_analyzer_pluck as $key) {
            $status[$key] = Str::upper($key);
        }
        return $status;
    }

    public function is_whois()
    {
        $is_whois_pluck = \App\Models\Post::pluck('is_whois')->unique();

        foreach ($is_whois_pluck as $key) {
            $status[$key] = Str::upper($key);
        }
        return $status;
    }

    public function is_dns()
    {
        $is_dns_pluck = \App\Models\Post::pluck('is_dns')->unique();

        foreach ($is_dns_pluck as $key) {
            $status[$key] = Str::upper($key);
        }
        return $status;
    }

    public function is_screenshot()
    {
        $is_screenshot_pluck = \App\Models\Post::pluck('is_screenshot')->unique();

        foreach ($is_screenshot_pluck as $key) {
            $status[$key] = Str::upper($key);
        }
        return $status;
    }

    public function is_ip_location()
    {
        $is_ip_location_pluck = \App\Models\Post::pluck('is_ip_location')->unique();

        foreach ($is_ip_location_pluck as $key) {
            $status[$key] = Str::upper($key);
        }
        return $status;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {

        $options = [
            'heading',
            '|',
            'italic',
            'bold',
            '|',
            'link',
            'code',
            'strike',
            'underline',
            'highlight',
            '|',
            'bulletList',
            'orderedList',
            'br',
            'codeBlock',
            'blockquote',
            '|',
            'horizontalRule',
            'hardBreak',
            '|',
            'table',
            '|',
            'image',
            '|',
            'textAlign',
            '|',
            'rtl',
            '|',
            'history',
            '|',
            'editHtml',
        ];
        return [
            ID::make()->asBigInt()->sortable(),

            Text::make('Title', 'title')->nullable()->sortable(),
            Text::make('Ip Address', 'ip')->nullable()->placeholder('127.0.0.1'),
            Slug::make('Slug', 'slug')
                ->from('title')
                ->separator('-')
                ->rules('required', 'max:80')
                ->creationRules('required', 'unique:posts,slug'),

            Tiptap::make('Post Content', 'content')
                ->buttons($options)
                ->headingLevels([1, 2, 3, 4])
                ->syntaxHighlighting()
                ->nullable(),
            BelongsToManyField::make('Technologies', 'technologies', Technology::class)->hideFromIndex(),
            BelongsToManyField::make('Alternatives', 'domain_alternative', '\App\Nova\Post')->onlyOnForms(),

            Heading::make('Indexing Status'),
            Boolean::make('Indexing Google', 'is_index_google')->sortable(),
            Boolean::make('Indexing Bing', 'is_index_bing')->sortable(),

            Heading::make('Images'),
            Image::make('Thumbnail', 'thumbnail')
                ->path('thumbnail')
                ->disk("wasabi"),
            Image::make('Favicon', 'favicon')
                ->path('favicon')
                ->disk('wasabi'),

            Heading::make('Post Status'),
            Select::make('Post Type', 'post_type')->options([
                'listing' => 'Listing',
                'page'    => 'Page',
            ])->displayUsingLabels()->rules('required')->sortable(),

            Select::make('Status', 'status')->options($this->status())->displayUsingLabels()->rules('required')->sortable(),

            Heading::make('Scraping Status'),
            Select::make('Wappalyzer', 'is_wappalyzer')->options($this->is_wappalyzer())->displayUsingLabels()->rules('required')->sortable(),
            Select::make('SSL', 'is_ssl')->options($this->is_ssl())->displayUsingLabels()->rules('required')->sortable(),
            Select::make('Alexa', 'is_alexa')->options($this->is_alexa())->displayUsingLabels()->rules('required')->sortable(),
            Select::make('Seo Analyzer', 'is_seo_analyzer')->options($this->is_seo_analyzer())->displayUsingLabels()->rules('required')->sortable(),
            Select::make('Whois', 'is_whois')->options($this->is_whois())->displayUsingLabels()->rules('required')->sortable(),
            Select::make('DNS', 'is_dns')->options($this->is_dns())->displayUsingLabels()->rules('required')->sortable(),
            Select::make('Ip Location', 'is_ip_location')->options($this->is_ip_location())->displayUsingLabels()->rules('required')->sortable(),
            Select::make('Screenshot', 'is_screenshot')->options($this->is_screenshot())->displayUsingLabels()->rules('required')->sortable(),

            HasMany::make('Alternative', 'domain_alternative', \App\Nova\Post::class)->hideFromIndex(),
            HasOne::make('DNS Details', 'DnsDetails_relation', DnsDetail::class)->hideFromIndex(),
            HasOne::make('Ssl Certificate Details', 'Ssl_Details_relation', SslCertificate::class)->hideFromIndex(),
            HasOne::make('Ip Record', 'ip_record_relation', IpRecord::class)->hideFromIndex(),
            HasOne::make('Whois ', 'who_is_relation', WhoIsRecord::class)->hideFromIndex(),
            HasOne::make('Attributes ', 'attributes_relation', Attribute::class)->hideFromIndex(),
            HasOne::make('Seo Analyzer ', 'seo_analyzers_relation', SeoAnalyzer::class)->hideFromIndex(),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
