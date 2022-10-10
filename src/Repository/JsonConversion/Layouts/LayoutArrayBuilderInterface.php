<?php

namespace App\Repository\JsonConversion\Layouts;

/**
 * The LayoutArrayBuilderInterface enforces the public methods needed for 
 * interacting with the systems for Layout Array Creation.
 *
 * @author purencool
 */
interface LayoutArrayBuilderInterface {

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
  public function setLayoutArray(String $cachePath, String $layoutPath): array;
}
