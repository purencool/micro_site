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
      $testData = HtmlCreation::setChanges(
          DataAlterTest::setChanges(
            DataLayout::getDataLayout(
              RouteData::getData($request->getRequestUri(), 'test')
            )
          )
      );
      return $this->render('layouts/test/index.html.twig', [
          'twig_base_html_path' => 'layouts/test/base.html.twig',
          'title' => 'Style Guide',
          'result' => $testData,
      ]);
    }


    $prodData = HtmlCreation::setChanges(
        DataAlterProd::setChanges(
          DataLayout::getDataLayout(
            RouteData::getData(
              $request->getRequestUri(), 'prod')
          )
        )
    );
    return $this->render('layouts/prod/index.html.twig', [
        'twig_base_html_path' => 'layouts/prod/base.html.twig',
        'title' => 'Style Guide',
        'result' => $prodData,
    ]);
  }

}
