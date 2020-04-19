<?php

namespace Drupal\Tests\user_manager\Unit;

use Drupal\Tests\UnitTestCase;
use Drupal\user\Entity\User;
use Drupal\user_manager\Event\UserEvent;

class UserEventTest extends UnitTestCase {

  /**
   * Test user events.
   */
  public function testUserEvent() {
    $userProphet = $this->prophesize(User::class);

    $user = $userProphet->reveal();

    $event = new UserEvent($user);
    $this->assertEquals($user, $event->getUserAccount());
  }

}
