<?php

namespace App\Repository\Processes;

use App\Repository\Utilities\RemoveDirectoryAndFiles;
use App\Repository\JsonConversion\Layouts\LayoutArrayBuilder;
use App\Repository\Utilities\Paths;

/**
 * The LayoutCaches class completes the following functions.
 *  1. Destroy caches for layout arrays.
 *  2. Creates caches for the layout arrays.
 *
 * @author purencool
 */
class Caching {

  /**
   * Destroy caches.
   * 
   * @param String $caches
   *    Allows the user to choose which caches need to be cleared.
   *    By default all will need to be destroyed.
   * @return array
   *    Lets the user know the results of the process.
   */
  public static function destroy(String $caches = "all"): array {

    $returnString = '';

    switch ($caches) {

      case 'test':
        $directoryPaths = [
          Paths::getSiteCacheTestLayoutStructure(),
        ];
        $returnString = ' Test caches have been deleted.';
        break;

      case 'prod':
        $directoryPaths = [
          Paths::getSiteCacheProdLayoutStructure(),
        ];
        $returnString = ' Prod caches have been deleted.';
        break;

      default:
        $directoryPaths = [
          Paths::getSiteCacheTestLayoutStructure(),
          Paths::getSiteCacheProdLayoutStructure(),
        ];
        $returnString = ' Test and Prod caches have been deleted.';
        break;
    }

    foreach ($directoryPaths as $item) {
      if (is_dir($item)) {
        RemoveDirectoryAndFiles::deleteSD($item);
      }
    }

    return ['response' => [$returnString]];
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
      Paths::getSiteCacheProdLayoutStructure(),
      Paths::getProductionLayoutsConfig($layoutEnvVariable)
    );

    return array_merge(
      [' Prod caches have been rebuilt.'],
      $layoutResult
    );
  }

  /**
   * Create Layout caches so the system can use them.
   * 
   * @param String $caches
   *    Allows the user to choose which caches need to be created.
   *    By default all will need to be created.
   * @param String $layoutEnvVariable
   *    Gives the cache building system the layout environment directory.
   * @return array
   *    Lets the user know the results of the process.
   */
  public static function create(String $layoutEnvVariable, String $caches = 'all'): array {


    switch ($caches) {

      case 'test':
        $returnArr = self::cachingTest($layoutEnvVariable);
        break;

      case 'prod':
        $returnArr = self::cachingProd($layoutEnvVariable);
        break;

      default:
        $returnArr = array_merge(
          self::cachingTest($layoutEnvVariable),
          self::cachingProd($layoutEnvVariable)
        );
        break;
    }

    // Run content array builder.
    return ['response' => $returnArr];
  }

}
