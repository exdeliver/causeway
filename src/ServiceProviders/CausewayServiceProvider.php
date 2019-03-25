<?php

namespace Exdeliver\Causeway\ServiceProviders;

use Exdeliver\Causeway\Domain\Entities\Forum\Category;
use Exdeliver\Causeway\Domain\Entities\Forum\Thread;
use Exdeliver\Causeway\Domain\Entities\Page\Page;
use Exdeliver\Causeway\Domain\Entities\PhotoAlbum\PhotoAlbum;
use Exdeliver\Causeway\Middleware\Admin;
use Exdeliver\Causeway\ViewComposers\NavigationComposer;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * Class CausewayServiceProvider
 * @package Exdeliver\Causeway\ServiceProviders
 */
class CausewayServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $namespace = 'Exdeliver\Causeway\Controllers';

    /**
     *
     */
    public function boot()
    {
        View::composer(
            'layouts.partials._navigation', NavigationComposer::class
        );

        $this->getConfiguration();
        $this->getCommands();
        $this->getRoutes();
    }

    /**
     * Configuration
     */
    public function getConfiguration()
    {
        $packageRootDir = __DIR__ . '/../..';
        $packageWorkingDir = __DIR__ . '/..';

        $this->publishes([
            $packageRootDir . '/config/causeway.php' => config_path('causeway.php'),
        ]);

        $this->publishes([
            $packageRootDir . '/assets' => public_path('vendor/causeway'),
        ], 'public');

        $this->publishes([

        ], 'controller');

        $this->loadViewsFrom($packageWorkingDir . '/Views', 'causeway');
        $this->loadTranslationsFrom($packageWorkingDir . '/Lang', 'causeway');

        $this->registerEloquentFactoriesFrom($packageRootDir . '/database/factories');
    }

    /**
     * Register factories.
     *
     * @param  string  $path
     * @return void
     */
    protected function registerEloquentFactoriesFrom($path)
    {
        $this->app->make(EloquentFactory::class)->load($path);
    }

    protected function getCommands()
    {
//        if ($this->app->runningInConsole()) {
//            $this->commands([
//                FooCommand::class,
//                BarCommand::class,
//            ]);
//        }
    }

    /**
     * Route model bindings etc.
     */
    protected function getRoutes()
    {
        $packageWorkingDir = __DIR__ . '/..';

        $this->routeModelBindings();

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group($packageWorkingDir . '/Routes/web.php');

        Route::middleware('api')
            ->namespace($this->namespace)
            ->group($packageWorkingDir . '/Routes/api.php');

        $this->loadRoutesFrom($packageWorkingDir . '/Routes/channels.php');
    }

    /**
     * Route model bindings.
     */
    protected function routeModelBindings()
    {
        Route::bind('photoAlbum', function ($value) {
            return PhotoAlbum::where('label', $value)->first();
        });

        Route::bind('forumCategory', function ($value) {
            return Category::where('slug', $value)->first();
        });

        Route::bind('forumThread', function ($value) {
            return Thread::where('slug', $value)->first();
        });

        Route::bind('pageSlug', function ($value) {
            return Page::whereTranslation('slug', $value)->first();
        });
    }

    public function register()
    {
        $this->registerMiddleware();
    }

    protected function registerMiddleware()
    {
        $this->app['router']->aliasMiddleware('admin' , Admin::class);
    }
}