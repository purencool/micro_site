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
class LayoutCreation implements RouteCreationInterface {

  /**
   * @inherit
   */
  public static function create(): array {
    $obj = new PhpObject();
    $dataObj = $obj->getPhpObject('config', 'cont');

    $store = $dataObj['array_objects']->{'@routes'}->{'@schema'};

    $x = [];
    $objList = new PhpObjectsList();
    foreach ($store as $storeItem) {
      $x[] = $objList->getPhpObjects($storeItem, 'cont')['array_objects'];
    }


    $return = [];
    foreach ($x as $storeList) {
      foreach ($storeList as $storeListItem) {
        if (property_exists($storeListItem['object'], '@route')) {
          $return[] = (object) [
              '@route' => $storeListItem['object']->{'@route'},
              '@schema' => $storeListItem['schema']->getRealPath(),
          ];
        }
      }
    }

    JsonPhpConverter::buildLayoutArray(Schema::getSiteCacheTestLayoutStructure());

    JsonPhpConverter::fileCreation(
      Schema::getSiteCacheTest() . 'layouts.json',
      JsonPhpConverter::arraySerialization(
        JsonPhpConverter::$layoutArray,
        'serialize'
      )
    );

    return ['response' => [' Layout creation completed']];
  }

}
