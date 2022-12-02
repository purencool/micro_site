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
   * @return bool
   */
  private static function testForDataParameter(object $object): bool {
    foreach (array_keys(get_object_vars($object)) as $item) {
      if (str_contains($item, '@data')) {
        return true;
      }
    }
    return false;
  }

  /**
   * 
   * @param type $objectPassed
   * @param type $inArr
   * @return type
   */
  private static function schema($objectPassed, $inArr = []) {
    foreach ($objectPassed as $key => $element) {
      print_r($element);
      if (is_object($element)) {
        if (property_exists($element, '@schema')) {
          $dataResponse = DataObjects::dataRequest(
              $element->{'@schema'},
              'layout'
            )['array_objects'];

          $testForDataParam = self::testForDataParameter($dataResponse);
          if ($testForDataParam === true) {

            $inArr[$key] = $dataResponse;
          }
          else {
           
            $inArr[$key] = self::schema($dataResponse);
          }
          //   $inArr[$key] = (array)$dataResponse;
          //   if (!property_exists($dataResponse, '@data')) {
          //    $inArr[$key] = self::schemaObjects($dataResponse, $category);
          //    }
          //   else {
          //      $dataResponse->{'@schema'} = $element->{'@schema'};
          //      $inArr[$key] = $dataResponse;
          //    }
        }
       // self::schema($dataResponse);
      }
    }
    return $inArr;
  }

  /**
   * 
   * @param type $objectPassed
   * @return type
   */
  public static function create($arrayPassedIn): array {
    foreach ((array) $arrayPassedIn['@types'] as $key => $item) {
      $return[$key] = self::schema($item);
    }
    return ['@types' => $return];
  }

}
