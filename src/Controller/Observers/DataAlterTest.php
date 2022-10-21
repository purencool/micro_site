<?php

namespace App\Controller\Observers;

use App\CacheTest\CustomConfiguration;

/**
 * DataAlterTest is use to access the test cache objects.
 *
 * @author purencool
 */
class DataAlterTest {

 /**
   * DataAlterTest is use to access the test cache objects.
   * 
   * @param array $dataArray
   *    Data array to be modified.
   * @return array
   *    Return array changes.
   */
  public static function setChanges(array $dataArray): array {
    $x = new CustomConfiguration();
    return $x->getObjectArray($dataArray);
  }

}
