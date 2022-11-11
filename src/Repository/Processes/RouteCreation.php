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
   * 
   * @return array
   */
  private static function testRoutes(): array {
    $obj = new PhpObject();
    $dataObj = $obj->getPhpObject('config', 'cont_test');

    if ($dataObj['array_objects']->{'error'} == true) {
      return ['response' => [' ' . $dataObj['array_objects']->{'message'}]];
    }

    $store = $dataObj['array_objects']->{'@routes'}->{'@schema'};

    $x = [];
    $objList = new PhpObjectsList();
    foreach ($store as $storeItem) {
      $x[] = $objList->getPhpObjects($storeItem, 'cont_test')['array_objects'];
    }

    $return = [];
    foreach ($x as $storeList) {
      foreach ($storeList as $storeListItem) {
        if (property_exists($storeListItem['object'], '@route')) {
          $return[] = (object) [
              '@route' => $storeListItem['object']->{'@route'},
              '@schema' => $storeListItem['schema']->getRealPath(),
              '@title' => $storeListItem['object']->{'@title'},
          ];
        }
      }
    }

    JsonPhpConverter::fileCreation(
      Schema::getSiteTestCacheContent() . 'test_routes.json',
      JsonPhpConverter::arraySerialization($return, 'serialize')
    );
    return [];
  }

  /**
   * 
   * @return array
   */
  private static function prodRoutes(): array {
    $obj = new PhpObject();
    $dataObj = $obj->getPhpObject('config', 'cont_prod');

    if ($dataObj['array_objects']->{'error'} == true) {
      return ['response' => [' ' . $dataObj['array_objects']->{'message'}]];
    }

    $store = $dataObj['array_objects']->{'@routes'}->{'@schema'};

    $x = [];
    $objList = new PhpObjectsList();
    foreach ($store as $storeItem) {
      $x[] = $objList->getPhpObjects($storeItem, 'cont_prod')['array_objects'];
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

    JsonPhpConverter::fileCreation(
      Schema::getSiteProdCacheContent() . 'prod_routes.json',
      JsonPhpConverter::arraySerialization($return, 'serialize')
    );

    return [];
  }

  /**
   * @inherit
   */
  public static function create(string $type): array {
    $return = '';
    if ($type == 'test') {
      $return = ' Test routes created';
      self::testRoutes();
    }
    elseif ($type == 'prod') {
      $return = ' Prod routes created';
      self::prodRoutes();
    }
    else {
      $return = ' No routes created';
    }

    return ['response' => [''.$return]];
  }

}
