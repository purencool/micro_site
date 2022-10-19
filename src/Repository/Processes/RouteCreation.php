<?php

namespace App\Repository\Processes;

use App\Repository\Utilities\Schema;
use App\Repository\Utilities\JsonPhpConverter;
use App\Repository\CacheRequests\PhpObject;
use App\Repository\CacheRequests\PhpObjectsList;

/**
 * Request a PHP object from the caching.
 *  
 * @author purencool
 */
class RouteCreation implements RouteCreationInterface {

  /**
   * @inherit
   */
  public static function create(): array {
    $obj = new PhpObject();
    $dataObj = $obj->getPhpObject('config', 'cont');
    $store = $dataObj['array_objects']->{'@routes'}->{'@store'};

    $objList = new PhpObjectsList();
    $storeList = $objList->getPhpObjects($store, 'cont');

    $return = [];

    foreach ($storeList['array_objects'] as $storeListItem) {
      if (property_exists($storeListItem['object'], '@route' )) {
        $return[] = (object) [
            '@route' => $storeListItem['object']->{'@route'},
            '@schema' => $storeListItem['schema']->getRealPath(),
        ];
      }
    }

    JsonPhpConverter::fileCreation(
      Schema::getSiteCacheContent() . 'routes.json',
      JsonPhpConverter::arraySerialization($return, 'serialize')
    );

    return ['response' => [' Routes object created']];
  }

}
