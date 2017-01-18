<?php 
spl_autoload_register(function ($className) {
    $classFileName = str_replace("\\", "/", $className);
    require __DIR__ . "/src/{$classFileName}.php";
});