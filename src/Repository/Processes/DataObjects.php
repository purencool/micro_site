<?php

namespace App\Repository\Processes;

use App\Repository\CacheRequests\PhpObject;

/**
 * Request object from the caching.
 *  
 * @author purencool
 */
class DataObjects implements DataObjectsInterface {

  /**
   * @inherit
   */
  public static function consoleRequest($objectType, $environment = 'test'): array {
    $phpObjects = new PhpObject();
    return ['response' => array_merge(
  [" The data object requested is : $objectType."],
  [" From the following environment : $environment."],
        [" " . print_r($phpObjects->getPhpObject($objectType, $environment), true) . ""]
      )
    ];
  }

  /**
   * @inherit
   */
  public static function dataRequest($objectType, $environment = 'test'): array {
    $phpObjects = new PhpObject();
    return $phpObjects->getPhpObject($objectType, $environment);
  }

}
