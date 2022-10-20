<?php

namespace App\Controller\Observers;

use App\Repository\CacheRequests\PhpObject;
use App\Repository\Utilities\SchemaEncodeDecode;

/**
 * Description of RouteData
 *
 * @author purencool
 */
class RouteData {

  /**
   *  Get route object to create an array to build routes for the system.
   */
  private static function routeArray($routeName) {
    $obj = new PhpObject();
    foreach ($obj->getPhpObject('routes', 'cont')['array_objects'] as $object) {
      if (property_exists($object, '@route')) {
        if ($object->{'@route'} == rtrim($routeName, '/')) {
          return $object->{'@schema'};
        }
      }
    }
    return '';
  }

  /**
   * 
   * @param type $routeName
   * @return type
   */
  private static function routeRebuild($routeName) {
    $routeExplode = explode('/', $routeName);
    $responseType = '';

    if (end($routeExplode) == 'test' || end($routeExplode) == 'json') {
      $responseType = end($routeExplode);
      array_pop($routeExplode);
      $route = implode('/', $routeExplode);
    }
    else {
      $route = $routeName;
    }

    return [
      '@route' => $route,
      '@response_type' => $responseType
    ];
  }

  /**
   *  Get route object to create an array to build routes for the system.
   */
  private static function typeArray($type) {
    $obj = new PhpObject();
    return $obj->getPhpObject('config', 'cont')['array_objects']
      ->{'@types'}
      ->{$type};
  }

  /**
   * 
   * @param type $schema
   * @return string
   */
  private static function routeData($schema) {
    if ($schema == '') {
      return '';
    }
    return SchemaEncodeDecode::requestObject($schema);
  }

  /**
   * 
   * @param type $objectPassed
   * @param type $in_arr
   * @return type
   */
  private static function lookingForSchemas($objectPassed, &$in_arr = []) {
    foreach ($objectPassed as $element) {
      if (is_object($element)) {
        if (property_exists($element, '@schema')) {
          $in_arr[] = $element;
        }
        self::lookingForSchemas($element, $in_arr);
      }
    }
    return $in_arr;
  }

  /**
   * 
   * @param type $schema
   * @return type
   */
  private static function dataTreeSchema($schema) {
    $obj = new PhpObject();
    $return = [];
    $result = self::lookingForSchemas(
        $obj->getPhpObject($schema, 'cont')['array_objects']
    );

    foreach ($result as $resultItem) {
      $return[] = $obj->getPhpObject($resultItem->{'@schema'}, 'cont')['array_objects'];
    }

    return $return;
  }

 /**
  * 
  * @param type $type
  * @param type $content
  * @return type
  */
  private static function dataTree($type, $content) {
    $return = [];

    foreach ((array) self::typeArray($type) as $key => $item) {
      if (property_exists($item, '@schema')) {
        $return[$key] = self::dataTreeSchema($item->{'@schema'});
        if($key == 'content') {
         $return[$key][] = (object)['@data' =>$content];
        }
      }
    }
    return $return;
  }

  /**
   * 
   * @param type $routeName
   * @return type
   */
  public static function getData($routeName) {
    $routeRebuildArr = self::routeRebuild($routeName);
    $schema = self::routeArray($routeRebuildArr['@route']);
    $data = self::routeData($schema);
    $dataTree = self::dataTree($data->{'@type'},$data->{'@data'} );
    return [
      '@schema' => $schema,
      '@response_type' => $routeRebuildArr['@response_type'],
      '@data_array' => [
        '@route' => $data->{'@route'},
        '@link_text' => $data->{'@link_text'},
        '@layout' => $data->{'@layout'},
        '@type' => $data->{'@type'},
        '@data' => $dataTree,
      ]
    ];
  }

}
