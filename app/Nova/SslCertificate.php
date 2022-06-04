<?php

namespace App\Nova;

use App\Nova\Post;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class SslCertificate extends Resource
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
    public static $model = \App\Models\SslCertificate::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Issuer', 'issuer')->nullable(),
            Text::make('GetSignatureAlgorithm', 'getSignatureAlgorithm')->nullable(),
            Text::make('GetOrganization', 'getOrganization')->nullable(),
            KeyValue::make('GetAdditionalDomains', 'getAdditionalDomains')->rules('json')->nullable(),
            Text::make('GetFingerprint', 'getFingerprint')->nullable(),
            Text::make('GetFingerprintSha256', 'getFingerprintSha256')->nullable(),
            DateTime::make('Valid FromDate', 'validFromDate')->nullable()->nullable(),
            DateTime::make('Expiration Date', 'expirationDate')->nullable()->nullable(),
            Text::make('Is Valid', 'isValid')->nullable(),
            BelongsTo::make('Post', 'posts_relation', Post::class)->searchable(),
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
