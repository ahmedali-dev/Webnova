<?php
$os = PHP_OS;

echo "Server running at http://localhost:8080 \r\n";


if (strtoupper(substr($os, 0, 3)) === 'WIN') {
    echo "\r\nWindows\r\n";
    shell_exec("php -S localhost:8080 -t public .\public\index.php");
} elseif (strtoupper($os) === 'DARWIN') {
    echo "\r\nMac\r\n";
    shell_exec("php -S localhost:8080 -t public public/index.php");
} else {
    echo "\r\nLinux/\r\nUnix";
    shell_exec("php -S localhost:8080 -t public public/index.php");
}

