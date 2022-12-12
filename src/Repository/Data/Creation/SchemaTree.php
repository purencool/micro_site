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
   * @param type $items
   * @return type
   */
  private static function arrayConversion($items) {
    if (is_object($items)) {
      return (array) $items;
    }
    return $items;
  }

  /**
   * 
   * @param type $arrayPassedIn
   * @return type
   */
  private static function layoutBuilder($arrayPassedIn) {
    $itemsReturn = [];
    foreach ($arrayPassedIn as $key => $items) {
      if ($key == '@schema') {
        $data = DataObjects::dataRequest($items, 'layout')['array_objects'];
        $itemsReturn[$key] = self::layoutBuilder(self::arrayConversion($data));
      }
      elseif (is_string($items)) {
        $itemsReturn[$key] = $items;
      }
      else {
        $itemsReturn[$key] = self::layoutBuilder(self::arrayConversion($items));
      }
    }
    return $itemsReturn;
  }

  /**
   * 
   * @param object $arrayPassedIn
   * @return array
   */
  public static function create($arrayPassedIn): array {
    return self::layoutBuilder($arrayPassedIn);
  }

}
