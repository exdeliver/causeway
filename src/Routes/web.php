<?php

/**
 * Prefix: sound/.
 */
Route::group(['prefix' => 'sound'], function () {
    Route::get('{name}', 'SoundController@getSound')->name('causeway.sound.play');
});

/*
 * Localisation
 *
 * Prefix: js/
 */
Route::get('/js/lang.js', function () {
    $strings = Cache::rememberForever('lang.js', function () {
        $lang = config('app.locale');
        $files = glob(__DIR__.'/../Lang/'.$lang.'/*.php');
        $strings = [];

        foreach ($files as $file) {
            $name = basename($file, '.php');
            $strings[$name] = require $file;
        }

        return $strings;
    });

    header('Content-Type: text/javascript');
    echo 'window.i18n = '.json_encode($strings).';';
    exit();
})->name('assets.lang');

/*
 * Prefix: forum/
 */
Route::group(['prefix' => 'forum'], function () {
    Route::get('/', 'ForumController@index')->name('site.forum.index');
    Route::get('/category/{forumCategory}', 'ForumController@getCategory')->name('site.forum.category');
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/category/{forumCategory}/thread/new', 'ForumController@getNewThread')->name('site.forum.thread.new');
        Route::post('/category/{forumCategory}/thread/new', 'ForumController@postNewThread')->name('site.forum.thread.store');
        Route::get('/get-quote', 'ForumController@getQuoteByComment')->name('site.forum.quote');
    });
    Route::get('/category/{forumCategory}/thread/{forumThread}', 'ForumController@getThread')->name('site.forum.thread');
});

include 'shop_routes.php';

/*
 * Prefix: causeway/
 */
Route::group(['prefix' => 'causeway'], function () {
    Route::post('/logout', function () {
        Auth::logout();

        return redirect()
            ->route('causeway.login');
    })->name('causeway.logout');

    Route::group(['middleware' => ['causewayGuest']], function () {
        Route::get('/login', 'Auth\LoginController@showLoginForm')->name('causeway.login');
        Route::post('/login', 'Auth\LoginController@login')->name('causeway.login');
        Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('causeway.register');
        Route::post('/register', 'Auth\RegisterController@register')->name('causeway.register');

        Route::get('/password/request', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('causeway.password.request');
        Route::post('/password/reset', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('causeway.password.email');
        Route::get('/password/reset', 'Auth\VerificationController@verify')->name('causeway.verification.verify');
    });

    Route::group(['middleware' => ['causewayAuth']], function () {
        Route::get('/account/verified', 'Auth\VerificationController@show')->name('causeway.verification.notice');
        Route::get('/account/verified/resend', 'Auth\VerificationController@resend')->name('causeway.verification.resend');
    });

    /*
     * Protected routes for verified users...
     */
    Route::group(['middleware' => ['causewayVerified', 'causewayAuth']], function () {
        Route::post('/upload/file', 'UploadController@upload')->name('site.upload');

        /*
         * Ajax routing
         *
         * Prefix: causeway/ajax
         */
        Route::group(['prefix' => 'ajax'], function () {
            Route::get('reset/points', 'UserController@reset');
            Route::get('like/type/{type}/id/{id}', 'LikeController@like')->name('like.toggle');
            Route::post('comment/type/{type}/id/{id}', 'CommentController@comment')->name('comment.store');

            /*
             * Ajax group actions
             *
             * Prefix: causeway/ajax/group
             */
            Route::group(['prefix' => 'group'], function () {
                Route::get('{label}/members', 'GroupController@getUsersOverviewGroup')->name('ajax.group.members');
                Route::get('index', 'GroupController@getGroupsByUser')->name('ajax.group.index');
            });

            /*
             * Admin protected ajax calls.
             */
            Route::group(['middleware' => ['causewayAdmin']], function () {
                /*
                 * Prefix: causeway/ajax/events
                 */
                Route::group(['prefix' => 'events'], function () {
                    Route::get('index', 'Admin\EventController@getAjaxEvents')->name('ajax.events.index');
                });

                /*
                 * Prefix: causeway/ajax/pages
                 */
                Route::group(['prefix' => 'pages'], function () {
                    Route::get('index', 'Admin\PageController@getAjaxPages')->name('ajax.pages.index');
                });

                /*
                 * Prefix: causeway/ajax/menu
                 */
                Route::group(['prefix' => 'menu'], function () {
                    Route::get('index', 'Admin\MenuController@getAjaxMenu')->name('ajax.menu.index');
                });

                /*
                 * Prefix: causeway/ajax/sound
                 */
                Route::group(['prefix' => 'sound'], function () {
                    Route::get('index', 'Admin\SoundController@getAjaxSounds')->name('ajax.sound.index');
                });

                /*
                 * Prefix: causeway/ajax/forum
                 */
                Route::group(['prefix' => 'forum'], function () {
                    Route::get('index', 'Admin\ForumController@getAjaxCategories')->name('ajax.forum.index');
                });

                /*
                 * Prefix: causeway/ajax/authorisation
                 */
                Route::group(['prefix' => 'authorisation'], function () {
                    Route::get('users/index', 'Admin\Authorisation\UserController@getAjaxUsers')->name('ajax.authorisation.users.index');
                    Route::get('roles/index', 'Admin\Authorisation\RoleController@getAjaxRoles')->name('ajax.authorisation.roles.index');
                    Route::get('permission/index', 'Admin\Authorisation\PermissionController@getAjaxPermissions')->name('ajax.authorisation.permission.index');
                });
            });
        });

        /*
         * Admin protected routes
         */
        Route::group(['namespace' => 'Admin', 'middleware' => ['causewayAdmin']], function () {
            Route::get('/', function () {
                return redirect()
                    ->route('causeway.dashboard');
            });

            Route::get('/dashboard', 'DashboardController@index')->name('causeway.dashboard');

            /*
             * Prefix: causeway/photo/
             */
            Route::group(['prefix' => 'photo'], function () {
                /*
                 * Prefix: causeway/photo/album
                 */
                Route::group(['prefix' => 'album'], function () {
                    Route::get('/new', 'PhotoAlbumController@createAlbum')->name('admin.photo.album.new');
                    Route::post('/new', 'PhotoAlbumController@storeAlbum')->name('admin.photo.album.new.store');
                    Route::get('/edit/{album}', 'PhotoAlbumController@editAlbum')->name('admin.photo.album.edit');
                    Route::post('/edit/{album}', 'PhotoAlbumController@storeAlbum')->name('admin.photo.album.edit.store');
                    Route::get('/remove/{album}', 'PhotoAlbumController@removeAlbum')->name('admin.photo.album.remove');
                    Route::get('/{photoAlbum?}', 'PhotoAlbumController@index')->name('admin.photo.album.index');
                });

                Route::get('/new', 'PhotoAlbumController@newPhoto')->name('admin.photo.create');
                Route::post('/new', 'PhotoAlbumController@storePhoto')->name('admin.photo.new.store');
                Route::get('/edit/{photo}', 'PhotoAlbumController@editPhoto')->name('admin.photo.edit');
                Route::post('/edit/{photo}', 'PhotoAlbumController@storePhoto')->name('admin.photo.new.store');
                Route::get('/remove/{photo}', 'PhotoAlbumController@removePhoto')->name('admin.photo.remove');
                Route::post('/upload', 'PhotoAlbumController@upload')->name('admin.photo.upload');
            });

            Route::resource('events', 'EventController')->names([
                'index' => 'admin.events.index',
                'create' => 'admin.events.create',
                'edit' => 'admin.events.update',
                'store' => 'admin.events.new.store',
                'update' => 'admin.events.update.store',
                'destroy' => 'admin.events.remove',
            ]);

            Route::resource('pages', 'PageController')->names([
                'index' => 'admin.pages.index',
                'create' => 'admin.pages.create',
                'edit' => 'admin.pages.update',
                'store' => 'admin.pages.new.store',
                'update' => 'admin.pages.update.store',
                'destroy' => 'admin.pages.destroy',
            ]);

            /**
             * Prefix: causeway/shop.
             */
            include 'admin_shop_routes.php';

            Route::resource('sound', 'SoundController')->names([
                'index' => 'admin.sound.index',
                'create' => 'admin.sound.create',
                'edit' => 'admin.sound.update',
                'store' => 'admin.sound.new.store',
                'update' => 'admin.sound.update.store',
                'destroy' => 'admin.sound.destroy',
            ]);

            Route::resource('forum', 'ForumController')->names([
                'index' => 'admin.forum.index',
                'create' => 'admin.forum.create',
                'edit' => 'admin.forum.update',
                'store' => 'admin.forum.new.store',
                'update' => 'admin.forum.update.store',
                'destroy' => 'admin.forum.remove',
            ]);

            Route::get('forum/index/sort', 'ForumController@sortCategory')->name('admin.forum.index.sort');

            Route::get('menu/item/create/{menu}', 'MenuController@createItem')->name('admin.menu.item.create');
            Route::get('menu/item/{menu}/edit/{item}', 'MenuController@editItem')->name('admin.menu.item.edit');
            Route::post('menu/item/create/{menu}', 'MenuController@storeItem')->name('admin.menu.item.store');
            Route::put('menu/item/{menu}/edit/{item}', 'MenuController@updateItem')->name('admin.menu.item.update');
            Route::delete('menu/item/{menu}/remove/{item}', 'MenuController@destroyItem')->name('admin.menu.item.destroy');

            Route::resource('menu', 'MenuController')->names([
                'index' => 'admin.menu.index',
                'create' => 'admin.menu.create',
                'edit' => 'admin.menu.update',
                'destroy' => 'admin.menu.remove',
                'show' => 'admin.menu.show',
                'store' => 'admin.menu.new.store',
                'update' => 'admin.menu.update.store',
            ]);
            Route::post('menu/show/{menu}/sort', 'MenuController@sort')->name('admin.menu.show.sort');

            /*
             * Prefix: causeway/authorisation
             */
            Route::group(['prefix' => 'authorisation', 'namespace' => 'Authorisation'], function () {
                Route::resource('user', 'UserController')->names([
                    'index' => 'admin.authorisation.user.index',
                    'create' => 'admin.authorisation.user.create',
                    'edit' => 'admin.authorisation.user.update',
                    'store' => 'admin.authorisation.user.store',
                    'update' => 'admin.authorisation.user.update.store',
                    'destroy' => 'admin.authorisation.user.remove',
                ]);

                Route::resource('role', 'RoleController')->names([
                    'index' => 'admin.authorisation.role.index',
                    'create' => 'admin.authorisation.role.create',
                    'edit' => 'admin.authorisation.role.update',
                    'store' => 'admin.authorisation.role.store',
                    'update' => 'admin.authorisation.role.update.store',
                    'destroy' => 'admin.authorisation.role.remove',
                ]);

                Route::resource('permission', 'PermissionController')->names([
                    'index' => 'admin.authorisation.permission.index',
                    'create' => 'admin.authorisation.permission.create',
                    'edit' => 'admin.authorisation.permission.update',
                    'store' => 'admin.authorisation.permission.store',
                    'update' => 'admin.authorisation.permission.update.store',
                    'destroy' => 'admin.authorisation.permission.remove',
                ]);
            });
        });

        /*
         * Prefix: causeway/profile
         */
        Route::group(['prefix' => 'profile'], function () {
            //Route::get('/', 'Auth\UserProfileController@show')->name('profile');
        });
    });
});
