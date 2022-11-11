<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\Observers\RouteData;
use App\Controller\Observers\DataAlterTest;
use App\Controller\Observers\DataAlterProd;
use App\Controller\Observers\DataLayout;
use App\Controller\Observers\HtmlCreation;

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
      'Page doesn\'t exist return <a href="/" title="Home">home</a>'
    );
  }

}
