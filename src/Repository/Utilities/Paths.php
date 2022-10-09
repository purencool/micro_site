<?php

namespace App\Repository\Utilities;

//add paths on install to assets and twig directories. 
//get update to move the data from website directory to correct part of the testing system

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
   * Setup paths needed for this class to run relevant tasks.
   */
  protected static function globalPath() {
    self::$path = __DIR__ . self::$ds . ".." .
      self::$ds . ".." . self::$ds . ".." . self::$ds;
  }

  /**
   * Root path for the system.
   * 
   * @return string
   */
  public static function getRoot(): string {
    self::globalPath();
    return self::$path;
  }

  /**
   * Websites default configuration.
   * 
   * @return string
   */
  public static function getWebsiteConfiguration(): string {
    self::globalPath();
    return self::$path . ".." . self::$ds . 'websites';
  }

  /**
   * The websites data.
   * 
   * @return string
   */
  public static function getWebsiteData(): string {
    self::globalPath();
    return self::$path . ".." . self::$ds . 'data';
  }

  /**
   * The production template.
   * 
   * @return string
   */
  public static function getLayoutTemplates(): string {
    self::globalPath();
    return self::$path . "templates" . self::$ds . 'layouts' . self::$ds;
  }

  /**
   * The production template.
   * 
   * @return string
   */
  public static function getTestTemplates(): string {
    self::globalPath();
    return self::$path . "templates" . self::$ds .
      'layouts' . self::$ds . "test" . self::$ds;
  }

  /**
   * The production template.
   * 
   * @return string
   */
  public static function getProductionTemplates(): string {
    self::globalPath();
    return self::$path . "templates" . self::$ds .
      'layouts' . self::$ds . "prods" . self::$ds;
  }

  /**
   * The production template.
   * 
   * @return string
   */
  public static function getTestAssets(): string {
    self::globalPath();
    return self::$path . "public" . self::$ds . 'test' . self::$ds;
  }

  /**
   * The production template.
   * 
   * @return string
   */
  public static function getProductionAssets(): string {
    self::globalPath();
    return self::$path . "public" . self::$ds . 'prod' . self::$ds;
  }




  /**
   * Returns the default caching directory.
   * 
   * @return string
   */
  public static function getCacheDir(): string {
    self::globalPath();
    return self::$path . 'var' . self::$ds . 'cache' . self::$ds;
  }

  /**
   * Points to the sites default cache directory.
   * 
   * @return string
   */
  public static function getSiteCache(): string {
    self::globalPath();
    return self::getCacheDir() . self::$ds . 'site' . self::$ds;
  }

  /**
   * Allows the system to return the websites default data
   * 
   * @return string
   */
  public static function getSiteCacheContent(): string {
    self::globalPath();
    return self::getSiteCache() . self::$ds . 'content' . self::$ds;
  }

  /**
   * Sites testing cache directory.
   * 
   * @return string
   */
  public static function getSiteCacheTest(): string {
    self::globalPath();
    return self::getSiteCache() . self::$ds . 'test' . self::$ds;
  }

  /**
   * Testings auto load classes for custom configuration. 
   * 
   * @return string
   */
  public static function getSiteCacheTestSrc(): string {
    self::globalPath();
    return self::getSiteCacheTest() . self::$ds . 'src' . self::$ds;
  }

  /**
   * Websites test decoration layer cache.
   * 
   * @return string
   */
  public static function getSiteCacheTestLayoutStructure(): string {
    self::globalPath();
    return self::getSiteCacheTest() . self::$ds . 'layout_structure' . self::$ds;
  }

  /**
   * Production caching base directory.
   * 
   * @return string
   */
  public static function getSiteCacheProd(): string {
    self::globalPath();
    return self::getSiteCache() . self::$ds . 'prod' . self::$ds;
  }

  /**
   * Custom production website auto loaded configuration.
   * 
   * @return string
   */
  public static function getSiteCacheProdSrc(): string {
    self::globalPath();
    return self::getSiteCacheProd() . self::$ds . 'src' . self::$ds;
  }

  /**
   * Layout configuration that has been cached for production.
   * 
   * @return string
   */
  public static function getSiteCacheProdLayoutStructure(): string {
    self::globalPath();
    return self::getSiteCacheProd() . self::$ds . 'layout_structure' . self::$ds;
  }

  /**
   * Twig templating directory for the website.
   * 
   * @return string
   */
  public static function getProductionLayouts(): string {
    self::globalPath();
    return self::$path . 'templates' . self::$ds . 'layouts' . self::$ds;
  }

  /**
   * Configuration directory for production before cached.
   * 
   * @param String $environment
   * @return string
   */
  public static function getProductionLayoutsConfig(String $environment): string {
    self::globalPath();
    return paths::getProductionLayouts() .
      $environment . self::$ds . 'structure' . self::$ds;
  }

  /**
   * Test layouts are based in the websites.
   * 
   * @return string
   */
  public static function getTestLayouts(): string {
    self::globalPath();
    return self::$path . ".." . self::$ds . 'websites' . self::$ds;
  }

  /**
   * Test layout configuration.
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
