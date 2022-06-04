<?php

namespace App\Nova;

use App\Nova\Post;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class WhoIsRecord extends Resource
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
    public static $model = \App\Models\WhoIsRecord::class;

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

            Text::make('Whois Text', 'text')->nullable(),

            Text::make('Whois Server', 'whoisServer')->nullable(),

            KeyValue::make('Name Servers', 'nameServers')->rules('json')->nullable(),

            Date::make('Updated Date', 'creationDate')->nullable(),
            Date::make('Expiration Date', 'expirationDate')->nullable(),
            Date::make('Updated Date', 'updatedDate')->nullable(),

            KeyValue::make('States', 'states')->rules('json')->nullable(),

            Text::make('Owner', 'owner')->nullable(),
            Text::make('Owner', 'registrar')->nullable(),
            Text::make('dnssec', 'dnssec')->nullable(),
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
