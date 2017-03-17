<?php 
spl_autoload_register(function ($className) {
    $classFileName = str_replace("\\", "/", $className);
    $fileName = __DIR__ . "/src/{$classFileName}.php";
    if (is_file($fileName)) {
        require $fileName;
    }
});