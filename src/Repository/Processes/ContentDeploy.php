<?php

namespace App\Repository\Processes;

use App\Repository\Utilities\Paths;
use App\Repository\CacheBuilding\JsonConversion;
use App\Repository\Utilities\MoveDirectoryAndFiles;

/**
 * The Update class achieves several functions.
 *  1. Moves custom configuration to the correct directories in the system.
 *  2. Build the twig templates from configuration.
 *  
 * @author purencool
 */
class ContentDeploy implements ContentDeployInterface {

  /**
   * @inherit
   */
  public static function deploy(): array {

    MoveDirectoryAndFiles::copySD(
      Paths::getWebsiteData(),
      Paths::getSiteCacheContent()
    );

    $jsonObjects = new JsonConversion();
    $returnArr = $jsonObjects->getJsonContentConversion();

    return ['response' => array_merge(
        [' Content Json deployed to cache.'],
        $returnArr
    )];
  }

}
