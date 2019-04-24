## Causeway CMS
Content Management System for Laravel 5.7
Written by Jason Hoendervanger - EXdeliver.nl

### Requirements
System requirements for running this content management system:

    MariaDB 10.3
    PHP 7.1.3 or later

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
    
Add to your routes:

    Route::get('/{pageSlug?}', '\Exdeliver\Causeway\Controllers\PageController@getSlug');

##### CW helpers

    // Return specific menu items.
    CW::getMenu('<(string)menu name>')
    
    // Return specific page.
    CW::getPage('<(string)page slug'>);
    
  