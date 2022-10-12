<?php

namespace App\Repository\Utilities;

/**
 * Description of FindPhpObject
 *
 * @author purencool
 */
class FindPhpObject {

  /**
   * Gets serialized PHP object.
   * 
   * @param type $src
   *   Default source directory.
   * @param type $request
   *   Request object.
   */
  public static function getObject($src, $request) {
    $iti = new \RecursiveDirectoryIterator($src);
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
