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
    $dataObj = $obj->getPhpObject('config', 'cont_test');


 
    if($dataObj['array_objects']->{'error'} == true){
      return ['response' => [' '. $dataObj['array_objects']->{'message'}]];
    }

    $store = $dataObj['array_objects']->{'@routes'}->{'@schema'};


 $objList = new PhpObjectsList();

    $x = [];
    foreach ($store as $storeItem) {
      $x[] = $objList->getPhpObjects($storeItem, 'cont_test')['array_objects'];
    }

    $y = [];
    foreach ($store as $storeItem) {
      $y[] = $objList->getPhpObjects($storeItem, 'cont_prod')['array_objects'];
    }


print_r($y); exit;

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

    JsonPhpConverter::fileCreation(
      Schema::getSiteTestCacheContent() . 'routes.json',
      JsonPhpConverter::arraySerialization($return, 'serialize')
    );

    return ['response' => [' Routes object created']];
  }

}
