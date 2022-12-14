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
   * @var type
   */
  private static $routeStoreItems = [];

  /**
   * 
   * @return type
   */
  private static function buildRoutesArray() {
    $return = [];
    foreach (self::$routeStoreItems as $storeList) {
      foreach ($storeList as $storeListItem) {
        if (property_exists($storeListItem['object']->{'@data'}, '@route')) {
          $return[] = $storeListItem['object']->{'@data'}->{'@route'};
        }
      }
    }
    return $return;
  }

  private static function createRouteObject(string $path, array $data) {
    JsonPhpConverter::fileCreation(
      $path,
      JsonPhpConverter::arraySerialization($data, 'serialize')
    );
  }

  /**
   * 
   * @return array
   */
  private static function testRoutes(): array {
    $obj = new PhpObject();
    $dataObj = $obj->getPhpObject('config', 'cont_test');
    if (isset($dataObj['array_objects']->{'error'})) {
      if ($dataObj['array_objects']->{'error'} == true) {
        return ['response' => [' ' . $dataObj['array_objects']->{'message'}]];
      }
    }

    $objList = new PhpObjectsList();
    foreach ($dataObj['array_objects']->{'@routes'}->{'@schema'} as $storeItem) {
      self::$routeStoreItems[] = $objList->getPhpObjects($storeItem, 'cont_test')['array_objects'];
    }

    self::createRouteObject(
      Schema::getSiteTestCacheRoute() . 'test_routes.json',
      self::buildRoutesArray()
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
    if (isset($dataObj['array_objects']->{'error'})) {
      if ($dataObj['array_objects']->{'error'} == true) {
        return ['response' => [' ' . $dataObj['array_objects']->{'message'}]];
      }
    }

    $objList = new PhpObjectsList();
    foreach ($dataObj['array_objects']->{'@routes'}->{'@schema'} as $storeItem) {
      self::$routeStoreItems[] = $objList->getPhpObjects($storeItem, 'cont_test')['array_objects'];
    }


    self::createRouteObject(
      Schema::getSiteProdCacheRoute() . 'prod_routes.json',
       self::buildRoutesArray()
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

    return ['response' => ['' . $return]];
  }

}
