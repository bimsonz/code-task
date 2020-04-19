<?php

namespace Drupal\user_manager\EventSubscriber;

use Drupal\Core\Url;
use Drupal\user_manager\Event\UserLoginEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserLoginSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      UserLoginEvent::EVENT_NAME => 'onUserLogin',
    ];
  }

  /**
   * Subscribe to the dispatched user login event.
   *
   * @param \Drupal\user_manager\Event\UserLoginEvent $event
   *   User login event object.
   *
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   */
  public function onUserLogin(UserLoginEvent $event) {
    if ($event->getUserAccount()->hasRole('reader')) {
      $response = new RedirectResponse(Url::fromRoute('content_display.article.list')->toString());

      return $response->send();
    }
  }

}
