<?php

namespace App\Repository\Utilities;

use App\Repository\Data\Creation\DataTree;
use App\Repository\Data\Creation\DataTrees;


/**
 * Creates data trees for content and layouts
 *
 * @author purencool
 */
class DataTreeCreation {

  /**
   * Creates data tree for layouts and content
   * 
   * @param type $type
   * @param type $data
   * @return array
   */
  public static function getDataTree(
    $schema,
    $category,
    $type = 'multi',
    $data = ''
  ): array {

    return DataTree::getDataTree($schema, $category, $type, $data);
  }

}
