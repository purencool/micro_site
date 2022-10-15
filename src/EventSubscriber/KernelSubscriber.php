<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\EventSubscriber\Processes\BlockRequestTest;

/**
 *  The KernelSubscriber takes requests and blocks the following items,
 *  1. Unwanted bot traffic or header strings.
 *  2. IP addresses that are undesirable.
 *  4. Method requests like POST, PUT etc.
 *  5. Locking requests to a group of IPs.
 * 
 *  @author purencool
 */
class KernelSubscriber implements EventSubscriberInterface {

  /**
   * Checking to see if testing is enabled
   * 
   * @var string
   */
  private static $testEnabled;

  /**
   * Kernel constructor
   * 
   * @param type $test
   */
  public function __construct($test) {
    self::$testEnabled = $test;
  }

  /**
   * @inherit
   */
  public static function getSubscribedEvents(): array {
    return [RequestEvent::class => 'onKernelRequest'];
  }

  /**
   * Adds Blocking Request tests to each Kernel request to 
   * block unwanted types of traffic.
   * 
   * @param RequestEvent $event
   * @return void
   * @throws AccessDeniedHttpException
   */
  public function onKernelRequest(RequestEvent $event): void {
    if (!$event->isMainRequest()) {
      return;
    }

    if (BlockRequestTest::request($event, self::$testEnabled) === true) {
      throw new AccessDeniedHttpException('Access Denied');
    }
  }

}
