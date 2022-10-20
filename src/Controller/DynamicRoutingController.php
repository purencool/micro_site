<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\Observers\RouteData;

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
  public function index(Request $request, $parameter = '') {
    // For reference the blocking requests tools are executed 
    // from the following namespace App\EventSubscriber\KernelSubscriber.
    // This allows traffic to be blocked from the kernel.

    $appTest = $this->getParameter('app.test');

    // Check to see if the request has a json parameter and if so the 
    // user is allowed to access the content caching system in json.
    if ($parameter === 'json') {
      return new Response(
        json_encode(RouteData::getData($request->getRequestUri())['@data'])
      );
    }

    // Check to see if the request has a test parameter and if the 
    // user is allowed to access the testing caching system.
    if ($parameter === 'test' && $appTest === 'true') {
            return new Response(
        json_encode(RouteData::getData($request->getRequestUri()))
      );
    }

    return new Response(
        json_encode(RouteData::getData($request->getRequestUri()))
    );

    // $path = 'layouts/' . $this->getParameter('app.layout') . '/templates/';
    //return $this->render($path . 'index.html.twig', [
    //     'twig_base_html_path' => $path . "/base.html.twig",
    //     'title' => 'Style Guide',
    //     'result' => $return['result'],
    //  ]);
  }

}
