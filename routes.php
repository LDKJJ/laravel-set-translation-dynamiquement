<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('import', ImportController::class);
    $router->resource('groups', GroupController::class);
    $router->resource('languages', LanguageController::class);
    $router->resource('users', UserController::class);
    $router->resource('roles', RoleController::class);
    $router->resource('permissions', PermissionController::class);
    $router->resource('translations', TranslationController::class);
    $router->post('/translations/getlanguages', 'TranslationController@GetLanguageArray');
    $router->post('/translations/setlanguages', 'TranslationController@SetLanguageArray');
    // $router->resource('hosts', HostController::class);

});
