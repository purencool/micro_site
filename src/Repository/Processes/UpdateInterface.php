<?php

namespace App\Repository\Processes;


/**
 * The Update class achieves several functions.
 *  1. Moves custom configuration to the correct directories in the system.
 *  2. Build the twig templates from configuration.
 *  
 * @author purencool
 */
interface UpdateInterface{

  /**
   *  Updates website data and configuration into the system for deployment.
   * 
   * @param String $layoutEnvVariable
   *    Gives Update Class the environment to find the default configuration.
   * @param String $update
   *    Update provides class with test or prod type.
   * @return array
   *    Lets the user know the results of the process. 
   */
  public static function update(String $layoutEnvVariable, String $update): array;

}
