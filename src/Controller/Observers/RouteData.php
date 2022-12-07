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
   * Flattens array so that in can be used in the layout.
   * 
   * @param array $array
   *    Array that needs to be flattened.
   * @return array
   *    Flattened array.
   */
  private static function flatten(array $array): array {
    $return = [];
    array_walk_recursive($array, function ($a) use (&$return) {
      $return[] = $a;
    });
    return $return;
  }

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
    $processedData = self::flatten($data['@data']);
    $data['@content'] = $processedData;


 $layouts = (array) LayoutCreation::getData($type);
 
    // Adds a object around the content to reduce code higher 
    // in the response observer stack.
    $typeUsed = $data['@type'];
    $content = $layouts['@types'][$typeUsed]['content'];
    $layouts['@types'][$typeUsed]['content'] = (object) [$content];

    return [
      'data' => $data,
      'layouts' => $layouts['@types'][$typeUsed]
    ];
  }

}
