<?php

namespace App\Controller\Observers;

use App\Repository\Processes\ContentCreation;
use App\Repository\Processes\LayoutCreation;

/**
 * Gets data array after building the content from the route.
 *
 * @author purencool
 */
class DataLayout {

/**
 * 
 * @param array $array
 * @return array
 */
  private static function flatten(array $array) {
    $return = [];
    array_walk_recursive($array, function ($a) use (&$return) {
      $return[] = $a;
    });
    return $return;
  }

/**
 * 
 * @param type $content
 * @param type $contentReference
 * @return string
 */
  private static function recursiveSearch($content, $contentReference) {

    foreach ($content as $contentItem) {
      if (array_key_exists($contentReference, (array) $contentItem->{'@data'})) {
        return $contentItem->{'@data'}->{$contentReference};
      }
    }

    return 'Content couldn\'t not be found';
  }

 /**
  * 
  * @param type $placeholderObject
  * @param type $data
  * @return type
  */
  private static function getContentForLayout($placeholderObject, $data) {
    $contentResult = self::recursiveSearch(
        self::flatten($data['data']['@data_array']['@data']),
        $placeholderObject->{'@schema_name'}
    );

    $key = array_search(
      '@content_placeholder',
      $placeholderObject->{'@data'}
    );

    $placeholderObject->{'@data'}[$key] = $contentResult;

    return $placeholderObject;
  }

  /**
   * Gets data array after building the content from the route.
   * 
   * @param string $data
   *    $data.
   * @return array
   *    Data connected to the route.
   */
  public static function getDataLayout($data) {
    $returnArr = [];
    foreach ($data['layouts'] as $key => $item) {
      if (property_exists($item, '@data')) {
        $returnArr[$key] = self::getContentForLayout(
            $item,
            $data
        );
      }
      else {
        $itemArray = (array) $item;
        foreach ($itemArray as $arrayItems) {
          if (is_object($arrayItems)) {
            if (property_exists($arrayItems, '@data') &&
              property_exists($arrayItems, '@schema_name')) {
              $returnArr[$key][] = self::getContentForLayout(
                  $arrayItems,
                  $data
              );
            }
          }
        }
      }
    }

    return array_merge(['layout_data_combined' => $returnArr], $data);
  }

}
