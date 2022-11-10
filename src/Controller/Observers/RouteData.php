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
   * @param string $route
   *    Route name.
   * @param string $type
   *    Cache type.
   * @return array
   *    Data connected to the route.
   */
  public static function getData($route, $type) : array {
  
    $data = ContentCreation::getData($route, $type);
    $layouts = (array) LayoutCreation::getData($type);

    // Adds a object around the content to reduce code higher 
    // in the response observer stack.
    $typeUsed = $data['@data_array']['@type'];
    $content = $layouts['@types'][$typeUsed]['content'];
    $layouts['@types'][$typeUsed]['content'] = (object) [$content];

    return [
      'data' => $data,
      'layouts' => $layouts['@types'][$typeUsed]
    ];
  }

}
