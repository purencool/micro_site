<?php

namespace App\Repository\Utilities;

/**
 * FindPhpObject
 *
 * @author purencool
 */
class FindPhpObject {

  /**
   * Gets serialized PHP object.
   * 
   * @param string $schema
   *   Default source directory.
   * @param mixed $request
   *   Request object.
   */
  public static function getObject($schema, $request) {
    $iti = new \RecursiveDirectoryIterator($schema);
    foreach (new \RecursiveIteratorIterator($iti) as $file) {
      if (strpos($file, $request) !== false) {
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        if ($ext === 'txts') {
          return $file;
        }
      }
    }
    return false;
  }
}
