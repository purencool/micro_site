<?php

namespace App\Repository\Processes;


/**
 * Requests list of PHP objects from the caching.
 *  
 * @author purencool
 */
Interface LayoutCreationInterface{

  /**
   * Requests list of PHP objects from the caching.
   * @return array
   *    Lets the user know the results of the process. 
   */
  public static function create(): array;

}
