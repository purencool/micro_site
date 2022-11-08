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
   $data =  ContentCreation::getData($routeName, $type);
   $layouts = (array)LayoutCreation::getData($type);
   $typeToBeUsed = $data['@data_array']['@type'];

   // Adds a object around the content to reduce code higher 
   // in the response observer stack.
   $content = $layouts['@types'][$typeToBeUsed]['content'];
   $layouts['@types'][$typeToBeUsed]['content'] = (object)[$content];

    return [
      'data' => $data,
      'layouts' => $layouts['@types'][$typeToBeUsed]
    ];
  }

}
