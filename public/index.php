<?php
// require_once __DIR__.'/../app/Router/Router.php';

// $Router = new \Router\Router();
// $Router->Get("/home");

require __DIR__ . "/../vendor/autoload.php";
use App\Router\Router;
use App\Database\User;
// $router = new Router();
// $router->get("/", function () {
//     echo 'hello world';
// });

// $router::dis

Router::get("/", function () {
    $user = new User();
    $user->getall();
    echo 'hello world from home page';
});

Router::get('/about', function () {
    echo 'hello from about page';
});

Router::get('/post', 'Post@post');
Router::get('/array', [function(){
    echo 'hello world<br>';
}, 'Post@post',function(){
    echo '<br>hello from thire function';
}],);


Router::Dispatch();