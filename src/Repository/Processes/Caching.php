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
class Caching {

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
   * @param String $caches
   *    Allows the user to choose which caches need to be cleared.
   *    By default all will need to be destroyed.
   * @return array
   *    Lets the user know the results of the process.
   */
  public static function destroy(String $caches = "all"): array {
    self::globalPath();

    $basePath = self::$path . 'var' . self::$ds . 'cache' . self::$ds;
    $returnString = '';

    switch ($caches) {

      case 'test':
        $directoryPaths = [
          $basePath . 'site' . self::$ds . 'test' . self::$ds . 'layouts',
        ];
        $returnString = ' Test caches have been deleted.';
        break;

      case 'prod':
        $directoryPaths = [
          $basePath . 'site' . self::$ds . 'prod' . self::$ds . 'layouts',
        ];
        $returnString = ' Prod caches have been deleted.';
        break;

      default:
        $directoryPaths = [
          $basePath . 'site' . self::$ds . 'test' . self::$ds . 'layouts',
          $basePath . 'site' . self::$ds . 'prod' . self::$ds . 'layouts',
        ];
        $returnString = ' Test and Prod caches have been deleted.';
        break;
    }

    foreach ($directoryPaths as $item) {
      if (is_dir($item)) {
        RemoveDirectoryAndFiles::deleteSD($item);
      }
    }

    return ['response' => [$returnString]];
  }

  /**
   * 
   * @param String $layoutEnvVariable
   *    Gives the cache building system the layout environment directory.
   * @return array
   *    Lets the user know the results of the process.
   */
  protected static function cachingTest(String $layoutEnvVariable): array {
    $basePath = self::$path . 'var' . self::$ds . 'cache' . self::$ds;

    //Build layout caching files for testing.
    $layoutArrayObj = new LayoutArrayBuilder();
    $layoutResult = $layoutArrayObj->setLayoutArray(
      $basePath . 'site' . self::$ds . 'test' . self::$ds . 'layouts',
      self::$path . 'templates' . self::$ds . 'layouts' . self::$ds . $layoutEnvVariable . self::$ds . 'structure' . self::$ds
    );

    return array_merge(
      [' Test caches have been rebuilt.'],
      $layoutResult
    );
  }

  /**
   * 
   * @param String $layoutEnvVariable
   *    Gives the cache building system the layout environment directory.
   * @return array
   *    Lets the user know the results of the process.
   */
  protected static function cachingProd(String $layoutEnvVariable): array {
    $basePath = self::$path . 'var' . self::$ds . 'cache' . self::$ds;

    //Build layout caching files for prod.
    $layoutArrayObj = new LayoutArrayBuilder();
    $layoutResult = $layoutArrayObj->setLayoutArray(
      $basePath . 'site' . self::$ds . 'prod' . self::$ds . 'layouts',
      self::$path . 'templates' . self::$ds . 'layouts' . self::$ds . $layoutEnvVariable . self::$ds . 'structure' . self::$ds
    );

    return array_merge(
      [' Prod caches have been rebuilt.'],
      $layoutResult
    );
  }

  /**
   * Create Layout caches so the system can use them.
   * 
   * @param String $caches
   *    Allows the user to choose which caches need to be created.
   *    By default all will need to be created.
   * @param String $layoutEnvVariable
   *    Gives the cache building system the layout environment directory.
   * @return array
   *    Lets the user know the results of the process.
   */
  public static function create(String $layoutEnvVariable, String $caches = 'all'): array {
    self::globalPath();

    switch ($caches) {

      case 'test':
        $returnArr = self::cachingTest($layoutEnvVariable);
        break;

      case 'prod':
        $returnArr = self::cachingProd($layoutEnvVariable);
        break;

      default:
        $returnArr = array_merge(
          self::cachingTest($layoutEnvVariable),
          self::cachingProd($layoutEnvVariable)
        );
        break;
    }

    // Run content array builder.
    return ['response' => $returnArr];
  }

}
