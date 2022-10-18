<?php

namespace App\Repository\Processes;


/**
 * Requests list of PHP objects from the caching.
 *  
 * @author purencool
 */
Interface DataObjectsListInterface {

  /**
   * Requests list of PHP objects from the caching.
   * 
   * @param String $objectsType
   *    Request objects from the caching.
   * @param String $environment
   *    Selects which environment the data comes from.
   * @return array
   *    Lets the user know the results of the process. 
   */
  public static function consoleRequest($objectsType, $environment = 'test'): array;

  /**
   * Requests list of PHP objects from the caching.
   * 
   * @param String $objectsType
   *    Request objects from the caching.
   * @param String $environment
   *    Selects which environment the data comes from.
   * @return array
   *    Lets the user know the results of the process. 
   */
  public static function dataRequest($objectsType, $environment = 'test'): array;

}
