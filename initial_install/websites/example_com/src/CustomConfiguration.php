<?php

namespace App\CacheTest;

/**
 * All altering classes needs to be registered and changes made here.
 *
 * @author purencool
 */
class CustomConfiguration implements CustomConfigurationInterface {

  /**
   * @inheritDoc
   */
  public function getObjectArray(array $inputArray): array {
    return $inputArray;
  }

}
