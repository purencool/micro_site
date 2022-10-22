<?php

namespace App\Repository\DataCreation;

use App\Repository\CacheRequests\PhpObject;

/**
 * Creates data trees for content and layouts
 *
 * @author purencool
 */
class DataTrees {

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
      $return[] = $obj->getPhpObject(
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
    return $obj->getPhpObject(
        self::$schema,
        self::$category
      )['array_objects']
      ->{'@types'};
  }

  private static function dataTree() {
    $return = [];
    foreach ((array) self::typeArray() as $itemTypeArray) {
      foreach ($itemTypeArray as $key => $item) {
        if (property_exists($item, '@schema')) {
          $return[$key] = self::dataTreeSchema($item->{'@schema'});
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
    $type
  ): array {
    self::$schema = $schema;
    self::$category = $category;
    self::$type = $type;

    return self::dataTree();
  }

}
