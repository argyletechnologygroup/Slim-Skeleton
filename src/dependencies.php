<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler(
        $settings['path'],
        $settings['level']
    ));
    return $logger;
};

// custom logging error handler
$container['phpErrorHandler'] = function ($c) {
    return new App\Handlers\Error($c['logger']);
};

// Service factory for the ORM
$container['db'] = function ($container) {
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']['huntbiddb']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    return $capsule;
};

$container['model'] = function ($c) {
    $db = $c->get('db');
    
    return [
        'leads' => new \App\Model\Leads($c),
        'users' => new \App\Model\Users($c),
    ];
};

// hybridauth
$container['hybridauth'] = function($container) {
    return new Hybrid_Auth($container->get('settings')['hybridauth']);
};

// socialauth implementation
$container['socialauth'] = function($container) {
    $container->get('model'); //ensure the model has been setup
    return new \App\Model\SocialLogins(  );
};

// google hybridauth provider adapter
$container['google_hybrid_adapter'] = function($container) {
    $adapter = $container->get('hybridauth')->getAdapter('Google'); // get the google adapter
    return $adapter;
};

// google OAuth2Client
$container['google_api_oauth'] = function($c) {
    return $c->get('google_hybrid_adapter')->api();
};

$container['google_client'] = function($c) {
    $googleAdapter = $c->get('google_hybrid_adapter');
    $google_oauth = $c->get('google_api_oauth');
    $config =[
        'client_id' => $google_oauth->client_id,
        'client_secret' => $google_oauth->client_secret,
        'scopes' =>  explode(' ', $googleAdapter->config['scope']),
        'redirect_uri' => $c->get('settings')['hybridauth']['base_url'],
        'access_type' => $googleAdapter->config['access_type'],
        'approval_prompt' => $googleAdapter->config['approval_prompt'],
    ];
    $client = new Google_Client($config);
    $client->setLogger($c->get('logger'));
    $token = $googleAdapter->getAccessToken();
    //the google library mis-uses this value currently instead of expires_at, so we need to adjust it
    $token['expires_in'] = $token['expires_in'] + time();
    $client->setAccessToken( json_encode($token));
    return $client; //Return the currently logged in user's google client
};

$container['google_service_drive'] = function($c) {
    return new Google_Service_Drive($c->get('google_client'));
};

// slim-oauth
/*
$container[SlimApi\OAuth\OAuthFactory::class] = function($container) {
    return new SlimApi\OAuth\OAuthFactory($container->get('settings')['oAuthCreds']);
};

$container[SlimApi\OAuth\UserServiceInterface::class] = function($container) {
    //user service should implement SlimApi\OAuth\UserServiceInterface
    //user model should have a token variable to hold the random token sent to the client
    //$usermodel = App\Model\User; // $container->get('db')->table('google_tokens');
    return new App\Service\Google\UserService(new App\Model\GoogleToken());
};

$container[SlimApi\OAuth\OAuthMiddleware::class] = function($container) {
    return new SlimApi\OAuth\OAuthMiddleware(
        $container->get(SlimApi\OAuth\OAuthFactory::class),
        $container->get(SlimApi\OAuth\UserServiceInterface::class)
    );
};
*/
