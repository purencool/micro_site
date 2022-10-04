<?php

namespace App\Repository\Layouts;


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
  public function getLayoutArray(String $path): array {
    $path;
    return [];
  }

}
