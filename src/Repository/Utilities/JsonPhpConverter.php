<?php

namespace App\Repository\Utilities;

use App\Repository\Utilities\SchemaEncodeDecode;

/**
 * Description of JsonPhpConverter
 *
 * @author purencool
 */
class JsonPhpConverter {

  public static $layoutArray = [];

  /**
   * Creates serialized PHP object.
   * 
   * @param type $src
   *   Default source directory.
   */
  public static function buildLayoutArray($src) {
    $ds = DIRECTORY_SEPARATOR;
    $dir = opendir($src);
    while (( $file = readdir($dir))) {
      if (( $file != '.' ) && ( $file != '..' )) {
        if (\is_dir($src . $ds . $file)) {
          self::buildLayoutArray($src . $ds . $file);
        }
        else {
          $ext = pathinfo($src . $ds . $file, PATHINFO_EXTENSION);
          if ($ext === 'json') {
            $key = basename($src . $ds . $file, '.' . $ext);
            self::$layoutArray[$key . '.data'][$key . '.path'] = substr($src . $ds . $file, 0, -5);
            self::$layoutArray[$key . '.data'][$key . '.array'] = self::arraySerialization($src . $ds . $file, 'decode');
          }
        }
      }
    }
    closedir($dir);
  }

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
