Causeway CMS
Content Management System for Laravel

##### Howto install
composer require exdeliver/causeway

Add to your app.php Aliases

    'CW' => \Exdeliver\Causeway\Facades\CausewayServiceFacade::class,

Update your config/auth.php

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => Exdeliver\Causeway\Domain\Entities\User\User::class,
        ],

And run the publish command:

    php artisan vendor:publish --tag=public --force
    
CW helpers

    // Return specific menu items.
    CW::getMenu('<menu name>')