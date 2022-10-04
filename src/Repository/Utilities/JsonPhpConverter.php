<?php

namespace App\Repository\Utilities;

/**
 * Description of JsonPhpConverter
 *
 * @author purencool
 */
class JsonPhpConverter {

  /**
   * Copies directories and files to another position.
   * 
   * @param type $src
   *   Default source directory.
   * @param type $dst
   *   Default destination directory.
   */
  public static function coverter($src, $dst) {
    $ds = DIRECTORY_SEPARATOR;
    if (!is_dir($src)) {
      mkdir($src, 0755, true);
    }
    $dir = opendir($src);
    @mkdir($dst);
    while (( $file = readdir($dir))) {
      if (( $file != '.' ) && ( $file != '..' )) {
        if (\is_dir($src . $ds . $file)) {
          self::copySD($src . $ds . $file, $dst . $ds . $file);
        }
        else {
          copy($src . $ds . $file, $dst . $ds . $file);
        }
      }
    }
    closedir($dir);
  }

}
