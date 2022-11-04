<?php

namespace App\Controller\Observers;

/**
 * Gets data array after building the content from the route.
 *
 * @author purencool
 */
class DataLayout {

  /**
   * 
   * @var type
   */
  private static $dataArray;

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
          print $key;
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
      if (array_key_exists('@schema_name', $arr) &&
        array_key_exists('@data', $arr) &&
        array_key_exists('@schema', $arr)) {
        $keyFind = array_search('@content_placeholder', $arr['@data']);
        if ($keyFind !== false) {
          $arr['@data'][$keyFind] = self::findContentNeeded(
              $arr['@schema_name']
          );
        }
        return $arr;
      }
      else {
        if (is_array($val)) {
          $arr[$key] = self::findContentPlaceholder($val);
        }
      }
    }
    return $arr;
  }

  /**
   * Removes all STD objects and turns them into an array.
   * 
   * @param mixed $obj
   *     Can be arrays or objects.
   * @return mixed
   *     Ultimately returns an array after recursion is
   *     resolved.
   */
  private static function objectsToArray($obj) {
    if (is_object($obj)) {
      $obj = (array) $obj;
    }
    if (is_array($obj)) {
      $new = array();
      foreach ($obj as $key => $val) {
        $new[$key] = self::objectsToArray($val);
      }
    }
    else {
      $new = $obj;
    }
    return $new;
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
  public static function getDataLayout(array $data, string $type = 'preprocessor'): array {

    self::$dataArray = self::flatten($data['data']['@data_array']['@data']);

    if ($type == 'preprocessor') {
      return [
        'preprocessor' =>
        self::findContentPlaceholder(
          self::objectsToArray(
            $data['layouts']
          )
        )
      ];
    }

    return array_merge(['preprocessor' => $data], $data);
  }

}
