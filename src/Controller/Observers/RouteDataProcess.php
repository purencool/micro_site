<?php

namespace App\Controller\Observers;

use App\Controller\Observers\RouteData;
use App\Controller\Observers\DataAlterTest;
use App\Controller\Observers\DataAlterProd;
use App\Controller\Observers\DataLayout;
use App\Controller\Observers\HtmlCreation;

/**
 * Gets data array after building the content from the route.
 *
 * @author purencool
 */
class RouteDataProcess {

  /**
   * Gets data array after building the content from the route.
   * 
   * @param string $route
   *    Route name.
   * @return array
   *    Data connected to the route.
   */
  public static function getRouteTest($route): array {
    $routeDataArrTest = RouteData::getData($route, 'test');
    return [
      'title' => $routeDataArrTest['data']['@data_array']['@title'],
      'body' => HtmlCreation::setChanges(
        DataAlterTest::setChanges(
          DataLayout::getDataLayout(
             $routeDataArrTest
          )
        )
      )
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
  public static function getRouteProd($route): array {
    $prodData = 'Page doesn\'t exist return <a href="/" title="Home">home</a>';

    $routeDataArrProd = RouteData::getData($route, 'prod');
    if ($routeDataArrProd['data']['@schema'] != 'no route') {
      $prodData = HtmlCreation::setChanges(
          DataAlterProd::setChanges(
            DataLayout::getDataLayout(
              $routeDataArrProd
            )
          )
      );
    }

    return [
      'title' => $routeDataArrProd['data']['@data_array']['@title'],
      'body' => $prodData
    ];
  }

}
