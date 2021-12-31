<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('users', UserController::class);
    $router->resource('polls', PollController::class);
    $router->resource('options', OptionController::class);
    $router->resource('votes', VoteController::class);
    $router->resource('user-banks', UserBankController::class);
    $router->resource('comments', CommentsController::class);

});
