<?php

namespace App\Repository\Processes;

use App\Repository\Utilities\MoveDirectoryAndFiles;
use App\Repository\Utilities\Paths;

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
   * Installs custom websites configuration out of core into a directory
   * above the applications system so developers can update applications
   * core and keep site configuration in a different repository.
   */
  protected static function installCustomWebsite() {

    if (!is_dir(Paths::getWebsiteConfiguration())) {
      MoveDirectoryAndFiles::copySD(
        Paths::getRoot() . 'initial_install' . self::$ds . 'websites' . self::$ds,
        Paths::getWebsiteConfiguration(),
      );
    }
  }

  /**
   * Installs the websites data directory out of core for the websites initial
   * display of content.
   */
  protected static function installWebsiteDataDirectory() {

    if (!is_dir(Paths::getWebsiteData())) {
      MoveDirectoryAndFiles::copySD(
        Paths::getRoot() . 'initial_install' . self::$ds . 'data' . self::$ds,
        Paths::getWebsiteData()
      );
    }
  }

  /**
   * Sets up cache directories for application.
   */
  protected static function installCacheDirectory() {

    $directoryPaths = [
      Paths::getLayoutTemplates(),
      Paths::getTestTemplates(),
      Paths::getProductionTemplates(),
      Paths::getTestAssets(),
      Paths::getProductionAssets(),
      Paths::getSiteCache(),
      Paths::getSiteCacheContent(),
      Paths::getSiteCacheTest(),
      Paths::getSiteCacheTestSrc(),
      Paths::getSiteCacheTestLayoutStructure(),
      Paths::getSiteCacheProd(),
      Paths::getSiteCacheProdSrc(),
      Paths::getSiteCacheProdLayoutStructure(),
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

    self::installCustomWebsite();
    self::installWebsiteDataDirectory();
    self::installCacheDirectory();
    return ['response' => [' Your installation was completed']];
  }

}
