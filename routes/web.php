<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    // 驗證碼
    $router->get('captcha', function () use ($router) {
        return app('captcha')->create('math');
    });

    $router->group(['namespace' => 'System'], function () use ($router) {
        // 登入
        $router->post('login', 'SystemController@login');
        // 註冊
        $router->post('register', 'SystemController@register');

    });
});
