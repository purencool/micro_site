<?php

namespace App\Controller\Observers;

use App\Repository\Utilities\ObjectsToArray;
use App\Repository\Processes\LayoutCreation;

/**
 * Gets data array after building the content from the route.
 *
 * @author purencool
 */
class Layouts {
  /**
   * Returns meshed data with layout array.
   * 
   * @param  array $data
   *    Gets layout array ready for meshing.
   * @param  string $type
   *    Forces class to return an array with 
   *    only the necessary information.
   * @return array
   *    Data connected to the route.
   */
  public static function getArray(string $type): array {
   
    return LayoutCreation::getData($type)['@types'][$type];
  }

}
