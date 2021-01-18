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

    // 商品類別-階層1
    $router->group(['namespace' => 'Category', 'prefix' => 'category'], function () use ($router) {
        // 查詢
        $router->get('/', 'Category1Controller@index');
        // 新增
        $router->post('/', 'Category1Controller@store');
        // 修改
        $router->put('/{id}', 'Category1Controller@update');
        // 刪除
        $router->delete('/{id}', 'Category1Controller@destroy');
    });
    // 商品類別-階層2
    $router->group(['namespace' => 'Category', 'prefix' => 'category2'], function () use ($router) {
        // 查詢
        $router->get('/', 'Category2Controller@index');
        // 新增
        $router->post('/', 'Category2Controller@store');
        // 修改
        $router->put('/{id}', 'Category2Controller@update');
        // 刪除
        $router->delete('/{id}', 'Category2Controller@destroy');
    });

    $router->group(['middleware' => ['auth.jwt', 'auth']], function () use ($router) {
        $router->group(['namespace' => 'User'], function() use ($router) {
            // 登入後檢查
            $router->get('/auth', 'UserController@information');
            // 系統登出
            $router->post('/logout', 'UserController@logout');
        });
    });
});
