<?php
require_once __DIR__.'/../app/Router/Router.php';

$Router = new \Router\Router();
$Router->Get("/home");
