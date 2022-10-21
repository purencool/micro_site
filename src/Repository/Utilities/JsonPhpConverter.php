<?php

namespace App\Repository\Utilities;

use App\Repository\Utilities\SchemaEncodeDecode;

/**
 * Description of JsonPhpConverter
 *
 * @author purencool
 */
class JsonPhpConverter {

  /**
   * 
   * @param Mixed $path
   * @return mixed
   */
  public static function arraySerialization($data, String $type = '') {

    switch ($type) {
      case 'decode':
        return json_decode(file_get_contents($data));

      case 'serialize':
        return serialize($data);

      default:
        return serialize(json_decode(file_get_contents($data)));
    }
  }

  /**
   * 
   * @param type $path
   * @param type $data
   */
  public static function fileCreation($schema, $data) {
    SchemaEncodeDecode::createObject($schema, $data);
  }

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
            self::fileCreation(
              $src . $ds . $file,
              self::arraySerialization($src . $ds . $file)
            );
          }
        }
      }
    }
    closedir($dir);
  }

}
