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
    $return = ['result' => 'Request is not valid'];
    $path = 'layouts/one_column/templates';
    return $this->render($path . '/index.html.twig', [
        'title' => 'Style Guide',
        'result' => $return['result'],
    ]);
  }

}
