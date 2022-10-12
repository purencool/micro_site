<?php

namespace App\Repository\Processes;


/**
 * The Install class completes the following functions.
 *  1. Installs the default layouts out of core.
 *  2. Creates and installs the custom configuration for the development team.
 *  3. Setups data directories that's used for caching.
 *
 * @author purencool
 */
interface InstallInterface {


  /**
   * Installing site configuration and caching system.
   * 
   * @return array
   *    Lets the user know the results of the process.
   */
  public static function create(): array;

}
