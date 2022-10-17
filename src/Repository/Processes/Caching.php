<?php

namespace App\Repository\Processes;

use App\Repository\Utilities\RemoveDirectoryAndFiles;
use App\Repository\CacheBuilding\JsonConversion;
use App\Repository\Utilities\Schema;

/**
 * The LayoutCaches class completes the following functions.
 *  1. Destroy caches for layout arrays.
 *  2. Creates caches for the layout arrays.
 *
 * @author purencool
 */
class Caching implements CachingInterface {

  /**
   * 
   * @param String $layoutEnvVariable
   *    Gives the cache building system the layout environment directory.
   * @return array
   *    Lets the user know the results of the process.
   */
  protected static function cachingProd(String $layoutEnvVariable): array {

    //Build layout caching files for prod.
    $layoutArrayObj = new LayoutArrayBuilder();
    $layoutResult = $layoutArrayObj->setLayoutArray(
      Schema::getSiteCacheProdLayoutStructure(),
      Schema::getProductionLayoutsConfig($layoutEnvVariable)
    );

    return array_merge(
      [' Prod caches have been rebuilt.'],
      $layoutResult
    );
  }

  /**
   * @inherit
   */
  public static function create(): array {
    $jsonObjTest = new JsonConversion();
    $returnArr = $jsonObjTest->getJsonConversion();
    return ['response' => $returnArr];
  }

  /**
   * @inherit
   */
  public static function destroy(String $caches = "all"): array {

    $returnString = '';

    switch ($caches) {

      case 'test':
        $directorySchema = [
          Schema::getSiteCacheTestLayoutStructure(),
        ];
        $returnString = ' Test caches have been deleted.';
        break;

      case 'prod':
        $directorySchema = [
          Schema::getSiteCacheProdLayoutStructure(),
        ];
        $returnString = ' Prod caches have been deleted.';
        break;

      default:
        $directorySchema = [
          Schema::getSiteCacheTestLayoutStructure(),
          Schema::getSiteCacheProdLayoutStructure(),
        ];
        $returnString = ' Test and Prod caches have been deleted.';
        break;
    }

    foreach ($directorySchema as $item) {
      if (is_dir($item)) {
        RemoveDirectoryAndFiles::deleteSD($item);
      }
    }

    return ['response' => [$returnString]];
  }

}
