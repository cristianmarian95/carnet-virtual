<?php

if (PHP_SAPI == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/src/vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/src/configs/configs.php';
$app = new \Slim\App($settings);

// Set up initialization
require __DIR__ . '/src/init/init.php';

// Register routes
require __DIR__ . '/src/init/routes.php';

// Run app
$app->run();