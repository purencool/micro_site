<?php

namespace App\EventSubscriber\Processes;

/**
 *
 * @author john.cullen
 */
interface BlockRequestTestInterface {

  /**
   * 
   * @return boolean
   */
  public static function request(): bool;
}
