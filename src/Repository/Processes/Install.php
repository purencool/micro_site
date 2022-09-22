<?php

namespace App\Repository\Processes;

use App\Repository\Utilities\MoveDirectoryAndFiles;

/**
 * The Install class completes the following functions.
 *  1. Installs the default layouts out of core.
 *  2. Creates and installs the custom configuration for the development team. 
 *
 * @author purencool
 */
class Install {

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
   * Installs default layouts out of core.
   */
  protected static function installDefaultLayouts() {
    MoveDirectoryAndFiles::copySD(
      self::$path . 'core' . self::$ds . 'layouts' . self::$ds,
      self::$path . 'templates' . self::$ds . 'layouts'
    );
  }

  /**
   * Installs custom layouts out of core.
   */
  protected static function installCustomWebsite() {
    $webCustomPath = self::$path . ".." . self::$ds . 'website_configuration';
    if (!is_dir($webCustomPath)) {
      MoveDirectoryAndFiles::copySD(
        self::$path . 'core' . self::$ds . 'website_configuration' . self::$ds,
        $webCustomPath,
      );
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
  public static function create() : array {
    self::$ds = DIRECTORY_SEPARATOR;
    self::$path = __DIR__ . self::$ds . ".." . self::$ds . ".." . self::$ds . ".." . self::$ds;
    self::installDefaultLayouts();
    self::installCustomWebsite();
    return [ 'result' => 'Your installation was completed' ];
  }

}
