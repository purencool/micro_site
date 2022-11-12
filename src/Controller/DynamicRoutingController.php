<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\Observers\RouteDataProcess;

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
        json_encode(
          RouteData::getData(
            $request->getRequestUri(),
            'prod'
          )['data']['@data_array']
        )
      );
    }

    // Check to see if the request has a test parameter and if the 
    // user is allowed to access the testing caching system.
    if ($parameter === 'test' && $appTest === 'true') {
      $testData = RouteDataProcess::getRouteTest( $request->getRequestUri());
      return $this->render('layouts/test/index.html.twig', [
          'twig_base_html_path' => 'layouts/test/base.html.twig',
          'header_title' => $testData['title'] ,
          'asset_path' => $request->getSchemeAndHttpHost().'/test/',    
          'body' =>$testData['body'],
      ]);
    }
    elseif ($parameter === 'test') {
      return new Response(
        'Page doesn\'t exist return <a href="/" title="Home">home</a>',
        404
      );
    }

    $prodData = RouteDataProcess::getRouteProd($request->getRequestUri());
    return $this->render('layouts/prod/index.html.twig', [
        'twig_base_html_path' => 'layouts/prod/base.html.twig',
        'header_title' => $prodData['title'],
        'asset_path' => $request->getSchemeAndHttpHost().'/prod/',  
        'body' => $prodData['body'],
    ]);
  }

}
