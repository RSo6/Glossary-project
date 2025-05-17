<?php

spl_autoload_register(function ($class) {
    $prefixes = [
        'admin\\'      => __DIR__ . '/admin/',
        'controllers\\'=> __DIR__ . '/controllers/',
        'models\\'     => __DIR__ . '/models/',
    ];

    foreach ($prefixes as $prefix => $base_dir) {
        if (strncmp($prefix, $class, strlen($prefix)) === 0) {
            $relative_class = substr($class, strlen($prefix));
            $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

            if (file_exists($file)) {
                require $file;
                return;
            }
        }
    }
});
