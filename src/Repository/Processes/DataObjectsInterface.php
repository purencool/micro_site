<?php

namespace App\Repository\Processes;


/**
 * Request object from the caching.
 *  
 * @author purencool
 */
Interface DataObjectsInterface {

  /**
   * .Request object from the caching.
   * 
   * @param String $objectType
   *    Request object from the caching.
   * @return array
   *    Lets the user know the results of the process. 
   */
  public static function consoleRequest($objectType): array;

  /**
   * .Request object from the caching.
   * 
   * @param String $objectType
   *    Request object from the caching.
   * @return array
   *    Lets the user know the results of the process. 
   */
  public static function dataRequest($objectType): array;

}
