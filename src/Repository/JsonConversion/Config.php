<?php

namespace App\Repository\JsonConversion;

/**
 * The LayoutArrayBuilder completes the following functions.
 *  1. Collates all the layouts into one large array.
 *  2. Stores array in layout cache to be used by system.
 *
 * @author purencool
 */
class Config implements ConfigInterface {

  /**
   * @inheritDoc
   */
  public function setConfigArray(String $cachePath, String $layoutPath): array {
    $cachePath;
    $layoutPath;
    return [
      ' set layout array',
      ' set layout two array'
    ];
    
  }

}
