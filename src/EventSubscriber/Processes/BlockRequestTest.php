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
    $endOfUrl = end(explode('/', $uri));
    if ($type === 'true' && $endOfUrl === 'test') {
      $b = DataObjects::dataRequest('config')['array_objects']->block;
    }
    else {
      $b = DataObjects::dataRequest('config', 'prod')['array_objects']->block;
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
    if ($b->ips !== '') {
      if (!in_array($event->getRequest()->getClientIp(),
          explode(',', $b->ips), true)
      ) {
        return true;
      }
    }

    // Blocking method types.
    if ($b->methods !== '') {
      if (!in_array($event->getRequest()->getMethod(),
          explode(',', $b->methods), true)
      ) {
        return true;
      }
    }

    // Locking to IP addresses.
    if ($b->locking !== '') {
      if (!in_array($event->getRequest()->getClientIp(),
          explode(',', $b->locking), true)
      ) {
        return true;
      }
    }

    return false;
  }

}
