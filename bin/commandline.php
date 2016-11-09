<?php
require __DIR__ . '/../vendor/autoload.php';

//autoload our classes
require __DIR__ . '/../src/autoload.php';

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
\Slim\Http\Environment::mock(array(
    'SCRIPT_NAME'  => '/', //<-- Physical
    'PATH_INFO'    => '/', //<-- Virtual
    'QUERY_STRING' => '',
    'SERVER_NAME'  => 'huntbid.huntrealestate.com',
));
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';
