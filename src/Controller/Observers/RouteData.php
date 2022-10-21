<?php

namespace App\Controller\Observers;

use App\Repository\Processes\ContentCreation;
use App\Repository\Processes\LayoutCreation;

/**
 * Gets data array after building the content from the route.
 *
 * @author purencool
 */
class RouteData {

  /**
   * Gets data array after building the content from the route.
   * 
   * @param string $routeName
   *    Route name.
   * @return array
   *    Data connected to the route.
   */
  public static function getData($routeName, $type) {
    return [
      'data' => ContentCreation::getData($routeName),
      'layouts' => LayoutCreation::getData($type)
    ];
  }

}
