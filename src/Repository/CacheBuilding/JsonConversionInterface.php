<?php

namespace App\Repository\CacheBuilding;

/**
 * Converts Json objects to serialized PHP objects.
 *
 * @author purencool
 */
interface JsonConversionInterface {

  /**
   * Converts Json objects to serialized PHP objects.
   * 
   * @return array
   *    Messaging the result of the Layout cache build. Response example below:
   *    [
   *      'action one is completed',
   *      'action two has this error',
   *    ]
   */
  public function getJsonConversion(): array;

  /**
   * Converts Json objects to serialized PHP objects for content.
   * 
   * @return array
   *    Messaging the result of the Layout cache build. Response example below:
   *    [
   *      'action one is completed',
   *      'action two has this error',
   *    ]
   */
  public function getJsonContentConversion(): array;
}
