<?php

namespace App\Providers;

use Laravel\Nova\Nova;
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\NovaApplicationServiceProvider;
use SimonHamp\LaravelNovaCsvImport\LaravelNovaCsvImport;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        // Using an array
        \Outl1ne\NovaSettings\NovaSettings::addSettingsFields([
            Panel::make('Panel old', [
                Text::make('2 setting', 'some_setting'),
                Number::make('A2 number', 'a_number'),
            ]),
        ]);

        \Outl1ne\NovaSettings\NovaSettings::addSettingsFields([
            Text::make('Some setting', 'some_setting'),
            Number::make('A number', 'a_number'),
        ], [], 'Subpage');

    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            // ...
            \Outl1ne\MenuBuilder\MenuBuilder::make(),
            new \Stepanenko3\NovaCommandRunner\CommandRunnerTool,
            new \Llaski\NovaScheduledJobs\NovaScheduledJobsTool,
            new \Stepanenko3\LogsTool\LogsTool(),
            new \Outl1ne\NovaSettings\NovaSettings,
            new LaravelNovaCsvImport,

        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function cards()
    {
        return [
            // ...
            new \Llaski\NovaScheduledJobs\NovaScheduledJobsCard,
        ];
    }
}
