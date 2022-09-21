<?php

namespace App\Repository\Twig;

use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

/**
 * Description of TwigExpressionEngine
 *
 * @author purencool
 */
class TwigExpressionEngine {

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
  protected static function addToFile($contents, $path)
  {
    $filesystem = new Filesystem();
      foreach ($contents['@config'] as $config_key => $config_value) {
        if(!is_array($config_value)){
          if($config_key == '@extend') {
            $stringToReplace = self::$expression['@extend'];
            $twig = str_replace(self::$expression['@string'], $config_value, $stringToReplace);
            $filesystem->appendToFile($path.$contents['@creation'],$twig, true);
          }
        }
      } 
  }

  /**
   * Testing to see if the configuration files is for twig.
   * 
   * @param type $path
   *    Path of twig configuration directory.
   * @param type $fileName
   *    File name of the configuration file.
   */
  protected static function templateCreation($path,$fileName) 
  {

    $filesystem = new Filesystem();
    $pathFileName = $path.$fileName;
    $contents = json_decode(file_get_contents($pathFileName), true);
    if (isset($contents['@type']) && $contents['@type'] === 'twig' && isset($contents['@config'])) {
      $filesystem->dumpFile($path.$contents['@creation'],'{# Created by Twig Expresion Engine #}');
      self::addToFile($contents, $path);
    }
  }

  /**
   * 
   * @param type $path
   */
  protected static function recursiveCopy() 
  {
    $ds = DIRECTORY_SEPARATOR;
    $src = __DIR__ . $ds . ".." . $ds . ".." . $ds . ".." . $ds . "templates" . $ds . "layouts";
    $dir = opendir($src);
    while (( $file = readdir($dir))) {
      if (( $file != '.' ) && ( $file != '..' ) && \is_dir($src . $ds . $file)) {
        $filesArray = scandir($src . $ds . $file);
        foreach ($filesArray as $fileName) {
          if (( $fileName != '.' ) && ( $fileName != '..' )) {
            self::templateCreation($src . $ds . $file . $ds , $fileName);
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
   */
  public static function create() 
  {
    self::recursiveCopy();
  }

}
