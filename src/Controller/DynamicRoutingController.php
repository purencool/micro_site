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
          RouteDataProcess::getRouteJson($request->getRequestUri())
        )
      );
    }

    // Check to see if the request has a test parameter and if the 
    // user is allowed to access the testing caching system.
    if ($parameter === 'test' && $appTest === 'true') {
      $testData = RouteDataProcess::getRouteTest($request->getRequestUri());
      return $this->render('layouts/test/index.html.twig', [
          'twig_base_html_path' => 'layouts/test/base.html.twig',
          'language'  => $testData['language'],
          'header_title' => $testData['title'],
          'asset_path' => $request->getSchemeAndHttpHost() . '/test/',
          'meta_description' => $testData['meta_description'],
          'meta_keywords' => $testData['meta_keywords'],
          'meta_author' => $testData['meta_author'],
          'og_meta_type' => $testData['og_meta_type'],
          'og_meta_title' => $testData['og_meta_title'],
          'og_meta_description' => $testData['og_meta_description'],
          'og_meta_image' => $testData['og_meta_image'],
          'og_meta_route' => $testData['og_meta_route'],
          'og_meta_site_name' => $testData['og_meta_site_name'],
          'tw_meta_title' => $testData['tw_meta_title'],
          'tw_meta_description' => $testData['tw_meta_description'],
          'tw_meta_image' => $testData['tw_meta_image'],
          'tw_meta_site' => $testData['tw_meta_site'],
          'tw_meta_creator' => $testData['tw_meta_creaton'],
          'body' => $testData['body'],
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
        'language'  => $prodData['language'],
        'meta_description' => $prodData['meta_description'],
        'meta_keywords' => $prodData['meta_keywords'],
        'meta_author' => $prodData['meta_author'],
        'og_meta_type' => $prodData['og_meta_type'],
        'og_meta_title' => $prodData['og_meta_title'],
        'og_meta_description' => $prodData['og_meta_description'],
        'og_meta_image' => $prodData['og_meta_image'],
        'og_meta_route' => $prodData['og_meta_route'],
        'og_meta_site_name' => $prodData['og_meta_site_name'],
        'tw_meta_title' => $prodData['tw_meta_title'],
        'tw_meta_description' => $prodData['tw_meta_description'],
        'tw_meta_image' => $prodData['tw_meta_image'],
        'tw_meta_site' => $prodData['tw_meta_site'],
        'tw_meta_creator' => $prodData['tw_meta_creaton'],
        'asset_path' => $request->getSchemeAndHttpHost() . '/prod/',
        'body' => $prodData['body'],
    ]);
  }

}
