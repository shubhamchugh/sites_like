<?php

namespace App\Nova;

use App\Nova\SeoAnalyzer;
use Manogi\Tiptap\Tiptap;
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
            Select::make('Post Type', 'post_type')->options([
                'listing' => 'Listing',
                'page'    => 'Page',
            ])->displayUsingLabels()->rules('required')->sortable(),
            Select::make('Status', 'status')->options([
                'publish'   => 'PUBLISH',
                'unpublish' => 'UNPUBLISH',
            ])->displayUsingLabels()->rules('required')->sortable(),
            Boolean::make('Indexing Google', 'is_index_google')->sortable(),
            Boolean::make('Indexing Bing', 'is_index_bing')->sortable(),

            Tiptap::make('Post Content', 'content')
                ->buttons($options)
                ->headingLevels([1, 2, 3, 4])
                ->syntaxHighlighting()
                ->nullable(),
            Image::make('Screenshot', 'image')->disk('public'),
            BelongsToManyField::make('Technologies', 'technologies', Technology::class)->hideFromIndex(),
            BelongsToManyField::make('Alternatives', 'domain_alternative', '\App\Nova\Post')->onlyOnForms(),
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
