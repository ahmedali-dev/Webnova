<?php

use Core\Validation\Validation;
// require_once __DIR__.'/../app/Router/Router.php';

// $Router = new \Router\Router();
// $Router->Get("/home");

require __DIR__ . "/../vendor/autoload.php";
Core\Config\ViewSetting::init();
// use Core\Router\Router;
// use Core\Database\User;


// // $router = new Router();
// // $router->get("/", function () {
// //     echo 'hello world';
// // });

// // $router::dis

// Router::get("/", function (Core\Router\Request $req,Core\Router\Response $res) {

//     // $user = new User();
//     // $user->getall();
//     // echo 'hello world from home page';

//     $method = $req->method();
//     $uri = $req->uri();



//     // $req->setcookies('test', ['name'=>'ahmed','age' => '33'], 1);
//     $res->status(200)->json([
//         'message'=> 'error 500',
//         'method' => $method,
//         'uri' => $uri,
//         'cookie' => $req->getcookies('test'),
//         'header' => $req->headers()['Host'],
//         'params'=> $req->params,
//     ]);
// });

// Router::get('/post/{id}', function (Core\Router\Request $req, Core\Router\Response $res) {
//     $res->status(200)->json([
//         'message'=> 'hello from post',
//         'method'=> $req->method(),
//         'url'=> $req->uri(),
//         'params' => $req->params,
//     ]);
// });

// Router::get('/about', function () {
//     echo 'hello from about page';
// });

// Router::get('/post', 'Post@post');
// Router::get('/array', [function(){
//     echo 'hello world<br>';
// }, 'Post@post',function(){
//     echo '<br>hello from thire function';
// }],);


// Router::Dispatch();


use Core\Router\MatchRoute;
use Core\Router\Response;
use Core\Router\Request;
use Core\Validation\Validator;
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