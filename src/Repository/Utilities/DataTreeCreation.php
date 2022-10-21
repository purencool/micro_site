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
   * @param type $type
   * @param type $content
   * @return type
   */
  private static function dataTree($type, $content) {
    $return = [];

    foreach ((array) self::typeArray($type) as $key => $item) {
      if (property_exists($item, '@schema')) {
        $return[$key] = self::dataTreeSchema($item->{'@schema'});
        if ($key == 'content') {
          $return[$key][] = (object) ['@data' => $content];
        }
      }
    }
    return $return;
  }

  /**
   * Creates data tree for layouts and content
   * 
   * @param type $type
   * @param type $content
   * @return array
   */
  public static function getDataTree($type, $content) : array {
     return self::dataTree($type, $content);
  }

}
