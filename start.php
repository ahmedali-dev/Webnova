<?php
$os = PHP_OS;

if (strtoupper(substr($os, 0, 3)) === 'WIN') {
    echo "Windows";
    shell_exec("php -S localhost:8080 -t public .\public\index.php");
} elseif (strtoupper($os) === 'DARWIN') {
    echo "Mac";
    shell_exec("php -S localhost:8080 -t public public/index.php");
} else {
    echo "Linux/Unix";
    shell_exec("php -S localhost:8080 -t public public/index.php");
}
