Causeway CMS
Content Management System for Laravel

##### Howto install
composer require exdeliver/causeway

Update your config/auth.php

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => Exdeliver\Causeway\Domain\Entities\User\User::class,
        ],

