<?php

namespace App\Repository\CacheRequests;

/**
 * PhpObjectListInterface interface for a list of PHP objects 
 * requested by the system.
 *
 * @author purencool
 */
interface PhpObjectsListInterface {

  /**
   * returns a list of PHP object requested by the system for its use.
   * 
   * @param String $typeOfObjects 
   *    Type of PHP Object that is being requested.
   * @param String $environment
   *    Selects which environment the data comes from.
   * @return array
   *    The result should look like the following:
   *    [
   *      'response' => '',
   *      'objects_array' => '',
   *    ]
   */
  public function getPhpObjects(String $typeOfObjects, String $environment = ''): array;
}
