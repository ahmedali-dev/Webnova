<?php

require __DIR__ . "/../vendor/autoload.php";

// Initialize the view directory
Core\Config\ViewSetting::init();



use Core\Router\MatchRoute;
use Core\Router\Response;
use Core\Router\Request;

$route = new MatchRoute();

$route->get("/", function (Request $request, Response $response) {
    $valid = $response->validator([
        // 'name' => ['required', 'string','max:20', 'min:8'],
        // 'email' => ['required', 'email','extension:gmail,hotmail,yahoo,outlook']
        "name" => ['require', 'isString', 'max:20', 'min:8'],
        "email" => ['require', 'isEmail', 'extension:gmail.com,hotmail.com,yahoo.net,outlook.com']
    ]);

    $path = 'User/Home';
    echo '<pre>';
    echo 'error array';
    print_r($valid->errors());
    echo 'validation array';
    print_r($valid->validated());
    echo '</pre>';
    if (count($valid->errors()) > 0) {
        return $response->view($path, ['errors'=> $valid->errors()]);
    }

    
    // print_r($_['GET']);

    $response->view($path, ['name' => 'ahmedali']);

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
        function (Request $request, Response $response) {
            echo 'function from hello/v/{id}/name/{post}' . " " . $request->method;
        },
        'Post@post'
    ]
);

$route->get('/d', function () {
    echo 'd';
});

$route->notFound([
    function () {
        echo 'page is not found please go back and try again';
    },
    'notFound@index'
]);