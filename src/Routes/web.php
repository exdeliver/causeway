<?php
/**
 * Protected routes for verified users...
 */

Route::group(['middleware' => ['verified', 'auth']], function () {
    Route::post('/upload/file', 'UploadController@upload')->name('site.upload');
    Route::group(['prefix' => 'forum'], function () {
        Route::get('/get-quote', 'ForumController@getQuoteByComment')->name('site.forum.quote');
        Route::get('/', 'ForumController@index')->name('site.forum.index');
        Route::get('/category/{forumCategory}', 'ForumController@getCategory')->name('site.forum.category');
        Route::get('/category/{forumCategory}/thread/new', 'ForumController@getNewThread')->name('site.forum.thread.new');
        Route::post('/category/{forumCategory}/thread/new', 'ForumController@postNewThread')->name('site.forum.thread.store');
        Route::get('/category/{forumCategory}/thread/{forumThread}', 'ForumController@getThread')->name('site.forum.thread');
    });
// Ajax routing
    Route::group(['prefix' => 'ajax'], function () {
        Route::get('reset/points', 'UserController@reset');
        Route::get('like/type/{type}/id/{id}', 'LikeController@like')->name('like.toggle');
        Route::post('comment/type/{type}/id/{id}', 'CommentController@comment')->name('comment.store');
// Ajax group actions
        Route::group(['prefix' => 'group'], function () {
            Route::get('{label}/members', 'GroupController@getUsersOverviewGroup')->name('ajax.group.members');
            Route::get('index', 'GroupController@getGroupsByUser')->name('ajax.group.index');
        });

        /**
         * Admin protected ajax calls.
         */
        Route::group(['middleware' => ['admin']], function () {
            Route::group(['prefix' => 'events'], function () {
                Route::get('index', 'Admin\EventController@getAjaxEvents')->name('ajax.events.index');
            });

            Route::group(['prefix' => 'pages'], function () {
                Route::get('index', 'Admin\PageController@getAjaxPages')->name('ajax.pages.index');
            });

            Route::group(['prefix' => 'menu'], function () {
                Route::get('index', 'Admin\MenuController@getAjaxMenu')->name('ajax.menu.index');
            });

            Route::group(['prefix' => 'sound'], function () {
                Route::get('index', 'Admin\SoundController@getAjaxPages')->name('ajax.sound.index');
            });

            Route::group(['prefix' => 'forum'], function () {
                Route::get('index', 'Admin\ForumController@getAjaxCategories')->name('ajax.forum.index');
            });
        });
    });

    /**
     * Admin protected routes
     */
    Route::group(['namespace' => 'Admin', 'middleware' => 'admin', 'prefix' => 'admin'], function () {

        Route::get('/', function () {
            return redirect()
                ->route('admin.dashboard');
        });

        Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard');

        Route::group(['prefix' => 'photo'], function () {

            Route::group(['prefix' => 'album'], function () {
                Route::get('/new', 'PhotoAlbumController@createAlbum')->name('admin.photo.album.new');
                Route::post('/new', 'PhotoAlbumController@storeAlbum')->name('admin.photo.album.new.store');
                Route::get('/edit/{photoAlbum}', 'PhotoAlbumController@editAlbum')->name('admin.photo.album.edit');
                Route::post('/edit/{photoAlbum}', 'PhotoAlbumController@storeAlbum')->name('admin.photo.album.edit.store');
                Route::get('/remove/{photoAlbum}', 'PhotoAlbumController@removeAlbum')->name('admin.photo.album.remove');
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

        Route::resource('sound', 'SoundController')->names([
            'index' => 'admin.sound.index',
            'create' => 'admin.sound.create',
            'edit' => 'admin.sound.update',
            'store' => 'admin.sound.new.store',
            'update' => 'admin.sound.update.store',
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

    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', 'Auth\UserProfileController@show')->name('profile');
    });
});

//Route::get('/{pageSlug?}', 'PageController@getSlug');