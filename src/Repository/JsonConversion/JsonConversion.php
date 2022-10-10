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
   * @var type
   */
  private $testOrProd;

  /**
   * 
   * @param type $testOrProd
   */
  public function __construct($testOrProd) {
    $this->testOrProd = $testOrProd;
    $this->init();
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

  protected function init() {
    //$this->cachingTest($layoutEnvVariable);
  }

  public function getJsonConversion(): array {

    return [];
  }

}
