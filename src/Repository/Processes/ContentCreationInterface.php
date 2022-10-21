<?php

namespace App\Repository\Processes;

/**
 * Gets data array after building the content from the route.
 *  
 * @author purencool
 */
Interface ContentCreationInterface {

  /**
   * Gets data array after building the content from the route.
   * 
   * @param string $routeName
   *    Route name.
   * @return array
   *    Data connected to the route.
   */
  public static function getData($routeName): array;
}
