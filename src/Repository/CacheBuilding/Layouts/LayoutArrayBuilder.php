<?php

namespace App\Repository\CacheBuilding\Layouts;

/**
 * The LayoutArrayBuilder completes the following functions.
 *  1. Collates all the layouts into one large array.
 *  2. Stores array in layout cache to be used by system.
 *
 * @author purencool
 */
class LayoutArrayBuilder implements LayoutArrayBuilderInterface {

  /**
   * @inheritDoc
   */
  public function setLayoutArray(String $cachePath, String $layoutPath): array {

    $cachePath;
    $layoutPath;
    return [
      ' set layout array',
      ' set layout two array'
    ];
  }

}
