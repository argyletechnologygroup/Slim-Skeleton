<?php namespace App\Controller;
use Interop\Container\ContainerInterface;

class BaseController {
    
   protected $ci;
   protected $logger;
   
   //Constructor
   public function __construct(ContainerInterface $ci) {
       $this->ci = $ci;
       $this->logger = $this->ci->get('logger'); //since it is used so much, we get the logger immediately
   }

    public static function renderWithLayout($renderer, $response, $template, $layout, $data=[]) {
        $renderer->addAttribute('content_template', $template);
        $renderer->addAttribute('response', $response);
        return $renderer->render($response, $layout, $data);
    }
}
 