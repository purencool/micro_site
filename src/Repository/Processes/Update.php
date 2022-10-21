<?php

namespace App\Repository\Processes;

use App\Repository\Utilities\MoveDirectoryAndFiles;
use App\Repository\Twig\ExpressionEngine;
use App\Repository\Utilities\Schema;
use App\Repository\Utilities\FindStringAndReplace;

/**
 * The Update class achieves several functions.
 *  1. Moves custom configuration to the correct directories in the system.
 *  2. Build the twig templates from configuration.
 *  
 * @author purencool
 */
class Update implements UpdateInterface {

  /**
   * Sets directory separator.
   * 
   * @var string
   */
  protected static $ds = DIRECTORY_SEPARATOR;

  /**
   * Move custom layout configuration into the templates directory. 
   * 
   * @param type $src
   *   Source path for the layout directories.
   */
  protected static function moveLayoutTemplates($src, $directory = 'test') {
    $dir = opendir($src);
    while (( $items = readdir($dir))) {
      if (( $items != '.' ) && ( $items != '..' )) {
        if (\is_dir($src . self::$ds . $items)) {
          if ($items == $directory) {
            MoveDirectoryAndFiles::copySD(
              $src . self::$ds . $items,
              Schema::getProductionLayouts(),
            );
          }
          self::moveCustomLayoutConfiguration($src . self::$ds . $items);
        }
      }
    }
    closedir($dir);
  }

  /**
   * Creation of the twig templates using configuration from the Json in
   * the layout directories.
   * 
   * @param type $src
   *   Source path for the layout directories.
   */
  protected static function createTwigConfigurationTemplating($src) {
    $dir = opendir($src);
    while (( $items = readdir($dir))) {
      if (( $items != '.' ) && ( $items != '..' )) {
        if (\is_dir($src . self::$ds . $items)) {
          self::createTwigConfigurationTemplating($src . self::$ds . $items);
        }
        else {
          $contents = json_decode(file_get_contents($src . self::$ds . $items), true);
          if (isset($contents['@type']) && $contents['@type'] === 'twig' && isset($contents['@config'])) {
            ExpressionEngine::renderConfiguration($contents, $src . self::$ds);
          }
        }
      }
    }
    closedir($dir);
  }

  /**
   * @inherit
   */
  public static function update(String $layoutEnvVariable, String $update): array {

    // Recreating the templating system. @todo
    // self::createTwigConfigurationTemplating(Schema::getProductionLayouts());

    switch ($update) {

      case 'test':

        copy(
          Schema::getWebsiteEnvironment($layoutEnvVariable) . "config.json",
          Schema::getSiteCacheTest() . "config.json"
        );

        MoveDirectoryAndFiles::copySD(
          Schema::getWebsiteTwigTemplates($layoutEnvVariable),
          Schema::getTestTemplates()
        );

        MoveDirectoryAndFiles::copySD(
          Schema::getWebsiteLayoutStructure($layoutEnvVariable),
          Schema::getSiteCacheTestLayoutStructure()
        );

        MoveDirectoryAndFiles::copySD(
          Schema::getWebsiteAssets($layoutEnvVariable),
          Schema::getTestAssets()
        );

        MoveDirectoryAndFiles::copySD(
          Schema::getWebsiteSrc($layoutEnvVariable),
          Schema::getSiteCacheTestSrc()
        );

        MoveDirectoryAndFiles::copySD(
          Schema::getSiteCacheTestSrc(),
          Schema::getSiteCacheTestSrcProd()
        );

        FindStringAndReplace::setReplace(
          Schema::getSiteCacheTestSrcProd(),
          'namespace App\CacheTest;',
          'namespace App\CacheProd;'
        );

        $returnArr = " Updated configuration from $layoutEnvVariable to test.";
        break;

      case 'prod':

        MoveDirectoryAndFiles::copySD(
          Schema::getTestTemplates(),
          Schema::getProductionTemplates(),
        );

        MoveDirectoryAndFiles::copySD(
          Schema::getSiteCacheTest(),
          Schema::getSiteCacheProd()
        );

        MoveDirectoryAndFiles::copySD(
          Schema::getTestAssets(),
          Schema::getProductionAssets()
        );

        $returnArr = ' Updated configuration from test to production.';
        break;

      default:
        $returnArr = ' Update test|prod parameter wasn\'t called.';
        break;
    }

    return ['response' => [$returnArr]];
  }

}
