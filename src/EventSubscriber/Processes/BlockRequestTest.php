<?php

namespace App\EventSubscriber\Processes;

use App\Repository\Processes\DataObjects;

/**
 *
 * @author john.cullen
 */
class BlockRequestTest implements BlockRequestTestInterface {

  /**
   * 
   * @return boolean
   */
  public static function request(): bool {

  // This is a kernal events
   $request = DataObjects::dataRequest('config');
   foreach ((array)$request[0]->block as $value) {
     return true;
   }

     return false;
  }
}
