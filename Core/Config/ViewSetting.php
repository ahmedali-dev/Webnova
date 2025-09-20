<?php

namespace Core\Config;

class ViewSetting {
    public static $mainDir;
    public static $viewsDir;
    public static $controllersDir;

    public static function init() {
        self::$mainDir = __DIR__ . "/../../src";
        self::$viewsDir = self::$mainDir . "/Views/";
        self::$controllersDir = self::$mainDir . "/Controllers/";
    }
}