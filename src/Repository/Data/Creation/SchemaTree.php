<?php

namespace App\Repository\Data\Creation;

use App\Repository\Processes\DataObjects;

/**
 * Creates data trees for content and layouts
 *
 * @author purencool
 */
class SchemaTree {


  /**
   * 
   * @param object $object
   * @return array
   */
  private static function testForDataParameter($object) : array {
    $return = [];
    foreach (array_keys(get_object_vars($object)) as $item) {
      if (str_contains($item, '@data')) {
        $return[$item] = $object->{$item};
      }
      if (str_contains($item, '@content_placeholder')) {
        $return[$item] = $object->{$item};
      }
      if (str_contains($item, '@child')) {
        $return[$item] = self::schema($object->{$item});
      }
    }
    return $return;
  }

  /**
   * 
   * @param type $objectPassed
   * @param type $inArr
   * @return type
   */
  private static function schema($objectPassed, $inArr = []) {
    foreach ($objectPassed as $key => $element) {
      if (is_object($element)) {
        if (property_exists($element, '@schema')) {
          $dataResponse = DataObjects::dataRequest(
              $element->{'@schema'},
              'layout'
            )['array_objects'];         
          $inArr[$key] = self::testForDataParameter($dataResponse);
        }
      }
    }
    return $inArr;
  }

  /**
   * 
   * @param object $arrayPassedIn
   * @return array
   */
  public static function create($arrayPassedIn): array {
    foreach ((array) $arrayPassedIn['@types'] as $key => $item) {
      $return[$key] = self::schema($item);
    }
    return ['@types' => $return];
  }

}
