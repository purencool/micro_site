<?php

namespace App\Controller\Observers;

use App\CacheTest\CustomConfiguration;

/**
 * Description of RouteData
 *
 * @author purencool
 */
class DataAlterTest {



  /**
   * 
   */
  public static function setChanges(array $dataArray): array {

 $x = new CustomConfiguration();
print_r($x->getObjectArray());


    return $dataArray;
  }

}
