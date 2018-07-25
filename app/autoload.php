<?php

spl_autoload_register(function ($class) {

    $parts = explode('\\', $class);
    $file = end($parts); // namespace + class

    echo $file;
    if (!preg_match_all("/[Spl]{3}[A-z]+/", $file)) {
        if ($file == 'php') $file = $parts[0];
        require __DIR__ . '/../src/' . $file . '.php';
    }
});