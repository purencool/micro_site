<?php

namespace App\Controller\Observers;

use App\Repository\Utilities\ObjectsToArray;
use App\Repository\Processes\LayoutCreation;

/**
 * Gets data array after building the content from the route.
 *
 * @author purencool
 */
class Layouts {


  /**
   * Data Array is the data needed for the theme layout.
   * 
   * @var array
   */
  private static $layoutArray;



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
      if (is_array($val)) {
        $arr[$key] = self::findContentPlaceholder($val);
      }
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
  public static function getArray(string $type): array {
   
    return LayoutCreation::getData($type)['@types'][$type];
    // Adds a object around the content to reduce code higher 
    // in the response observer stack.

    //$content = $layouts['@types'][$type]['content'];
    //$layouts['@types'][$typeUsed]['content'] = (object) [$content];

  //'layouts' => $layouts['@types'][$typeUsed];


  }

}