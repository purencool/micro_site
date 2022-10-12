<?php

namespace App\Repository\Processes;

use App\Repository\Utilities\MoveDirectoryAndFiles;
use App\Repository\Twig\ExpressionEngine;
use App\Repository\Utilities\Paths;

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
              Paths::getProductionLayouts(),
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
    // self::createTwigConfigurationTemplating(Paths::getProductionLayouts());

    switch ($update) {

      case 'test':

        copy(
          Paths::getWebsiteEnvironment($layoutEnvVariable) . "config.json",
          Paths::getSiteCacheTest() . "config.json"
        );

        MoveDirectoryAndFiles::copySD(
          Paths::getWebsiteTwigTemplates($layoutEnvVariable),
          Paths::getTestTemplates()
        );

        MoveDirectoryAndFiles::copySD(
          Paths::getWebsiteLayoutStructure($layoutEnvVariable),
          Paths::getSiteCacheTestLayoutStructure()
        );

        MoveDirectoryAndFiles::copySD(
          Paths::getWebsiteAssets($layoutEnvVariable),
          Paths::getTestAssets()
        );

        MoveDirectoryAndFiles::copySD(
          Paths::getWebsiteSrc($layoutEnvVariable),
          Paths::getSiteCacheTestSrc()
        );

        $returnArr = " Updated configuration from $layoutEnvVariable to test.";
        break;

      case 'prod':

        copy(
          Paths::getSiteCacheTest() . "config.json",
          Paths::getSiteCacheProd() . "config.json"
        );

        MoveDirectoryAndFiles::copySD(
          Paths::getTestTemplates(),
          Paths::getProductionTemplates(),
        );

        MoveDirectoryAndFiles::copySD(
          Paths::getSiteCacheTestLayoutStructure(),
          Paths::getSiteCacheProdLayoutStructure()
        );

        MoveDirectoryAndFiles::copySD(
          Paths::getTestAssets(),
          Paths::getProductionAssets()
        );

        MoveDirectoryAndFiles::copySD(
          Paths::getSiteCacheTestSrc(),
          Paths::getSiteCacheProdSrc()
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
