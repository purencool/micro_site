<?php

namespace App\Controller\Observers;

use App\Controller\Observers\Mesh;
use App\Controller\Observers\Layouts;
use App\Controller\Observers\RouteData;
use App\Controller\Observers\HtmlCreation;
use App\Controller\Observers\DataAlterTest;
use App\Controller\Observers\DataAlterProd;

/**
 * Gets data array after building the content from the route.
 *
 * @author purencool
 */
class RouteDataProcess {

  /**
   * Removes schema_name from json response
   * 
   * @param array $data
   *   data object.
   * @return array
   *   array with schema_name removed.
   */
  private static function arrayUnset(&$data) {
    return $data;
  }

  /**
   * Gets data array after building the content from the route.
   * 
   * @param string $route
   *    Route name.
   * @return array
   *    Data connected to the route.
   */
  public static function getRouteJson($route): array {
    $routeDataArrTest = RouteData::getData($route, 'prod');
    return [
      'title' => $routeDataArrTest['data']['@data_array']['@title'],
      'body' => self:: arrayUnset($routeDataArrTest['data']['@data_array'])
    ];
  }

  /**
   * Gets data array after building the content from the route.
   * 
   * @param string $route
   *    Route name.
   * @return array
   *    Data connected to the route.
   */
  public static function getRouteTest($route): array {
    print '<pre>';
 print_r($route);exit;
    $data = RouteData::getData($route, 'test');
  
    $data['@layout'] = Layouts::getArray($data['@type']);
 print_r($data);
   exit;
    $responseArr['response'] = [
      'body' => Mesh::setMesh($data['@layout'], $data['@content']),
      'language'  => 'en-US',
      'meta_description' => '',
      'meta_keywords' => '',
      'meta_author' => '',
      'og_meta_type' => '',
      'og_meta_title' => $data['@title'],
      'og_meta_description' => '',
      'og_meta_image' => '',
      'og_meta_route' => '',
      'og_meta_site_name' => '',
      'tw_meta_title' => $data['@title'],
      'tw_meta_description' => '',
      'tw_meta_image' => '',
      'tw_meta_site' => '',
      'tw_meta_creator' => '',
      'summary' => '',
      'title' => $data['@title'],
    ];
    $responseArr['build_array'] = $data;
    $dataAlterOption = DataAlterTest::setChanges($responseArr);
    $responseArr['response']['body'] = HtmlCreation::setChanges(
        $dataAlterOption['response']['body']
    );

    return $responseArr['response'];
  }

  /**
   * Gets data array after building the content from the route.
   * 
   * @param string $route
   *    Route name.
   * @return array
   *    Data connected to the route.
   */
  public static function getRouteProd($route): array {
    $prodData = 'Page doesn\'t exist return <a href="/" title="Home">home</a>';

    $data = RouteData::getData($route, 'prod');
    $data['@layout'] = Layouts::getArray($data['@type']);

    $responseArr['response'] = [
      'body' => Mesh::setMesh($data['@layout'], $data['@content']),
      'language'  => 'en',
      'meta_description' => '',
      'meta_keywords' => '',
      'meta_author' => '',
      'og_meta_type' => '',
      'og_meta_title' => $data['@title'],
      'og_meta_description' => '',
      'og_meta_image' => '',
      'og_meta_route' => '',
      'og_meta_site_name' => '',
      'tw_meta_title' => $data['@title'],
      'tw_meta_description' => '',
      'tw_meta_image' => '',
      'tw_meta_author' => '',
      'tw_meta_author' => '',
      'summary' => '',
      'title' => $data['@title'],
    ];
    $responseArr['build_array'] = $data;
    $dataAlterOption = DataAlterProd::setChanges($responseArr);
    $responseArr['response']['body'] = HtmlCreation::setChanges(
        $dataAlterOption['response']['body']
    );

    return $responseArr['response'];
  }

}
