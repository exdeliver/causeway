## Causeway CMS
Content Management System for Laravel 5.7

##### Howto install
composer require exdeliver/causeway

Add to your app.php providers & Aliases

    \Exdeliver\Causeway\ServiceProviders\CausewayServiceProvider::class,
    
    'CW' => \Exdeliver\Causeway\Facades\CausewayServiceFacade::class,

Update your config/auth.php

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => Exdeliver\Causeway\Domain\Entities\User\User::class,
        ],

And run the publish command:

    php artisan vendor:publish --tag=public --force
    
Run migrations:

    php artisan migrate --path=vendor/exdeliver/causeway/database/migrations
    
Add to your routes:

    Route::get('/{pageSlug?}', '\Exdeliver\Causeway\Controllers\PageController@getSlug');

##### CW helpers

    // Return specific menu items.
    CW::getMenu('<(string)menu name>')
    
    // Return specific page.
    CW::getPage('<(string)page slug'>);
    
  