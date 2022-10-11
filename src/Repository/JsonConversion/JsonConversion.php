<?php

namespace App\Repository\JsonConversion;

use App\Repository\JsonConversion\Layouts\LayoutArrayBuilder;

/**
 * Description
 *
 * @author purencool
 */
class JsonConversion implements JsonConversionInterface {

  /**
   * 
   * @param type $testOrProd
   */
  public function __construct() {
  }

  /**
   * 
   * @param String $layoutEnvVariable
   *    Gives the cache building system the layout environment directory.
   * @return array
   *    Lets the user know the results of the process.
   */
  protected static function cachingTest(String $layoutEnvVariable): array {

    //Build layout caching files for testing.
    $layoutArrayObj = new LayoutArrayBuilder();
    $layoutResult = $layoutArrayObj->setLayoutArray(
      Paths::getSiteCacheTestLayoutStructure(),
      Paths::getTestLayoutsConfig($layoutEnvVariable)
    );

    return array_merge(
      [' Test caches have been rebuilt.'],
      $layoutResult
    );
  }



  public function getJsonConversion(): array {
    $configuration = new Config();
    $returnConfig = $configuration->setConfigArray();
    //$this->cachingTest($layoutEnvVariable);

    return array_merge($returnConfig ,
      [' aaa'], [' bbbb'], [' ffff']
    );
  }

}
