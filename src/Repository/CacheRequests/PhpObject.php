<?php

namespace App\Repository\CacheRequests;

use App\Repository\Utilities\Schema;
use App\Repository\Utilities\SchemaDecode;
use App\Repository\Utilities\FindPhpObject;

/**
 * Returns PHP object the system has requested.
 *
 * @author purencool
 */
class PhpObject implements PhpObjectInterface {

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
  protected function getData(String $schema, String $typeOfObject) {

    $schemaResult = FindPhpObject::getObject($schema, $typeOfObject);
    if ($schemaResult === false) {
      return ['Data object does not exist'];
    }

    return SchemaDecode::requestObject($schemaResult);
  }

  /**
   * @inherit
   */
  public function getPhpObject($typeOfObjects, $environment = ''): array {

    if ($environment === 'prod') {
      $data = $this->getData(Schema::getSiteCacheProd(), $typeOfObjects);
    }
    elseif ($environment === 'cont') {
      $data = $this->getData(Schema::getSiteCacheContent(), $typeOfObjects);
    }
    else {
      $data = $this->getData(Schema::getSiteCacheTest(), $typeOfObjects);
    }

    return [
      'response' => ' Data object requested.',
      'object_array' => $data,
    ];
  }

}
