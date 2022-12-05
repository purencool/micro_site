<?php

namespace App\Controller\Observers;

use App\Repository\Utilities\ObjectsToArray;

/**
 * Gets data array after building the content from the route.
 *
 * @author purencool
 */
class DataLayout {

  /**
   * Data Array is the data needed for the theme layout.
   * 
   * @var array
   */
  private static $dataArray;

  /**
   * Data Array is the data needed for the theme layout.
   * 
   * @var array
   */
  private static $layoutArray;

  /**
   * Flattens array so that in can be used in the layout.
   * 
   * @param array $array
   *    Array that needs to be flattened.
   * @return array
   *    Flattened array.
   */
  private static function flatten(array $array): array {
    $return = [];
    array_walk_recursive($array, function ($a) use (&$return) {
      $return[] = $a;
    });
    return $return;
  }

  /**
   * Returns meshed data with layout array.
   * 
   * @param  array $data
   *    Gets layout array ready for meshing
   * @return array
   *    Data connected to the route.
   */
  private static function createDataLayout(array $data): array {
    $returnArr = [];
    foreach ($data['layouts'] as $key => $item) {
      if (!is_object($item)) {
        $returnArr[$key] = (array) self::createDataLayout($item);
      }
      else {
        if (!property_exists($item, '@data')) {
          $returnArr[$key][] = (array) $item;
        }
      }
    }

    return $returnArr;
  }

  /**
   * 
   * @param array $arr
   * @param string $dataPoint
   * @return string
   */
  private static function findContentNeeded(string $dataPoint): string {
    foreach (self::$dataArray as $val) {
      if (property_exists($val, $dataPoint)) {
        return $val->{$dataPoint};
      }
    }
    return 'Content couldn\'t not be found';
  }

  /**
   * Adds content to array so that before the preprocessor. 
   * 
   * @param mixed $arr
   *     Can be arrays.
   * @return array
   *     Ultimately returns an array with 
   *     content after recursion is resolved.
   */
  private static function findContentPlaceholder(array $arr): array {
    foreach ($arr as $key => $val) {

      //  if (array_key_exists('@schema_name', $arr) &&
      //    array_key_exists('@data', $arr) &&
      //   array_key_exists('@schema', $arr)) {
      //    $keyFind = array_search('@content_placeholder', $arr['@data']);
      //    if ($keyFind !== false) {
      //      $arr['@data'][$keyFind] = self::findContentNeeded(
      //           $arr['@schema_name']
      //       );
      //      }
      //      return $arr;
      //    }
      //    else {
      if (is_array($val)) {
        print_r($val);
        $arr[$key] = self::findContentPlaceholder($val);
      }
      //    }
    }
    return $arr;
  }

  /**
   * Returns meshed data with layout array.
   * 
   * @param  array $data
   *    Gets layout array ready for meshing.
   * @param  string $type
   *    Forces class to return an array with 
   *    only the necessary information.
   * @return array
   *    Data connected to the route.
   */
  public static function getDataLayout(array $data): array {
    self::$dataArray = self::flatten($data['data']['@data_array']['@data']);
    self::$layoutArray = ObjectsToArray::returnObjToArr($data['layouts']);
    return [
      'preprocessor' => self::$layoutArray,
      'data_array' => self::$dataArray,
      'layout_array' => self::$layoutArray
    ];
  }

}
