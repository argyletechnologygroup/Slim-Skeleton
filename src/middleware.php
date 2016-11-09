<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

//Add SlimApi\OAuth\OAuthMiddleware from container
//$app->add( $app->getContainer()->get(SlimApi\OAuth\OAuthMiddleware::class) );


use Psr7Middlewares\Middleware\TrailingSlash;

$app->add(new TrailingSlash(true)); // true adds the trailing slash (false removes it)