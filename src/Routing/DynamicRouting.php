<?php

namespace App\Routing;

use Symfony\Component\Routing\Route;
use Symfony\Component\Config\Loader\Loader;
use App\Repository\CacheRequests\PhpObject;
use Symfony\Component\Routing\RouteCollection;

/**
 * 
 */
class DynamicRouting extends Loader {

  /**
   * 
   * @var type
   */
  private static $prodRoutesArr;


  /**
   * 
   * @var type
   */
  private static $testRoutesArr;

  /**
   * 
   * @var type
   */
  private $testEnabled;

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
    $this->testEnabled = $test;
    if($this->testEnabled === 'true'){
      self::testRouteArray();
    }
    self::prodRouteArray();
  }

  /**
   *  Get route object to create an array to build routes for the system.
   */
  private static function prodRouteArray() {
    $obj = new PhpObject;
    foreach ($obj->getPhpObject('prod_routes', 'cont_prod')['array_objects'] as $object) {
      if (property_exists($object, '@route')) {
        self::$prodRoutesArr[] = $object->{'@route'};
      }
    }
  }


  /**
   *  Get route object to create an array to build routes for the system.
   */
  private static function testRouteArray() {
    $obj = new PhpObject;
    foreach ($obj->getPhpObject('test_routes', 'cont_test')['array_objects'] as $object) {
      if (property_exists($object, '@route')) {
        self::$testRoutesArr[] = $object->{'@route'};
      }
    }
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

    // Prod routes
    foreach (self::$prodRoutesArr as $route) {
      $createdRoute = new Route($route . '/', [
        '_controller' => 'App\Controller\DynamicRoutingController::index',
      ]);
      $routeName = 'dr_prod' . str_replace(['-', '/'], '_', $route);
      $collection->add($routeName, $createdRoute);
    }

    // Adds test routes for development reasons
    if ($this->testEnabled === 'true') {

      foreach (self::$testRoutesArr as $testroute) {
        $createdRoute = new Route($testroute . '/{parameter}', [
          '_controller' => 'App\Controller\DynamicRoutingController::index',
        ]);
        $routeName = 'dr_test' . str_replace(['-', '/'], '_', $testroute);
        $collection->add($routeName, $createdRoute);
      }

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
