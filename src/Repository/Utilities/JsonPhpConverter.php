<?php

namespace App\Repository\Utilities;

/**
 * Description of JsonPhpConverter
 *
 * @author purencool
 */
class JsonPhpConverter {

  /**
   * Creates serialized PHP object.
   * 
   * @param type $src
   *   Default source directory.
   */
  public static function converter($src) {
    $ds = DIRECTORY_SEPARATOR;
    $dir = opendir($src);
    while (( $file = readdir($dir))) {
      if (( $file != '.' ) && ( $file != '..' )) {
        if (\is_dir($src . $ds . $file)) {
          self::converter($src . $ds . $file);
        }
        else {
          $ext = pathinfo($src . $ds . $file, PATHINFO_EXTENSION);
          if ($ext === 'json') {
            $data = serialize(json_decode(file_get_contents($src . $ds . $file)));
            $newFileName = substr($src . $ds . $file, 0, -4);
            $fp = fopen($newFileName . 'txts', 'w');
            fwrite($fp, $data);
            fclose($fp);
          }
        }
      }
    }
    closedir($dir);
  }

}
