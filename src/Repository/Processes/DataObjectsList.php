<?php

namespace App\Repository\Processes;

use App\Repository\CacheRequests\PhpObjectsList;

/**
 * Request list of PHP objects from the caching.
 *  
 * @author purencool
 */
class DataObjectsList implements DataObjectsListInterface {

  /**
   * @inherit
   */
  public static function consoleRequest($objectsType, $environment = 'test'): array {
    $phpObjects = new PhpObjectsList();
    return ['response' => array_merge(
        [" The data objects list requested are : $objectsType."],
        [" From the following environment : $environment."],
        [" " . print_r($phpObjects->getPhpObjects($objectsType, $environment), true) . ""]
      )
    ];
  }

  /**
   * @inherit
   */
  public static function dataRequest($objectsType, $environment = 'test'): array {
    $phpObjects = new PhpObject();
    return $phpObjects->getPhpObjects($objectsType, $environment);
  }

}
