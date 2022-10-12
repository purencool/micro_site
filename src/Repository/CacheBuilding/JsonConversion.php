<?php

namespace App\Repository\CacheBuilding;

use App\Repository\Utilities\Paths;
use App\Repository\Utilities\JsonPhpConverter;

/**
 * Description
 *
 * @author purencool
 */
class JsonConversion implements JsonConversionInterface {

  /**
   * 
   * @return array
   */
  public function getJsonConversion(): array {
    
    JsonPhpConverter::converter(Paths::getSiteCacheTest());

    JsonPhpConverter::buildLayoutArray(Paths::getSiteCacheTestLayoutStructure());
    
    JsonPhpConverter::fileCreation(
      Paths::getSiteCacheTest() . 'layout_object.json',
      JsonPhpConverter::arraySerialization(
        JsonPhpConverter::$layoutArray,
        'serialize'
      )
    );

    return [' Layout reset creation'];
  }

}
