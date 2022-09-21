<?php

namespace App\Repository\Twig;

/**
 * Description of TwigExpressionEngine
 *
 * @author purencool
 */
class TwigExpressionEngine {

  /**
   * 
   * @param type $path
   */
  protected static function templateCreation($path) {
     echo $path . "<br>";
    // echo "<pre>";
     echo file_get_contents($path);
    // echo "</pre>";
    // echo "<br>";
    // echo "<pre>";
    // print_r(json_decode(file_get_contents($path)));
    // echo "</pre>";
    // echo "<br>";
    // echo "<br>";
  }

  /**
   * 
   * @param type $path
   */
  protected static function recursiveCopy() {
    $ds = DIRECTORY_SEPARATOR;
    $src = __DIR__ . $ds . ".." . $ds . ".." . $ds . ".." . $ds . "templates" . $ds . "layouts";
    $dir = opendir($src);
    while (( $file = readdir($dir))) {
      if (( $file != '.' ) && ( $file != '..' )) {
        if (\is_dir($src . $ds . $file)) {
          $filesArray = scandir($src . $ds . $file);
          foreach ($filesArray as $fileName) {
            if (( $fileName != '.' ) && ( $fileName != '..' )) {
              self::templateCreation($src . $ds . $file . $ds . $fileName);
            }
          }
        }
      }
    }
    closedir($dir);
  }

  /**
   * Create twig from Json object.
   * 
   * @param type $path
   *    Path to directory that has Json configuration.
   */
  public static function create() {
    self::recursiveCopy();
  }

}
