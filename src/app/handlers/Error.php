<?php
 
namespace App\Handlers;
 
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Monolog\Logger;

// php extension error handler to log errors
final class Error extends \Slim\Handlers\PhpError
{
    protected $logger;
 
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }
 
    public function __invoke(Request $request, Response $response, \Exception $exception)
    {
        // Log the message
        $this->logger->critical($exception->getMessage());
 
        return parent::__invoke($request, $response, $exception);
    }
 
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, \Throwable $error)
    {
        // Log the message
        $this->logger->critical($error->getMessage());
 
        return parent::__invoke($request, $response, $error);
    }
}