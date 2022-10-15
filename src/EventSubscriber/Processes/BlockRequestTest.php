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
    if ($type === 'true' && end(explode('/', $uri)) === 'test') {
      $request = DataObjects::dataRequest('config')[0]->block;
    }
    else {
      $request = DataObjects::dataRequest('config', 'prod')[0]->block;
    }

    // Blocking user agents.
    if ($request->user_agent !== '') {
      if (!in_array($event->getRequest()->headers->all('user_agent'),
          explode(',', $request->user_agent), true)
      ) {
        return true;
      }
    }

    // Blocking IP addresses.
    if ($request->ips !== '') {
      if (!in_array($event->getRequest()->getClientIp(),
          explode(',', $request->ips), true)
      ) {
        return true;
      }
    }

    // Blocking method types.
    if ($request->methods !== '') {
      if (!in_array($event->getRequest()->getMethod(),
          explode(',', $request->methods), true)
      ) {
        return true;
      }
    }

    // Locking to IP addresses.
    if ($request->locking !== '') {
      if (!in_array($event->getRequest()->getClientIp(),
          explode(',', $request->locking), true)
      ) {
        return true;
      }
    }

    return false;
  }

}
