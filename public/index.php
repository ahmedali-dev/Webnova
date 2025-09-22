<?php

require __DIR__ . "/../vendor/autoload.php";

// Initialize the view directory
Core\Config\ViewSetting::init();
// load env variable from '.env'
Core\Utils\DotEnv::loader();



$route = Core\Router\Route::route();
use Core\Router\Response;
use Core\Router\Request;



$route->get("/", function (Request $request, Response $response) {
    $response->view("welcome");
});

$route->post('/', function (Request $request, Response $response) {
    $response->status(301)->json([
        'msg' => 'welcome in my project'
    ]);
});

$route->get('/hello', function () {
    echo 'make';
});

$route->get('/hello/v', function () {
    echo 'make';
});

$route->get('/hello/v/{id}', function () {
    echo 'make';
});

$route->get('/hello/v/{id}/name', function (Request $request, Response $response) {
    echo 'make' . $request->params['id'];
});

$route->get(
    '/hello/v/{id}/name/{post}',
    [
        function (Request $request, Response $response, $next) {
            echo 'function from hello/v/{id}/name/{post}' . " " . $request->method;
            $next();
        },
        'Post@post',
        function($req,$res,$con) {
            echo '<hr> from Third function';
            echo 'hello world';
        }
    ]
);

$route->get('/d', function () {
    echo 'd';
});

$route->notFound([
    // function () {
    //     echo 'page is not found please go back and try again';
    // },
    'notFound@index'
]);