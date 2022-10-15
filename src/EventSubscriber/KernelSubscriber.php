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
 */
class KernelSubscriber implements EventSubscriberInterface {

  /**
   * @inherit
   */
  public static function getSubscribedEvents(): array {
    return [RequestEvent::class => 'onKernelRequest'];
  }

  /**
   * 
   * @param RequestEvent $event
   * @return void
   * @throws AccessDeniedHttpException
   */
  public function onKernelRequest(RequestEvent $event): void {
    if (!$event->isMainRequest()) {
      return;
    }

    // Blocking user agents.
    if (in_array($event->getRequest()->headers->all('user_agent'), ['192.168.001.1'], true)) {
      throw new AccessDeniedHttpException('Access Denied');
    }
    // Blocking IP addresses.
    if (in_array($event->getRequest()->getClientIp(), ['192.168.001.1'], true)) {
      throw new AccessDeniedHttpException('Access Denied');
    }

    // Blocking method types.
    if (in_array($event->getRequest()->getMethod(), ['192.168.001.1'], true)) {
      throw new AccessDeniedHttpException('Access Denied');
    }

    // Locking to IP addresses.
   if (!in_array($event->getRequest()->getClientIp(), ['192.168.001.1'], true)) {
      throw new AccessDeniedHttpException('Access Denied');
   }
   
  }

}
