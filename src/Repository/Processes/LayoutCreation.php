<?php

namespace App\Repository\Processes;

use App\Repository\Utilities\Schema;
use App\Repository\Utilities\JsonPhpConverter;
use App\Repository\CacheRequests\PhpObject;
use App\Repository\CacheRequests\PhpObjectsList;
use App\Repository\Utilities\DataTreeCreation;

/**
 * Request a PHP object from the caching.
 *  
 * @author purencool
 */
class LayoutCreation implements RouteCreationInterface {

  /**
   * @inherit
   */
  public static function create(): array {
    //$obj = new PhpObject();
    //$dataObj = $obj->getPhpObject('layout_structure/layouts', 'test');
    $dataArray = DataTreeCreation::getDataTree(
        'layout_structure/layouts',
        'test',
        'default'
    );

    //   print_r(   );
    //exit;





    JsonPhpConverter::fileCreation(
      Schema::getSiteCacheTest() . 'layouts_data.json',
      JsonPhpConverter::arraySerialization(
        $dataArray,
        'serialize'
      )
    );

    return ['response' => [' Layout creation completed']];
  }

  public static function getData($type) {
    $obj = new PhpObject();
    return $obj->getPhpObject('layouts_data', $type)['array_objects'];
  }

}
