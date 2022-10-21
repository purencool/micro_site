<?php

namespace App\Repository\Utilities;

use App\Repository\CacheRequests\PhpObject;
use App\Repository\Utilities\SchemaEncodeDecode;

/**
 * Creates data trees for content and layouts
 *
 * @author purencool
 */
class DataTreeCreation {

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
        $return[$key] = self::dataTreeSchema($item->{'@schema'});
        if ($key == 'content' && self::$data != '') {
          $return[$key][] = (object) ['@data' => self::$data];
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
    $data = '',
    $type = ''
  ): array {
    self::$category = $category;
    self::$schema = $schema;
    self::$type = $type;
    self::$data = $data;

    return self::dataTree();
  }

}