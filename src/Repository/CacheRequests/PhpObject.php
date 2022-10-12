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
   * @inherit
   */
  public function getPhpObject($typeOfObject): array {
    $data = unserialize(
      file_get_contents(
        FindPhpObject::getObject(Paths::getSiteCacheTest(), $typeOfObject)
      )
    );

    return [$data];
  }

}
