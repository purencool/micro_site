<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * The ErrorController class completes the following functions.
 *
 * @author purencool
 */
class ErrorController extends AbstractController {

  /**
   * 
   * @param type $parameter
   * @return Response
   */
  public function show() {
    return new Response(
      'Page doesn\'t exist return <a href="/" title="Home">home</a>',
      404
    );
  }

}
