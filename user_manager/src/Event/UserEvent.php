<?php

namespace Drupal\user_manager\Event;

use Drupal\user\Entity\User;
use Drupal\user\UserInterface;
use Symfony\Component\EventDispatcher\Event;

class UserEvent extends Event {

  /**
   * User account.
   *
   * @var \Drupal\user\Entity\User
   */
  public $account;

  /**
   * Event object construction.
   *
   * @param \Drupal\user\UserInterface $account
   *   The account of the logged in user.
   */
  public function __construct(UserInterface $account) {
    $this->account = $account;
  }

  /**
   * Get current user account.
   *
   * @return \Drupal\user\Entity\User
   */
  public function getUserAccount() : User {
    return $this->account;
  }

}
