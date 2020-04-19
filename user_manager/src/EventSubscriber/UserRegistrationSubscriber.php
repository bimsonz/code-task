<?php

namespace Drupal\user_manager\EventSubscriber;

use Drupal\Core\Entity\EntityStorageException;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\user_manager\Event\UserRegistrationEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserRegistrationSubscriber implements EventSubscriberInterface {

  /**
   * Logger.
   *
   * @var \Drupal\Core\Logger\LoggerChannel
   */
  protected $logger;

  /**
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $loggerFactory
   *   Logger channel.
   */
  public function __construct(LoggerChannelFactoryInterface $loggerFactory) {
    $this->logger = $loggerFactory->get('user_manager');
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      UserRegistrationEvent::EVENT_NAME => 'onUserRegistration',
    ];
  }

  /**
   * Subscribe to the dispatched user login event.
   *
   * @param \Drupal\user_manager\Event\UserRegistrationEvent $event
   *   User registration event object.
   */
  public function onUserRegistration(UserRegistrationEvent $event) {
    try {
      $user = $event->getUserAccount();

      if ($user->isActive() != TRUE) {
        $user->activate();
      }

      if ($user->hasRole('reader') != TRUE) {
        $user->addRole('reader');
      }

      $user->save();

    }
    catch (EntityStorageException $exception) {
      $this->logger->emergency(
        'An error was found while saving the newly registered user: @message',
        ['@message' => $exception->getMessage()]
      );
    }
  }

}
