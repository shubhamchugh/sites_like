<?php

namespace App\Nova;

use App\Nova\Post;
use Manogi\Tiptap\Tiptap;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class DnsDetail extends Resource
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
    public static $model = \App\Models\DnsDetail::class;

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

            ID::make()->sortable(),
            Tiptap::make('A', 'A')
                ->buttons($options)
                ->headingLevels([1, 2, 3, 4])
                ->syntaxHighlighting()
                ->nullable(),
            Tiptap::make('AAAA', 'AAAA')
                ->buttons($options)
                ->headingLevels([1, 2, 3, 4])
                ->syntaxHighlighting()
                ->nullable(),
            Tiptap::make('CNAME', 'CNAME')
                ->buttons($options)
                ->headingLevels([1, 2, 3, 4])
                ->syntaxHighlighting()
                ->nullable(),
            Tiptap::make('NS', 'NS')
                ->buttons($options)
                ->headingLevels([1, 2, 3, 4])
                ->syntaxHighlighting()
                ->nullable(),
            Tiptap::make('SOA', 'SOA')
                ->buttons($options)
                ->headingLevels([1, 2, 3, 4])
                ->syntaxHighlighting()
                ->nullable(),
            Tiptap::make('MX', 'MX')
                ->buttons($options)
                ->headingLevels([1, 2, 3, 4])
                ->syntaxHighlighting()
                ->nullable(),
            Tiptap::make('SRV', 'SRV')
                ->buttons($options)
                ->headingLevels([1, 2, 3, 4])
                ->syntaxHighlighting()
                ->nullable(),
            Tiptap::make('TXT', 'TXT')
                ->buttons($options)
                ->headingLevels([1, 2, 3, 4])
                ->syntaxHighlighting()
                ->nullable(),
            Tiptap::make('CAA', 'CAA')
                ->buttons($options)
                ->headingLevels([1, 2, 3, 4])
                ->syntaxHighlighting()
                ->nullable(),

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
