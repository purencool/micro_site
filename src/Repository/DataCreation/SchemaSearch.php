<?php

namespace App\Repository\DataCreation;


/**
 * Creates data trees for content and layouts
 *
 * @author purencool
 */
class SchemaSearch {

  /**
   * 
   * @param type $objectPassed
   * @param type $in_arr
   * @return type
   */
  public static function findSchemas($objectPassed, &$in_arr = []) {
    foreach ($objectPassed as $element) {
      if (is_object($element)) {
        if (property_exists($element, '@schema')) {
          $in_arr[] = $element;
        }
        self::findSchemas($element, $in_arr);
      }
    }
    return $in_arr;
  }
}
