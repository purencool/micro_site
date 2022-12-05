<?php

namespace App\Repository\Data\Creation;

use App\Repository\CacheRequests\PhpObject;
use App\Repository\CacheRequests\PhpObjectsList;
use App\Repository\Utilities\ObjectsToArray;
use App\Repository\Data\Creation\UrlCorrection;

/**
 * Creates data trees for content and layouts
 *
 * @author purencool
 */
class DataTree {

  /**
   * 
   * @var type
   */
  private static $route;

  /**
   * 
   * @var type
   */
  private static $category;

  /**
   * 
   * @var type
   */
  private static $schema;

  /**
   * 
   * @var type
   */
  private static $type;

  /**
   * 
   * @var type
   */
  private static $data;

  /**
   *  Get route object to create an array to build routes for the system.
   */
  private static function typeArray() {

    $obj = new PhpObject();
    return (array) $obj->getPhpObject(
        self::$schema,
        self::$category
      )['array_objects']
      ->{'@types'}
      ->{self::$type};
  }

  /**
   * 
   * @param type $arr
   * @return string
   */
  private static function getContent($arr) {
    if (isset($arr['@data']['article'])) {
      return (object) $arr['@data'];
    }
    return '';
  }

  /**
   * 
   * @param type $schema
   * @return string
   */
  private static function getContentObj($schema) {

    $objs = new PhpObjectsList();
    $results = $objs->getPhpObjects(
        $schema,
        self::$category
      )['array_objects'];
    foreach ($results as $items) {
      if (property_exists($items['object'], '@route')) {
        $urlTest = UrlCorrection::testRoute(self::$route);
        if ($items['object']->{'@route'} === $urlTest) {
          return self::getContent(
              ObjectsToArray::returnObjToArr(
                $items['object']
              )
          );
        }
      }
    }

    return '';
  }

  /**
   * 
   * @return type
   */
  private static function dataTree($arr) {
    $return = [];
    $obj = new PhpObject();

    foreach ($arr as $key => $item) {
      if (property_exists($item, '@schema')) {
        $schemaData = $obj->getPhpObject(
            $item->{'@schema'},
            self::$category
          )['array_objects'];

        if (property_exists($schemaData, 'error')) {
          if ($key === 'content') {
            $return[$key] = [
              '@schema' => $item->{'@schema'},
              '@data' => self::getContentObj($item->{'@schema'})
            ];
          }
          else {
            $return[$key] = [
              '@schema' => $item->{'@schema'},
              '@data' => $schemaData
            ];
          }
        }
        else {
          $return[$key] = [
            '@schema' => $item->{'@schema'},
            '@data' => $schemaData->{'@data'}
          ];
          if (!property_exists($schemaData, '@data')) {
            $return[$key] = self::dataTree($schemaData);
          }
        }
      }
    }
    return $return;
  }

  /**
   * Creates data tree for layouts and content
   * 
   * @param type $type
   * @param type $data
   * @return array
   */
  public static function getDataTree(
    $route,
    $schema,
    $category,
    $type = 'multi',
    $data = ''
  ): array {
    self::$route = $route;
    self::$schema = $schema;
    self::$category = $category;
    self::$type = $type;
    self::$data = $data;

    return self::dataTree((array) self::typeArray());
  }

}
