<?php

namespace App\Repository\CacheBuilding;

use App\Repository\Utilities\Schema;
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

    JsonPhpConverter::converter(Schema::getSiteCacheTest());

    return [' PHP object creation'];
  }

  public function getJsonContentConversion(): array {

    JsonPhpConverter::converter(Schema::getSiteCacheContent());
    return [' Content PHP object creation completed.'];
  }

}
