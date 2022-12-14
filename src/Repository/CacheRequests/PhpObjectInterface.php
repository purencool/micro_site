<?php

namespace App\Repository\CacheRequests;

/**
 * PhpObjectInterface interface for PHP objects requested by the system.
 *
 * @author purencool
 */
interface PhpObjectInterface {

  /**
   * Gets PHP object requested by the system for its use.
   * 
   * @param String $typeOfObject 
   *    Type of PHP Object that is being requested.
   * @param String $environment
   *    Selects which environment the data comes from.
   * @return array
   *    The result should look like the following:
   *    [
   *      'response' => '',
   *      'object_array' => '',
   *    ]
   */
  public function getPhpObject(String $typeOfObject, String $environment = ''): array;
}
