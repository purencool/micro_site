<?php

namespace App\Repository\CacheRequests;

use App\Repository\Utilities\Paths;
use App\Repository\Utilities\FindPhpObject;

/**
 * Returns object the system has requested.
 *
 * @author purencool
 */
class PhpObject implements PhpObjectInterface {

  /**
   * Data request method.
   * 
   * @param String $path
   *    Path needed to get access to the data.
   * @param String $typeOfObject
   *    Type of object needed by the system.
   * @return array
   *    Return data structures.
   */
  protected function getData(String $path, String $typeOfObject) {

    $pathResult = FindPhpObject::getObject($path, $typeOfObject);
    if ($pathResult === false) {
      return ['Data object does not exist'];
    }

    $data = file_get_contents($pathResult);
    return unserialize($data);
  }

  /**
   * @inherit
   */
  public function getPhpObject($typeOfObject, $environment): array {

    if ($environment === 'prod') {
      $data = $this->getData(Paths::getSiteCacheProd(), $typeOfObject);
    }
    else {
      $data = $this->getData(Paths::getSiteCacheTest(), $typeOfObject);
    }

    return [$data];
  }

}