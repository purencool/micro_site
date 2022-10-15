<?php

namespace App\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * 
 */
class DynamicRouting extends Loader {

  /**
   * 
   * @var type
   */
  private static $routeArr = [
    '',
    'intro',
    'install/abc',
  ];

  /**
   * 
   * @var type
   */
  private static $testEnabled;

  /**
   * 
   * @var type
   */
  private $isLoaded = false;

  /**
   * 
   * @param type $testEnabled
   */
  public function __construct($test) {
    parent::__construct();
    self::$testEnabled = $test;
  }

  /**
   * 
   * @return type
   */
  public function routes() {
    return self::$routeArr;
  }

  /**
   * 
   * @param type $resource
   * @param string $type
   * @return string
   */
  public function supports($resource, string $type = null) {
    return 'extra' === $type;
  }

  /**
   * 
   * @param type $resource
   * @param string $type
   * @return RouteCollection
   * @throws \RuntimeException
   */
  public function load($resource, string $type = null) {

    if (true === $this->isLoaded) {
      throw new \RuntimeException('Do not add the "extra" loader twice');
    }
    // Routes collection 
    $collection = new RouteCollection();

    // Test routes
    foreach ($this->routes() as $route) {
      $createdRoute = new Route($route . '/{parameter}', [
        '_controller' => 'App\Controller\DynamicRoutingController::index',
      ]);
      $routeName = 'dr_test' . str_replace(['-', '/'], '_', $route);
      $collection->add($routeName, $createdRoute);
    }

    // Prod routes
    foreach ($this->routes() as $route) {
      $createdRoute = new Route($route . '/', [
        '_controller' => 'App\Controller\DynamicRoutingController::index',
      ]);
      $routeName = 'dr_prod' . str_replace(['-', '/'], '_', $route);
      $collection->add($routeName, $createdRoute);
    }

    // Adds style guides for development reasons
    if (self::$testEnabled === 'true') {
      $styleRoute = 'site-style-guide';
      $styleGuideRoute = new Route($styleRoute . '/{parameter}', [
        '_controller' => 'App\Controller\DynamicRoutingController::index',
      ]);
      $styleRouteName = 'dr_' . str_replace(['-', '/'], '_', $styleRoute);
      $collection->add($styleRouteName, $styleGuideRoute);
    }

    return $collection;
  }

}
