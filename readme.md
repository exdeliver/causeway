## Causeway CMS
Content Management System for Laravel 7
Written by Jason Hoendervanger - EXdeliver.nl

### Requirements
System requirements for running this content management system:

    MariaDB 10.3
    PHP 7.2 or later
    (optional for sound plugin) LAME encoder (apt-get install lame)

##### Howto install
composer require exdeliver/causeway

Add to your app.php providers & Aliases

    \Exdeliver\Causeway\ServiceProviders\CausewayServiceProvider::class,
    
    'CW' => \Exdeliver\Causeway\Facades\CausewayServiceFacade::class,
    
    'CWCart' => \Exdeliver\Cart\Facades\CartServiceFacade::class,

Update your config/auth.php

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => Exdeliver\Causeway\Domain\Entities\User\User::class,
        ],
        
        Or create your own user model and extend with above.
        
Update your .env

    MOLLIE_LIVE_API_KEY=
    MOLLIE_TEST_API_KEY=test_MeT7ZndwP8wVBkGpDSGnpAa88npKLe
    CAUSEWAY_VAT_PERCENTAGES='{"0.00": "0%", "9.00": "9%", "21.00": "21%"}'
    CAUSEWAY_COMPANY_INFORMATION='{"company": "EXdeliver", "address": "YourCompanyStreet 22", "zipcode": "0000 TT", "city": "Rotterdam", "country": "The Netherlands", "vat_no": "NL6500000", "coc_no": "20000000", "email": "info@mail.nl", "bank_account": "NL00INGB000123456", "bank_name": "ING"}'
        
Run the migrations

    php artisan migrate
    
Publish config for Laravel filemanager

    php artisan vendor:publish --tag=lfm_config
    php artisan vendor:publish --tag=lfm_public

And run the publish command:

    php artisan vendor:publish --tag=public --force
    
    php artisan vendor:publish --tag=templates (--fore optional overwrites all)
    
Create a admin user by running the command below:

    php artisan causeway:admin <username> <password>
    
If you haven't already made a symlink, do accordingly.

    php artisan storage:link
    
Add to your routes:

    Route::get('/{pageSlug?}', '\Exdeliver\Causeway\Controllers\PageController@getSlug');
    
Login:

    http://yoursite.nl/causeway/login

##### CW helpers

    // Return specific menu items.
    CW::getMenu('<(string)menu name>')
    
    // Return specific page.
    CW::getPage('<(string)page slug'>);
