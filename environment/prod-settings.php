<?php
ini_set('display_errors', 'On');
ini_set('error_reporting', E_ALL);
date_default_timezone_set('UTC');

return [
    'settings' => [
        'displayErrorDetails' => false, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        
        'app' => [
            'shortName' => '', //The short app name text
            'logoMini' => '',// mini logo text
            'logoLg1' => '',//primary large logo text
            'logoLg2' => '',//secondary large logo text
            'compName' => 'Hunt Real Estate', //Legal company name
        ],

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // OAuth Credentials
        'oAuthCreds' => [
            'google' => [ //Google Apps Configuration settings
                'client_id' => '',
                'client_secret' => '',
                'application_name' => '',
            ]
        ],

        'db' => [
            'huntbiddb' => [
                'driver' => 'mysql',
                'host' => 'localhost',
                'port' => '3306',
                'database' => 'huntbid',
                'username' => 'huntbid_rw',
                'password' => '8jU&5eNGk4s8Z!xB',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
            ],
        ],

        'hybridauth' => [
			"base_url" => "", //must match the fully qualified route named 'oauth2endpoint' in src/routes.php
			"providers" => [
				"Google" => [ //Google Apps Configuration settings
					"enabled" => true,
					"keys" => ["id" => "", "secret" => ""],
                    // Example scopes necessary for reading google docs and retrieving basic profile data
                    "scope" => "https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.profile.emails.read ".
                       Google_Service_Drive::DRIVE_READONLY,
                    "access_type"     => "offline",   // optional
                    "approval_prompt" => "auto",     // optional
                ],
			],
			// If you want to enable logging, set 'debug_mode' to true.
			// You can also set it to
			// - "error" To log only error messages. Useful in production
			// - "info" To log info and error messages (ignore debug messages]
			"debug_mode" => 'info',
			// Path to file writable by the web server. Required if 'debug_mode' is not false
			"debug_file" => __DIR__ . '/../logs/hybridauth.log',
        ],
    ],
];
