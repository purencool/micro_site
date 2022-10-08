<?php

namespace App\Repository\Utilities;

/**
 * Description of Paths
 *
 * @author purencool
 */
class Paths {

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
   *  Setup paths needed for this class to run relevant tasks.
   */
  protected static function globalPath() {
    self::$path = __DIR__ . self::$ds . ".." .
      self::$ds . ".." . self::$ds . ".." . self::$ds;
  }

  /**
   * 
   * @return string
   */
  public static function getRoot(): string {
    self::globalPath();
    return self::$path;
  }

  /**
   * 
   * @return string
   */
  public static function getWebsiteConfiguration(): string {
    self::globalPath();
    return self::$path . ".." . self::$ds . 'websites';
  }

  /**
   * 
   * @return string
   */
  public static function getWebsiteData(): string {
    self::globalPath();
    return self::$path . ".." . self::$ds . 'data';
  }

  /**
   * 
   * @return string
   */
  public static function getCacheDir(): string {
    self::globalPath();
    return self::$path . 'var' . self::$ds . 'cache' . self::$ds;
  }

  /**
   * 
   * @return string
   */
  public static function getSiteCache(): string {
    self::globalPath();
    return self::getCacheDir() . self::$ds . 'site' . self::$ds;
  }

  /**
   * 
   * @return string
   */
  public static function getSiteCacheContent(): string {
    self::globalPath();
    return self::getSiteCache() . self::$ds . 'content' . self::$ds;
  }

  /**
   * 
   * @return string
   */
  public static function getSiteCacheTest(): string {
    self::globalPath();
    return self::getSiteCache() . self::$ds . 'test' . self::$ds;
  }

  /**
   * 
   * @return string
   */
  public static function getSiteCacheTestSrc(): string {
    self::globalPath();
    return self::getSiteCacheTest() . self::$ds . 'src' . self::$ds;
  }

  /**
   * 
   * @return string
   */
  public static function getSiteCacheTestLayouts(): string {
    self::globalPath();
    return self::getSiteCacheTest() . self::$ds . 'layout' . self::$ds;
  }

  /**
   * 
   * @return string
   */
  public static function getSiteCacheProd(): string {
    self::globalPath();
    return self::getSiteCache() . self::$ds . 'prod' . self::$ds;
  }

  /**
   * 
   * @return string
   */
  public static function getSiteCacheProdSrc(): string {
    self::globalPath();
    return self::getSiteCacheProd() . self::$ds . 'src' . self::$ds;
  }

  /**
   * 
   * @return string
   */
  public static function getSiteCacheProdLayouts(): string {
    self::globalPath();
    return self::getSiteCacheProd() . self::$ds . 'layout' . self::$ds;
  }

  /**
   * 
   * @return string
   */
  public static function getProductionLayouts(): string {
    self::globalPath();
    return self::$path . 'templates' . self::$ds . 'layouts' . self::$ds;
  }

  /**
   * 
   * @param String $environment
   * @return string
   */
  public static function getProductionLayoutsConfig(String $environment): string {
    self::globalPath();
    return self::$path . 'templates' . self::$ds . 'layouts' .
      self::$ds . $environment . self::$ds . 'structure' . self::$ds;
  }

  /**
   * 
   * @return string
   */
  public static function getTestLayouts(): string {
    self::globalPath();
    return self::$path . ".." . self::$ds . 'websites' . self::$ds;
  }

  /**
   * 
   * @param String $environment
   * @return string
   */
  public static function getTestLayoutsConfig(String $environment): string {
    self::globalPath();
    return self::$path . ".." . self::$ds . 'websites' .
      self::$ds . $environment . self::$ds . 'layouts' .
      self::$ds . $environment . self::$ds . 'structure' . self::$ds;
  }

}
