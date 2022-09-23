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
   * @param type $src
   *   Source path for the layout directories.
   */
  protected static function moveCustomLayoutConfiguration($src) {
    $dir = opendir($src);
    while (( $items = readdir($dir))) {
      if (( $items != '.' ) && ( $items != '..' )) {
        if (\is_dir($src . self::$ds . $items)) {
          if ($items == 'layouts') {
            MoveDirectoryAndFiles::copySD(
              $src . self::$ds . $items,
              self::$path . 'templates' . self::$ds . 'layouts' . self::$ds,
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
            // print $src . self::$ds . $items;
            ExpressionEngine::renderConfiguration($contents, $src . self::$ds);
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
  public static function update(): array {
    self::$ds = DIRECTORY_SEPARATOR;
    self::$path = __DIR__ . self::$ds . ".." . self::$ds . ".." . self::$ds . ".." . self::$ds;
    self::moveCustomLayoutConfiguration(
      self::$path . ".." . self::$ds . 'websites' . self::$ds
    );
    $src = self::$path . 'templates' . self::$ds . 'layouts';
    self::createTwigConfigurationTemplating($src);
    return ['response' => 'Updated sites custom configuration'];
  }

}
