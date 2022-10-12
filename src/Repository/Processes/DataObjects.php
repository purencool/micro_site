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
  public static function consoleRequest($objectType): array {
    $phpObjects = new PhpObject();
    return ['response' => array_merge(
        [" You requested : $objectType"],
        [" " . print_r($phpObjects->getPhpObject($objectType), true) . ""]
      )
    ];
  }

  /**
   * @inherit
   */
  public static function dataRequest($objectType): array {
    $phpObjects = new PhpObject();
    return $phpObjects->getPhpObject($objectType);
  }

}
