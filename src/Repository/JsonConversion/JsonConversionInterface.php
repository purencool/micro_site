<?php

namespace App\Repository\JsonConversion;

/**
 * The ConfigInterface enforces the public methods needed for 
 * interacting with the systems for Layout Array Creation.
 *
 * @author purencool
 */
interface JsonConversionInterface {

  /**
   * Implements data array contract for the layout build array and cache file 
   * creation.
   * 
   * @param String $cachePath
   *    The directory files are added to for caching. 
   * @param String $layoutPath
   *    The layout directory where the path configuration is resolved.
   * @return array
   *    Messaging the result of the Layout cache build. Response example below:
   *    [
   *      'action one is completed',
   *      'action two has this error',
   *    ]
   */
  public function getJsonConversion(): array;
}
