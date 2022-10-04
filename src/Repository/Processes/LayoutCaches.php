<?php

namespace App\Repository\Processes;

use App\Repository\Utilities\RemoveDirectoryAndFiles;

/**
 * The LayoutCaches class completes the following functions.
 *  1. Delete caches.
 *  2. Destroy caches.
 *
 * @author purencool
 */
class LayoutCaches {

  /**
   * Sets directory separator.
   * 
   * @var string
   */
  private static $ds = DIRECTORY_SEPARATOR;

  /**
   * Sets the real path to that applications root.
   * 
   * @var string
   */
  private static $path;


  /**
   *  Setup paths needed for this class to run relevant tasks.
   */
  public static function globalPath() {
    self::$path =  __DIR__ . self::$ds . ".." . 
           self::$ds . ".." . self::$ds . ".." . self::$ds;
  }
  

  /**
   * Destroy caches.
   * 
   * 
   * @return array
   *    Lets the user know the results of the process.
   */
  public static function destroy(): array {
    self::globalPath();
    
    $pathProd = self::$path . 'var' . self::$ds . 
            'cache' . self::$ds . 'site'. self::$ds . 'layout';

    if (is_dir($pathProd)) {
      RemoveDirectoryAndFiles::deleteSD($pathProd);
    }

    return ['response' => 'Caches have been destroyed'];
  }

  /**
   * Create caches.
   * 
   * 
   * @return array
   *    Lets the user know the results of the process.
   */
  public static function create(): array {

    return ['response' => 'Caches have been created'];
  }

}
