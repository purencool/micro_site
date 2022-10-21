<?php

namespace App\Controller\Observers;

use App\CacheProd\CustomConfiguration;

/**
 * DataAlterProd is use to access the prod cache objects.
 *
 * @author purencool
 */
class DataAlterProd {

  /**
   * DataAlterProd is use to access the prod cache objects.
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
