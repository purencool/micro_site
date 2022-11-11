<?php

namespace App\Repository\Processes;

use App\Repository\CacheRequests\PhpObject;
use App\Repository\Utilities\SchemaEncodeDecode;
use App\Repository\Data\Creation\DataTree;

/**
 * Description of CotentCreation
 *
 * @author purencool
 */
class ContentCreation implements ContentCreationInterface {

  /**
   *  Get route object to create an array to build routes for the system.
   * 
   * @param string $routeName
   * @param string $type
   * @return string
   */
  private static function routeArray($routeName, string $type): string {
    $obj = new PhpObject();
    $routes = '';

    if ($type == 'prod') {
      $routes = $obj->getPhpObject('prod_routes', 'cont_prod')['array_objects'];
    }
    elseif ($type == 'test') {
      $routes = $obj->getPhpObject('test_routes', 'cont_test')['array_objects'];
    } else {
      return 'no route';
    }

    foreach ($routes as $object) {
      if (property_exists($object, '@route')) {
        // Testing route is not the front page(/).
        if (strlen($routeName['@route']) === 1) {
          $routeTestString = $routeName['@route'];
        }
        else {
          $routeTestString = rtrim($routeName['@route'], '/');
        }
        if ($object->{'@route'} == $routeTestString) {
          return $object->{'@schema'};
        }
      }
    }
    return 'no route';
  }

  /**
   * 
   * @param type $routeName
   * @return type
   */
  private static function routeRebuild($routeName): array {
    $routeExplode = explode('/', $routeName);
    $responseType = '';

    if (end($routeExplode) == 'test' || end($routeExplode) == 'json') {
      $responseType = end($routeExplode);
      array_pop($routeExplode);
      $route = implode('/', $routeExplode);
      if ($route == '') {
        $route = '/';
      }
    }
    else {
      $route = $routeName;
    }

    return [
      '@route' => $route,
      '@response_type' => $responseType
    ];
  }

  /**
   * 
   * @param string $schema
   * @return mixed
   */
  private static function routeData(string $schema) {
    if ($schema == '') {
      return '';
    }
    return SchemaEncodeDecode::requestObject($schema);
  }

  /**
   * 
   * @param string $type
   * @return string
   */
  private static function contentCacheType(string $type) {
    if ($type == 'test') {
      return 'cont_test';
    }
    return 'cont_prod';
  }

  /**
   * @inheritDoc
   */
  public static function getData(string $routeName, string $type): array {
    $routeRebuildArr = self::routeRebuild($routeName);
    $schema = self::routeArray($routeRebuildArr, $type);

    if ($schema == 'no data') {
      return [
        'error' => 'true',
        'message' => 'Route does not exist.'
      ];
    }

    $data = self::routeData($schema);
    return [
      '@schema' => $schema,
      '@response_type' => $routeRebuildArr['@response_type'],
      '@data_array' => [
        '@title' => $data->{'@title'},
        '@route' => $data->{'@route'},
        '@link_text' => $data->{'@link_text'},
        '@layout' => $data->{'@layout'},
        '@type' => $data->{'@type'},
        '@data' => DataTree::getDataTree(
          'config',
          self::contentCacheType($type),
          $data->{'@type'},
          $data->{'@data'},
        ),
      ]
    ];
  }

}
