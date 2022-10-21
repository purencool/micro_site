<?php

namespace App\CacheTest;

/**
 * Accesses data array and objects for custom changes before flattened.
 *
 * @author purencool
 */
interface CustomConfigurationInterface {

  /**
   * Accesses data array and objects for custom changes before flattened.
   * 
   * @param array $dataArray
   *    Data array to be modified.
   * @return array
   *    Return array changes.
   */
  public function getObjectArray(array $inputArray): array;
}
