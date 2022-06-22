<?php
    function RequireFile($path) {
        $dir = $path;
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if (is_file($dir . "/$file")) {
                        require_once  $dir . "/$file";
                    }
                }
                closedir($dh);
            }
        }
    }

