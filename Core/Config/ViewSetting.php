<?php

namespace Core\Config;

class ViewSetting {
    public static $mainDir;
    public static $viewsDir;
    public static $controllersDir;

    public static $envFile;

    public static function init() {
        self::$mainDir =getcwd();
        self::$viewsDir = self::$mainDir . "/src/Views/";
        self::$controllersDir = self::$mainDir . "/src/Controllers/";
        self::$envFile = self::$mainDir . "/.env";
    }
}