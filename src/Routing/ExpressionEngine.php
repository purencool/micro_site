<?php

namespace App\Repository\Twig;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Description of TwigExpressionEngine
 *
 * @author purencool
 */
class ExpressionEngine {

  /**
   * Expression engine array.
   * 
   * @var array $expression
   */
  protected static $expression = [
    '@string' => '<expression_variable>',
    '@extend' => "{% extends '<expression_variable>' %}"
  ];

  /**
   * Adding twig configuration to the file.
   * 
   * @param type $contents
   *    Configuration for the template.
   * @param type $path
   *    Path to add configuration.
   */
  public static function renderConfiguration($contents,$path) {
    $ds = DIRECTORY_SEPARATOR;
    $filesystem = new Filesystem();
    @mkdir($path.'templates');
    $filesystem->dumpFile($path . $ds . 'templates'. $ds . $contents['@creation'], '{# Created by Twig Expresion Engine #}');
    foreach ($contents['@config'] as $config_key => $config_value) {
      if (!is_array($config_value)) {
        if ($config_key == '@extend') {
          $stringToReplace = self::$expression['@extend'];
          $twig = str_replace(self::$expression['@string'], $config_value, $stringToReplace);
          $filesystem->appendToFile($path . $ds . 'templates'. $ds . $contents['@creation'], $twig, true);
        }
      }
    }
  }

}
