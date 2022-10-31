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
   */
  private static function routeArray($routeName) {
    $obj = new PhpObject();
    foreach ($obj->getPhpObject('routes', 'cont')['array_objects'] as $object) {
      if (property_exists($object, '@route')) {
        if ($object->{'@route'} == rtrim($routeName, '/')) {
          return $object->{'@schema'};
        }
      }
    }
    return '';
  }

  /**
   * 
   * @param type $routeName
   * @return type
   */
  private static function routeRebuild($routeName) {
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
  public static function getData($routeName): array {
    $routeRebuildArr = self::routeRebuild($routeName);
    $schema = self::routeArray($routeRebuildArr['@route']);
    $data = self::routeData($schema);
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
          'cont',
          $data->{'@type'},
          $data->{'@data'},
        ),
      ]
    ];
  }

}
