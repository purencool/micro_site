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
    if (self::$type == 'multi') {
      return $obj->getPhpObject(
          self::$schema,
          self::$category
        )['array_objects']
        ->{'@types'};
    }


    return $obj->getPhpObject(
        self::$schema,
        self::$category
      )['array_objects']
      ->{'@types'}
      ->{self::$type};
  }

  private static function multiDataTree() {
    $return = [];
    foreach ((array) self::typeArray() as $itemTypeArray) {
      foreach ($itemTypeArray as $key => $item) {  
        if (property_exists($item, '@schema')) {
          $return[$key] = self::dataTreeSchema($item->{'@schema'});
          if ($key == 'content' && self::$data != '') {
            $return[$key][] = (object) ['@data' => self::$data];
          }
        }
      }
    }
    return $return;
  }

  /**
   * 
   * @return type
   */
  private static function singleDataTree() {
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
   * 
   * @return type
   */
  private static function dataTree() {

    if (self::$type == 'multi') {
      return self::multiDataTree();
    }
    return self::singleDataTree();
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
