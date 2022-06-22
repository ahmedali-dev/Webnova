<?php

namespace Controller;
require_once __DIR__.'/../Helper/Require.php';
$path = dir(__DIR__."/Function")->path;
RequireFile($path);


class Controller
{
    use \Home, \Login;

    static function Views($file, $params = []) {
        ob_start();
        require_once __DIR__."/../Views/$file.php";
        $content = ob_get_clean();
        require_once  __DIR__."/../Views/Layout/Layout.php";
        ob_end_flush();
    }
}