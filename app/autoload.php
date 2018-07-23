<?php

spl_autoload_register(function ($class) {

    $parts = explode('\\', $class);
    $file = end($parts); // namespace + class
    if ($file == 'php') $file = $parts[0];
    require __DIR__ . '/../src/' . $file . '.php';

});