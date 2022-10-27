<?php

namespace App\Repository\Data\Creation;

use App\Repository\Processes\DataObjects;

/**
 * Creates data trees for content and layouts
 *
 * @author purencool
 */
class SchemaTree {

  private static function schemaObjects($dataResponse, $category) {
    $return = [];
    foreach ($dataResponse as $element) {
      if (property_exists($element, '@schema')) {
        $object = DataObjects::dataRequest(
            $element->{'@schema'},
            $category
          )['array_objects'];
        $object->{'@schema'} = $element->{'@schema'};
        $schemaName = explode('/', $element->{'@schema'});
        $object->{'@schema_name'} = end($schemaName);
        $return[] = $object;
      }
    }

    return (object) $return;
  }

  /**
   * 
   * @param type $objectPassed
   * @param type $in_arr
   * @return type
   */
  private static function schema($objectPassed, $category, $inArr = []) {
    foreach ($objectPassed as $key => $element) {
      if (is_array($element) || is_object($element)) {
        if (property_exists($element, '@schema')) {
          $dataResponse = DataObjects::dataRequest(
              $element->{'@schema'},
              $category
            )['array_objects'];

          if (!property_exists($dataResponse, '@data')) {
            $inArr[$key] = self::schemaObjects($dataResponse, $category);
          }
          else {
            $dataResponse->{'@schema'} = $element->{'@schema'};
            $inArr[$key] = $dataResponse;
          }
        }
        self::schema($element, $category, $inArr);
      }
    }
    return $inArr;
  }

  /**
   * 
   * @param type $objectPassed
   * @return type
   */
  public static function create($arrayPassedIn, $category): array {
    foreach ((array) $arrayPassedIn['@types'] as $key => $item) {
      $return[$key] = self::schema($item, $category);
    }
    return ['@types' => $return];
  }

}
