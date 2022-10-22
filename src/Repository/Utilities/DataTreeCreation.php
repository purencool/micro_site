<?php

namespace App\Repository\Utilities;

use App\Repository\DataCreation\DataTree;
use App\Repository\DataCreation\DataTrees;


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

    if($type == 'multi') {
      return DataTrees::getDataTree($schema, $category, $type);
    }

    return DataTree::getDataTree($schema, $category, $type, $data);
  }

}
