<?php

namespace App\Repository\Processes;

use App\Repository\Utilities\MoveDirectoryAndFiles;

/**
 * The Install class completes the following functions.
 *  1. Installs the default layouts out of core.
 *  2. Creates and installs the custom configuration for the development team.
 *  3. Setups data directories that's used for caching.
 *
 * @author purencool
 */
class Install {

  /**
   * Sets directory separator.
   * 
   * @var string
   */
  protected static $ds = DIRECTORY_SEPARATOR;

  /**
   * Sets the real path to that applications root.
   * 
   * @var string
   */
  protected static $path;

  /**
   * Installs custom layouts out of core.
   */
  protected static function installCustomWebsite() {
    $webCustomPath = self::$path . ".." . self::$ds . 'websites';
    if (!is_dir($webCustomPath)) {
      MoveDirectoryAndFiles::copySD(
        self::$path . 'core' . self::$ds . 'websites' . self::$ds,
        $webCustomPath,
      );
    }
  }

  /**
   * Installs the websites data directory out of core.
   */
  protected static function installWebsiteDataDirectory() {
    $dataCustomPath = self::$path . ".." . self::$ds . 'data';
    if (!is_dir($dataCustomPath)) {
      MoveDirectoryAndFiles::copySD(
        self::$path . 'core' . self::$ds . 'data' . self::$ds,
        $dataCustomPath,
      );
    }
  }

  /**
   * Sets up cache directories for applications.
   */
  protected static function installCacheDirectory() {

    $basePath = self::$path . 'var' . self::$ds . 'cache' . self::$ds;
    $directoryPaths = [
      $basePath . 'site',
      $basePath . 'site' . self::$ds . 'test',
      $basePath . 'site' . self::$ds . 'test' . self::$ds . 'layouts',
      $basePath . 'site' . self::$ds . 'test' . self::$ds . 'content',
      $basePath . 'site' . self::$ds . 'prod',
      $basePath . 'site' . self::$ds . 'prod' . self::$ds . 'layouts',
      $basePath . 'site' . self::$ds . 'prod' . self::$ds . 'content'
    ];

    foreach ($directoryPaths as $item) {
      if (!is_dir($item)) {
        mkdir($item);
      }
    }
  }

  /**
   * Create twig from Json object.
   * 
   * @param type $path
   *    Path to directory that has Json configuration.
   * 
   * @return array
   *    Lets the user know the results of the process.
   */
  public static function create(): array {
    self::$path = __DIR__ . self::$ds . ".." .
      self::$ds . ".." . self::$ds . ".." . self::$ds;

    self::installCustomWebsite();
    self::installWebsiteDataDirectory();
    self::installCacheDirectory();
    return ['response' => [' Your installation was completed']];
  }

}
