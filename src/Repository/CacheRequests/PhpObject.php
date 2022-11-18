<?php

namespace App\Repository\CacheRequests;

use App\Repository\Utilities\Schema;
use App\Repository\Utilities\FindPhpObject;
use App\Repository\Utilities\SchemaEncodeDecode;

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
      return (object) [
          'error' => 'true',
          'message' => 'Data object does not exist.'
      ];
    }

    return SchemaEncodeDecode::requestObject($schemaResult);
  }

  /**
   * @inherit
   */
  public function getPhpObject($typeOfObject, $environment = ''): array { 
    if ($environment === 'prod') {
      $data = $this->getData(Schema::getSiteCacheProd(), $typeOfObject);
    }
    elseif ($environment === 'cont_test') {
      $data = $this->getData(Schema::getSiteTestCacheContent(), $typeOfObject);
    }
    elseif ($environment === 'cont_prod') {
      $data = $this->getData(Schema::getSiteProdCacheContent(), $typeOfObject);
    }
    elseif ($environment === 'layout') {
      $data = $this->getData(
        Schema::getSiteCacheTestLayoutStructure(),
        $typeOfObject
      );
    }
    else {
      $data = $this->getData(Schema::getSiteCacheTest(), $typeOfObject);
    }

    return [
      'response' => ' Data object requested.',
      'array_objects' => $data,
    ];
  }

}
