<?php

namespace App\Repository\Processes;

use App\Repository\Utilities\RemoveDirectoryAndFiles;

/**
 * The Caches class completes the following functions.
 *  1. Delete caches.
 *  2. Destroy caches.
 *
 * @author purencool
 */
class Caches {

  /**
   * Sets directory separator.
   * 
   * @var string
   */
  protected static $ds;

  /**
   * Sets the real path to that applications root.
   * 
   * @var string
   */
  protected static $path;
  

  /**
   * Destroy caches.
   * 
   * 
   * @return array
   *    Lets the user know the results of the process.
   */
  public static function destroy(): array {
    self::$ds = DIRECTORY_SEPARATOR;
    self::$path = __DIR__ . self::$ds . ".." . self::$ds . ".." . self::$ds . ".." . self::$ds.'var';

    RemoveDirectoryAndFiles::deleteSD(self::$path);
    print_r(scandir(self::$path));
    
    echo "destroyed"; exit;
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
    self::$ds = DIRECTORY_SEPARATOR;
    self::$path = __DIR__ . self::$ds . ".." . self::$ds . ".." . self::$ds . ".." . self::$ds;
    return ['response' => 'Caches have been created'];
  }

}
