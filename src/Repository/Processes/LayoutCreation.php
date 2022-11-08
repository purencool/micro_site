<?php

namespace App\Repository\Processes;

use App\Repository\Utilities\Schema;
use App\Repository\Utilities\JsonPhpConverter;
use App\Repository\CacheRequests\PhpObject;
use App\Repository\Data\Creation\SchemaTree;

/**
 * Request a PHP object from the caching.
 *  
 * @author purencool
 */
class LayoutCreation implements LayoutCreationInterface {

  /**
   * @inherit
   */
  public static function create(): array {
    $obj = new PhpObject();
    $dataObj = $obj->getPhpObject('layout_structure/layouts', 'test');
  
    JsonPhpConverter::fileCreation(
      Schema::getSiteCacheTest() . 'layouts_data.json',
      JsonPhpConverter::arraySerialization(
         SchemaTree::create((array)$dataObj['array_objects'], 'layout'),
        'serialize'
      )
    );

    return ['response' => [' Layout creation completed']];
  }

  public static function getData($type) {
    $obj = new PhpObject();
    return (array)$obj->getPhpObject('layouts_data', $type)['array_objects'];
  }

}
