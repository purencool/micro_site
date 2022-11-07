<?php

namespace App\Repository\Processes;

use App\Repository\Utilities\Schema;
use App\Repository\CacheBuilding\JsonConversion;
use App\Repository\Utilities\MoveDirectoryAndFiles;

/**
 * @inheritDoc
 *  
 * @author purencool
 */
class ContentDeploy implements ContentDeployInterface {

  /**
   * Moves data from data directory to site caching.
   * 
   * @return array
   *    Response to process.
   */
  private static function moveData(): array {
    MoveDirectoryAndFiles::copySD(
      Schema::getWebsiteData(),
      Schema::getSiteTestCacheContent()
    );

    return [' Content Json deployed to cache.'];
  }

  /**
   * Moves data from data directory to site caching.
   * 
   * @return array
   *    Response to process.
   */
  private static function convertData(): array {
    $jsonObjects = new JsonConversion();
    return $jsonObjects->getJsonContentConversion();
  }

  /**
   * Creates custom systems PHP objects used by the system.
   * 
   * @return array
   *    Response to process.
   */
  private static function systemDataObjects(): array {
    
    

    return [' System data objects.', ' Route list has been created.'];
  }

  /**
   * @inheritDoc
   */
  public static function deploy(): array {

    return ['response' => array_merge(
        self::moveData(),
        self::convertData(),
        self::systemDataObjects()
    )];
  }

}
