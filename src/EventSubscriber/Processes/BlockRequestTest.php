<?php

namespace App\EventSubscriber\Processes;

use App\Repository\Processes\DataObjects;

/**
 * Returns object the system has requested.
 *
 * @author purencool
 */
class BlockRequestTest implements BlockRequestTestInterface {

  /**
   * @inherit
   */
  public static function request($event, $type): bool {

    // Checking if the user is allowed to access the testing cache.
    $uri = $event->getRequest()->getUri();
    $exploadedUri = explode('/', $uri);
    $endOfUrl = end($exploadedUri);
    if ($type === 'true' && $endOfUrl === 'test') {
      $b = DataObjects::dataRequest('config')['array_objects']->block;
    }
    else {
      $test = DataObjects::dataRequest('config', 'prod');
      if(property_exists($test['array_objects'], 'error')){
        return true;
      }
      $b = $test['array_objects']->block;
    }

    // Blocking user agents.
    if (property_exists($b, 'user_agent')) {
      if ($b->user_agent !== '') {
        if (!in_array($event->getRequest()->headers->all('user_agent'),
            explode(',', $b->user_agent), true)
        ) {
          return true;
        }
      }
    }

    // Blocking IP addresses.
    if (property_exists($b, 'ips')) {
      if ($b->ips !== '') {
        if (!in_array($event->getRequest()->getClientIp(),
            explode(',', $b->ips), true)
        ) {
          return true;
        }
      }
    }

    // Blocking method types.
    if (property_exists($b, 'methods')) {
      if ($b->methods !== '') {
        if (!in_array($event->getRequest()->getMethod(),
            explode(',', $b->methods), true)
        ) {
          return true;
        }
      }
    }

    // Locking to IP addresses.
    if (property_exists($b, 'locking')) {
      if ($b->locking !== '') {
        if (!in_array($event->getRequest()->getClientIp(),
            explode(',', $b->locking), true)
        ) {
          return true;
        }
      }
    }

    return false;
  }

}
