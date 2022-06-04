<?php

namespace App\Nova;

use App\Nova\Post;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Manogi\Tiptap\Tiptap;

class SeoAnalyzer extends Resource
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
    public static $model = \App\Models\SeoAnalyzer::class;

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
            Text::make('Language', 'language')->nullable(),
            Text::make('Load Time', 'loadtime')->nullable(),
            Text::make('Code To Txt Ratio', 'codeToTxtRatio')->nullable(),
            Text::make('Word Count', 'word_count')->nullable(),
            KeyValue::make('Keywords', 'keywords')->rules('json')->nullable(),
            KeyValue::make('Long Tail Keywords', 'longTailKeywords')->rules('json')->nullable(),
            KeyValue::make('headers', 'headers')->rules('json')->nullable(),
            KeyValue::make('Links', 'links')->rules('json')->nullable(),
            KeyValue::make('Images', 'images')->rules('json')->nullable(),
            Text::make('Domain Title', 'domain_title')->nullable()->hideFromIndex(),
            Tiptap::make('Domain Description', 'domain_description')
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
