<?php

namespace App\Repository\Processes;

use App\Repository\Utilities\MoveDirectoryAndFiles;
use App\Repository\Utilities\Schema;

/**
 * The Install class completes the following functions.
 *  1. Installs the default layouts out of core.
 *  2. Creates and installs the custom configuration for the development team.
 *  3. Setups data directories that's used for caching.
 *
 * @author purencool
 */
class Install implements InstallInterface {

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

    if (!is_dir(Schema::getWebsiteConfiguration())) {
      MoveDirectoryAndFiles::copySD(
        Schema::getRoot() . 'initial_install' . self::$ds . 'websites' . self::$ds,
        Schema::getWebsiteConfiguration(),
      );
    }
  }

  /**
   * Installs the websites data directory out of core for the websites initial
   * display of content.
   */
  protected static function installWebsiteDataDirectory() {

    if (!is_dir(Schema::getWebsiteData())) {
      MoveDirectoryAndFiles::copySD(
        Schema::getRoot() . 'initial_install' . self::$ds . 'data' . self::$ds,
        Schema::getWebsiteData()
      );
    }
  }

  /**
   * Sets up cache directories for application.
   */
  protected static function installCacheDirectory() {

    $directorySchema = [
      Schema::getLayoutTemplates(),
      Schema::getTestTemplates(),
      Schema::getProductionTemplates(),
      Schema::getTestAssets(),
      Schema::getProductionAssets(),
      Schema::getSiteCache(),
      Schema::getSiteCacheContent(),
      Schema::getSiteTestCacheContent(),
      Schema::getSiteProdCacheContent(),
      Schema::getSiteCacheTest(),
      Schema::getSiteCacheTestSrc(),
      Schema::getSiteCacheTestSrcProd(),
      Schema::getSiteCacheTestLayoutStructure(),
      Schema::getSiteCacheProd()
    ];

    foreach ($directorySchema as $item) {
      if (!is_dir($item)) {
        mkdir($item);
      }
    }
  }

  /**
   * @inherit
   */
  public static function create(): array {

    self::installCacheDirectory();
    self::installCustomWebsite();
    self::installWebsiteDataDirectory();
    return ['response' => [' Your installation was completed']];
  }

}
