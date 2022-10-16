<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * The DynamicRoutingController class completes the following functions.
 *  1. 
 *  2. 
 *
 * @author purencool
 */
class DynamicRoutingController extends AbstractController {

  /**
   * 
   * @param type $parameter
   * @return Response
   */
  public function index($parameter = '') {
    // For reference the blocking requests tools are executed 
    // from the following namespace App\EventSubscriber\KernelSubscriber.
    // This allows traffic to be blocked from the kernel.
    
    // Check to see if the request has a test parameter and if the 
    // user is allowed to access the testing caching system.
    if ($parameter === 'test' && $this->getParameter('app.test') === 'true') {
  
      

      return new Response("test");
    }

    return new Response("prod");

    // Route does it exist
    // Is the site enabled
    // Array of variables for the route
    // Twig template directory
    // echo $this->getParameter('app.site'); 
    // echo $this->getParameter('app.layout'); 
    // exit;
    // $return = ['result' => 'Request is not valid'];
    // $path = 'layouts/' . $this->getParameter('app.layout') . '/templates/';
    //return $this->render($path . 'index.html.twig', [
    //     'twig_base_html_path' => $path . "/base.html.twig",
    //     'title' => 'Style Guide',
    //     'result' => $return['result'],
    //  ]);
  }

}
