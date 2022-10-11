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

    return array_merge(
      [' aaa'], [' bbbb'], [' ffff']
    );
  }

}
