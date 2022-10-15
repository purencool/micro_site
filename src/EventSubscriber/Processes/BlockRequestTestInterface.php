<?php

namespace App\EventSubscriber\Processes;

/**
 * Returns object the system has requested.
 *
 * @author purencool
 */
interface BlockRequestTestInterface {

/**
 * The Request methods needs a Kernel Request event to test
 * if incoming traffic requests are legitimate traffic the 
 * system will allow access the website.
 * 
 * @param RequestEvent $event
 * @param String $type
 * @return bool
 */
  public static function request(RequestEvent $event, String $type): bool;
}
