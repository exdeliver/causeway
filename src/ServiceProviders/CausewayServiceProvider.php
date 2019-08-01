<?php

namespace Exdeliver\Causeway\ServiceProviders;

use Barryvdh\Snappy\Facades\SnappyPdf;
use Exdeliver\Causeway\Commands\CreateAdminCommand;
use Exdeliver\Causeway\Domain\Entities\Forum\Category;
use Exdeliver\Causeway\Domain\Entities\Forum\Thread;
use Exdeliver\Causeway\Domain\Entities\Page\Page;
use Exdeliver\Causeway\Domain\Entities\PhotoAlbum\PhotoAlbum;
use Exdeliver\Causeway\Domain\Entities\Shop\CouponCode;
use Exdeliver\Causeway\Domain\Entities\Shop\Orders\Order;
use Exdeliver\Causeway\Domain\Entities\Shop\Product;
use Exdeliver\Causeway\Domain\Entities\Sound\Sound;
use Exdeliver\Causeway\Domain\Services\CausewayService;
use Exdeliver\Causeway\Events\CausewayRegistered;
use Exdeliver\Causeway\Listeners\AccountVerificationNotification;
use Exdeliver\Causeway\Middleware\CausewayAdmin;
use Exdeliver\Causeway\Middleware\CausewayAuth;
use Exdeliver\Causeway\Middleware\CausewayGuest;
use Exdeliver\Causeway\Middleware\CausewayVerified;
use Exdeliver\Causeway\Validators\CausewayValidators;
use Exdeliver\Causeway\ViewComposers\NavigationComposer;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use OwenIt\Auditing\AuditingServiceProvider;

/**
 * Class CausewayServiceProvider.
 */
class CausewayServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $namespace = 'Exdeliver\Causeway\Controllers';

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CausewayRegistered::class => [
            AccountVerificationNotification::class.'@handle',
        ],
    ];

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    public function boot()
    {
        View::composer(
            'layouts.partials._navigation',
            NavigationComposer::class
        );

        $this->getConfiguration();
        $this->getClassBindings();
        $this->getCommands();
        $this->getRoutes();
        $this->getEventListeners();
        $this->registerPolicies();

        Validator::resolver(function ($translator, $data, $rules, $messages) {
            return new CausewayValidators($translator, $data, $rules, $messages);
        });
    }

    /**
     * Configuration.
     */
    public function getConfiguration()
    {
        $this->registerHelpers();
        $packageRootDir = __DIR__.'/../..';
        $packageWorkingDir = __DIR__.'/..';

        $this->mergeConfigFrom($packageRootDir.'/config/causeway.php', 'causeway');

        $this->publishes([
            $packageRootDir.'/assets/compiled' => public_path('vendor/exdeliver/causeway'),
            $packageWorkingDir.'/Views/site' => $this->app->resourcePath('views/vendor/exdeliver/causeway'),
            $packageRootDir.'/config/laraberg.php' => config_path('laraberg.php'),
        ], 'public');

        $this->publishes([
            $packageWorkingDir.'/Views/site' => $this->app->resourcePath('views/vendor/exdeliver/causeway'),
        ], 'templates');

        $this->loadViewsFrom($packageWorkingDir.'/Views', 'causeway');

        view()->addNamespace('site', [
            $this->app->resourcePath('views/vendor/exdeliver/causeway'),
            $packageWorkingDir.'/Views/site',
        ]);

        $this->loadTranslationsFrom($packageWorkingDir.'/Lang', 'causeway');
        $this->loadMigrationsFrom($packageRootDir.'/database/migrations');
        $this->registerEloquentFactoriesFrom($packageRootDir.'/database/factories');
    }

    /**
     * Helpers file.
     */
    public function registerHelpers()
    {
        $packageWorkingDir = __DIR__.'/..';
        // Load the helpers in app/Http/helpers.php
        if (file_exists($packageWorkingDir.'/Helpers/helpers.php')) {
            include_once $packageWorkingDir.'/Helpers/helpers.php';
        }
        if (file_exists($packageWorkingDir.'/Helpers/countries.php')) {
            include_once $packageWorkingDir.'/Helpers/countries.php';
        }
    }

    /**
     * Register factories.
     *
     * @param string $path
     */
    protected function registerEloquentFactoriesFrom($path)
    {
        $this->app->make(EloquentFactory::class)->load($path);
    }

    /**
     * Class bindings for facades services.
     */
    public function getClassBindings()
    {
        $this->app->bind('causewayservice', function () {
            return app(CausewayService::class);
        });
    }

    /**
     * Registered commands.
     */
    protected function getCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateAdminCommand::class,
            ]);
        }
    }

    /**
     * Route model bindings etc.
     */
    protected function getRoutes()
    {
        $packageWorkingDir = __DIR__.'/..';

        $this->routeModelBindings();

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group($packageWorkingDir.'/Routes/web.php');

        Route::middleware('api')
            ->namespace($this->namespace)
            ->group($packageWorkingDir.'/Routes/api.php');

        $this->loadRoutesFrom($packageWorkingDir.'/Routes/channels.php');
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

        Route::bind('soundName', function ($value) {
            return Sound::where('name', $value)->first();
        });

        Route::bind('user', function ($value) {
            return config('auth.providers.users.model')::findOrFail($value);
        });

        Route::bind('shopCategorySlug', function ($value) {
            return \Exdeliver\Causeway\Domain\Entities\Shop\Category::where('slug', $value)->first();
        });

        Route::bind('shopProductSlug', function ($value) {
            return Product::where('slug', $value)->first();
        });

        Route::bind('orderUuid', function ($value) {
            return Order::where('uuid', $value)->first();
        });

        Route::bind('orderId', function ($value) {
            return Order::where('id', $value)->first();
        });

        Route::bind('couponcode', function ($value) {
            return CouponCode::where('id', $value)->first();
        });

        Route::bind('couponCode', function ($value) {
            return CouponCode::where('coupon_code', $value)->first();
        });
    }

    /**
     * Event listeners.
     */
    public function getEventListeners()
    {
        foreach ($this->listen as $event => $listeners) {
            foreach ($listeners as $listener) {
                Event::listen($event, $listener);
            }
        }
    }

    /**
     * Register the application's policies.
     */
    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    /**
     * Register method.
     */
    public function register()
    {
        $this->registerDependencies();
        $this->registerMiddleware();
    }

    /**
     * Register dependencies.
     */
    public function registerDependencies()
    {
        /*
         * Register ServiceProviders
         */
        $this->app->register(AuditingServiceProvider::class);
        /*
        * Create aliases for the dependency.
        */
        $loader = AliasLoader::getInstance();
        $loader->alias('PDF', SnappyPdf::class);
    }

    /**
     * Registered middleware.
     */
    protected function registerMiddleware()
    {
        $this->app['router']->aliasMiddleware('causewayAdmin', CausewayAdmin::class);
        $this->app['router']->aliasMiddleware('causewayAuth', CausewayAuth::class);
        $this->app['router']->aliasMiddleware('causewayGuest', CausewayGuest::class);
        $this->app['router']->aliasMiddleware('causewayVerified', CausewayVerified::class);
    }
}
