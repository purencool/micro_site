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
   *  Moves data from data directory to site test caching.
   * 
   * @return array
   *    Response to process.
   */
  private static function moveTestData(): array {
    MoveDirectoryAndFiles::copySD(
      Schema::getWebsiteData(),
      Schema::getSiteTestCacheContent()
    );

    return [' Content deployed test to cache.'];
  }

  /**
   * Moves test data to production caching.
   * 
   * @return array
   *    Response to process.
   */
  private static function moveProdData(): array {
    MoveDirectoryAndFiles::copySD(
      Schema::getSiteTestCacheContent(),
      Schema::getSiteProdCacheContent(),
    );

    return [' Content deployed prod to cache.'];
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
   * @inheritDoc
   */
  public static function deploy(string $type): array {

    if ($type == 'test') {

      $return = ['response' => array_merge(
          self::moveTestData(),
          self::convertData(),
      )];
    }
    elseif ($type == 'prod') {

      $return = ['response' => self::moveProdData()];
    }
    else {

      $return = ['response' => 'deployment incomplete'];
    }
    return $return;
  }

}
