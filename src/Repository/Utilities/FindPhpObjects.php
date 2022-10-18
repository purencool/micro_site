<?php

namespace App\Repository\Utilities;

/**
 * FindPhpObjects
 *
 * @author purencool
 */
class FindPhpObjects {

  /**
   * Gets serialized PHP object.
   * 
   * @param string $schema
   *   Default source schema.
   */
  public static function getObjects($schema) {
    $return = [];
    $iti = new \RecursiveDirectoryIterator($schema);
    foreach (new \RecursiveIteratorIterator($iti) as $item) {
      $ext = pathinfo($item, PATHINFO_EXTENSION);
      if ($ext === 'txts') {
        $return[] = $item;
      }
    }
    return $return;
  }

}
