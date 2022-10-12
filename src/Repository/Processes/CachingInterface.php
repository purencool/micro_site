<?php

namespace App\Repository\Processes;


/**
 * The LayoutCaches class completes the following functions.
 *  1. Destroy caches for layout arrays.
 *  2. Creates caches for the layout arrays.
 *
 * @author purencool
 */
interface CachingInterface {

  /**
   * Destroy caches.
   * 
   * @param String $caches
   *    Allows the user to choose which caches need to be cleared.
   *    By default all will need to be destroyed.
   * @return array
   *    Lets the user know the results of the process.
   */
  public static function destroy(String $caches = "all"): array;

   
  /**
   * Create Layout caches so the system can use them.
   * 
   * @return array
   *    Lets the user know the results of the process.
   */
  public static function create(): array;

}
