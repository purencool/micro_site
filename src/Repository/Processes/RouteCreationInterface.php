<?php

namespace App\Repository\Processes;


/**
 * Requests list of PHP objects from the caching.
 *  
 * @author purencool
 */
Interface RouteCreationInterface{

  /**
   * Requests list of PHP objects from the caching.
   * 
   * @param String $type
   *    Selects test or prod caching
   * @return array
   *    Lets the user know the results of the process. 
   */
  public static function create(string $type): array;

}
