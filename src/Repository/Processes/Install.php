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
   * Installs custom websites configuration out of core into a directory
   * above the applications system so developers can update applications
   * core and keep site configuration in a different repository.
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
   * Installs the websites data directory out of core for the websites initial
   * display of content.
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
   * Sets up cache directories for application.
   */
  protected static function installCacheDirectory() {

    $basePath = self::$path . 'var' . self::$ds . 'cache' . self::$ds;
    $directoryPaths = [
      $basePath . 'site',
      $basePath . 'site' . self::$ds . 'content',
      $basePath . 'site' . self::$ds . 'test',
      $basePath . 'site' . self::$ds . 'test' . self::$ds . 'layouts', 
      $basePath . 'site' . self::$ds . 'prod',
      $basePath . 'site' . self::$ds . 'prod' . self::$ds . 'layouts',
    ];

    foreach ($directoryPaths as $item) {
      if (!is_dir($item)) {
        mkdir($item);
      }
    }
  }

  /**
   * Installing site configuration and caching system.
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
