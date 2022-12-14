<?php

namespace App\Repository\CacheRequests;

use App\Repository\Utilities\Schema;
use App\Repository\Utilities\FindPhpObjects;
use App\Repository\Utilities\SchemaEncodeDecode;

/**
 * Returns PHP objects the system has requested.
 *
 * @author purencool
 */
class PhpObjectsList implements PhpObjectsListInterface {

  /**
   * Data PHP object request method.
   * 
   * @param String $schema
   *    Schema category needed to access to the data.
   * @param String $typeOfObject
   *    Type of object needed by the system.
   * @return array
   *    Return data structures.
   */
  protected function getData(String $schema, String $typeOfObjects) {

    $schemaResult = FindPhpObjects::getObjects($schema . $typeOfObjects);
    if ($schemaResult === false) {
      return (object) [
          'error' => 'true',
          'message' => 'Data objects does not exist.'
      ];
    }

    $return = [];
    foreach ($schemaResult as $schemaItem) {
      $return[] = [
        'object' => SchemaEncodeDecode::requestObject($schemaItem),
        'schema' => $schemaItem
      ];
    }

    return $return;
  }

  /**
   * @inherit
   */
  public function getPhpObjects($typeOfObjects, $environment = ''): array {

    if ($environment === 'prod') {
      $data = $this->getData(Schema::getSiteCacheProd(), $typeOfObjects);
    }
    elseif ($environment === 'cont_test') {
      $data = $this->getData(Schema::getSiteTestCacheContent(), $typeOfObjects);
    }
    elseif ($environment === 'cont_prod') {
      $data = $this->getData(Schema::getSiteProdCacheContent(), $typeOfObjects);
    }
    else {
      $data = $this->getData(Schema::getSiteCacheTest(), $typeOfObjects);
    }

    return [
      'response' => ' Data objects requested.',
      'array_objects' => $data,
    ];
  }

}
