<?php

namespace App\Repository\JsonConversion;

/**
 * The ConfigInterface enforces the public methods needed for 
 * interacting with the systems for Layout Array Creation.
 *
 * @author purencool
 */
interface ConfigInterface {

  /**
   * 
   * @param String $cachePath
   *    The directory files are added to for caching. 
   * @return array
   *    Messaging the result of the Layout cache build. Response example below:
   *    [
   *      'action one is completed',
   *      'action two has this error',
   *    ]
   */
  public function setConfigArray(): array;
}
