<?php

namespace App\Repository\Processes;

use App\Repository\Utilities\MoveDirectoryAndFiles;
use App\Repository\Twig\ExpressionEngine;

/**
 * The Update class achieves several functions.
 *  1. Moves custom configuration to the correct directories in the system.
 *  2. Build the twig templates from configuration.
 *  
 * @author purencool
 */
class Update {

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
   * Move custom layout configuration into the templates directory. 
   * 
   */
  protected static function moveCustomLayoutConfiguration() {
    $moveCustomConfig = self::$path . ".." . self::$ds . 'website_configuration' . self::$ds . 'layouts' . self::$ds;
    if (is_dir($moveCustomConfig)) {
      MoveDirectoryAndFiles::copySD(
        $moveCustomConfig,
        self::$path . 'templates' . self::$ds . 'layouts' . self::$ds,
      );
    }
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
            print_r($contents);
            print "<br>";
            print "<br>";
            // ExpressionEngine::renderConfiguration($contents, $src);
          }
        }
      }
    }
    closedir($dir);
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
  public static function update() : array {
    self::$ds = DIRECTORY_SEPARATOR;
    self::$path = __DIR__ . self::$ds . ".." . self::$ds . ".." . self::$ds . ".." . self::$ds;
    self::moveCustomLayoutConfiguration();
    $src = self::$path . 'templates' . self::$ds . 'layouts';
    self::createTwigConfigurationTemplating($src);
    return [ 'response' => 'System was updated' ];
  }

}
