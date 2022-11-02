<?php

namespace App\Controller\Observers;

/**
 * Gets data array after building the content from the route.
 *
 * @author purencool
 */
class DataLayout {

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
   * Test to see if the content '@data' object matches the content reference 
   * so that it can be added to the 'layout_data_combined' array.
   * 
   * @param array $content
   *     The content object is tested for key.
   * @param type $contentReference
   *     This is the key need to access the data.
   * @return string
   *     Returns content data.
   */
  private static function recursiveSearch($content, String $contentReference): string {

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

//self::getContentForLayout(
        //           $item,
        //          $data
        //      );
      }
      else {
        //print_r($item);
        if (!property_exists($item, '@data')) {
          print $key;
          $returnArr[$key][] = (array) $item;
        }
        else {
          
        }
      }
      //else {
      //   $itemArray = (array) $item;
      //   foreach ($itemArray as $arrayItems) {
      //     print_r($arrayItems); exit;
      //    if (is_object($arrayItems)) {
      //      if (property_exists($arrayItems, '@data') &&
      //       property_exists($arrayItems, '@schema_name')) {
      //        $returnArr[$key][] = self::getContentForLayout(
      //            $arrayItems,
      //           $data
      //       );
      //     }
      //    }
      //   }
      // }
    }

    return $returnArr;
  }


private static function object_to_array($obj) {
    if(is_object($obj)) {$obj = (array) $obj;}
    if(is_array($obj)) {
        $new = array();
        foreach($obj as $key => $val) {
            $new[$key] = self::object_to_array($val);
        }
    }
    else {$new = $obj; }
    return $new;       
}

  /**
   * Returns meshed data with layout array.
   * 
   * @param  array $data
   *    Gets layout array ready for meshing
   * @return array
   *    Data connected to the route.
   */
  public static function getDataLayout(array $data, string $type = 'preprocessor'): array {
   

   if ($type == 'preprocessor') {
      return ['preprocessor' => self::object_to_array(self::createDataLayout($data))];
    }
    return array_merge(['preprocessor' => self::createDataLayout($data)], $data);
  }

}
