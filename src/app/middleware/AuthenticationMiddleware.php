<?php
namespace App\Middleware;
class AuthenticationMiddleware
{
    private $app;
    
    public function __construct( \Slim\App $app) {
        $this->app = $app;
    }
    
    /**
     * Authentication middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $this->app->getContainer()->logger->addDebug("Checking user authentication");
        $this->app->getContainer()->hybridauth;
        $session_identifier = \Hybrid_Auth::storage()->get('user');
        if (is_null( $session_identifier ) && $this->app->request()->getPathInfo() != '/login/') {
            $thisapp->getContainer()->logger->addInfo("User requires authentication, rerouting to login");
            $this->app->redirect( '/login/' );
        }
        $this->app->getContainer()->logger->addDebug("User authenticated");
        return $next($request, $response);
    }
}