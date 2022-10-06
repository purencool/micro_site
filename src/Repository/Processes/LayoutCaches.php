<?php

namespace App\Repository\Processes;

use App\Repository\Utilities\RemoveDirectoryAndFiles;
use App\Repository\Layouts\LayoutArrayBuilder;

/**
 * The LayoutCaches class completes the following functions.
 *  1. Destroy caches for layout arrays.
 *  2. Creates caches for the layout arrays.
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
    self::$path = __DIR__ . self::$ds . ".." .
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
      'cache' . self::$ds . 'site' . self::$ds . 'layouts';

    if (is_dir($pathProd)) {
      RemoveDirectoryAndFiles::deleteSD($pathProd);
    }

    return ['response' => [' Caches have been destroyed']];
  }

  /**
   * Create Layout caches so the system can use them.
   * 
   * @param String $layoutEnvVariable
   *    Gives the cache building system the layout environment directory it 
   *    needs to implement.
   * @return array
   *    Lets the user know the results of the process.
   */
  public static function create(String $layoutEnvVariable): array {
    self::globalPath();

    //Build layout caching files.
    $layoutArrayObj = new LayoutArrayBuilder();
    $layoutArrayObjResponse = $layoutArrayObj->setLayoutArray(
      self::$path . 'var' . self::$ds . 'cache' . self::$ds . 'site' . self::$ds . 'layouts',
      self::$path . 'templates' . self::$ds . 'layouts' . self::$ds . $layoutEnvVariable . self::$ds . 'structure' . self::$ds
    );

    // Run content array builder.


    return ['response' => array_merge(
        // Letting user know what has been started.
        [
          " Layout caches are being created using: $layoutEnvVariable.",
        ],
        // Getting layout cache building response.
        $layoutArrayObjResponse
      )
    ];
  }

}
