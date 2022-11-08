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
    }

    foreach ($routes as $object) {
      if (property_exists($object, '@route')) {
        if ($object->{'@route'} == rtrim($routeName['@route'], '/')) {
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
  private static function routeRebuild($routeName) : array {
    $routeExplode = explode('/', $routeName);
    $responseType = '';

    if (end($routeExplode) == 'test' || end($routeExplode) == 'json') {
      $responseType = end($routeExplode);
      array_pop($routeExplode);
      $route = implode('/', $routeExplode);
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
   * @param type $schema
   * @return string
   */
  private static function routeData($schema) {
    if ($schema == '') {
      return '';
    }
    return SchemaEncodeDecode::requestObject($schema);
  }

  /**
   * @inheritDoc
   */
  public static function getData(string $routeName, string $type): array {
    $routeRebuildArr = self::routeRebuild($routeName);
    $schema = self::routeArray($routeRebuildArr, $type);
    $data = self::routeData($schema);
    if($type == 'test'){
      $cacheType = 'cont_test';
    } else {
      $cacheType = 'cont_prod';
    }
    return [
      '@schema' => $schema,
      '@response_type' => $routeRebuildArr['@response_type'],
      '@data_array' => [
        '@route' => $data->{'@route'},
        '@link_text' => $data->{'@link_text'},
        '@layout' => $data->{'@layout'},
        '@type' => $data->{'@type'},
        '@data' => DataTree::getDataTree(
          'config',
          $cacheType,
          $data->{'@type'},
          $data->{'@data'},
        ),
      ]
    ];
  }

}
