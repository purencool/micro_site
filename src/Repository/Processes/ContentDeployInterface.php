<?php

namespace App\Repository\Processes;


/**
 * The  ContentDeployInterface class achieves several functions.
 *  1. Moves custom configuration to the correct directory in the system.
 *  2. Build content objects.
 *  
 * @author purencool
 */
interface ContentDeployInterface {

  /**
   * Updates website content into the system for deployment.
   * 
   * @return array
   *    Lets the user know the results of the process. 
   */
  public static function deploy(): array;

}
