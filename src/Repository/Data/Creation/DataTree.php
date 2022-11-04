<?php

namespace App\Repository\Data\Creation;

use App\Repository\CacheRequests\PhpObject;

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
   * 
   * @param type $schema
   * @return type
   */
  private static function dataTreeSchema($schema) {
    $obj = new PhpObject();
    $return = [];

    $result = SchemaSearch::findSchemas(
        $obj->getPhpObject(
          $schema,
          self::$category
        )['array_objects']
    );

    foreach ($result as $resultItem) {
      $return[] = (array) $obj->getPhpObject(
          $resultItem->{'@schema'},
          self::$category
        )['array_objects'];
    }

    return $return;
  }

  /**
   *  Get route object to create an array to build routes for the system.
   */
  private static function typeArray() {

    $obj = new PhpObject();
    return (array)$obj->getPhpObject(
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
  private static function dataTree() {
    $return = [];
    foreach ((array) self::typeArray() as $key => $item) {
      if (property_exists($item, '@schema')) {
        $return[$key] = (array) self::dataTreeSchema($item->{'@schema'});
        if ($key == 'content' && self::$data != '') {
          $return[$key][] = ['@data' => (object)self::$data];
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
    $schema,
    $category,
    $type = 'multi',
    $data = ''
  ): array {
    self::$schema = $schema;
    self::$category = $category;
    self::$type = $type;
    self::$data = $data;

    return self::dataTree();
  }

}