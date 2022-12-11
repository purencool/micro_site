<?php

namespace App\Repository\Data\Creation;

use App\Repository\CacheRequests\PhpObject;


/**
 * Creates Content for content and layouts
 *
 * @author purencool
 */
class Content {

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
   * @return type
   */
  private static function dataTree($arr) {
    $return = [];
    $obj = new PhpObject();

    foreach ($arr as $key => $item) {
      //print_r($item);
      if (property_exists($item, '@schema')) {
        $schemaData = $obj->getPhpObject(
            $item->{'@schema'},
            self::$category
          )['array_objects'];

        if (!property_exists($schemaData, '@data')) {
          $return[$key] = self::dataTree($schemaData);
        } else {
          $return[$key] = [
            '@schema' => $item->{'@schema'},
            '@data' => $schemaData
          ];
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
