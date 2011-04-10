<?php

/*
 * This file is part of the YATA package.
 *
 * (c) Colin DeCarlo <colin@thedecarlos.ca>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace YATA\Test;

require __DIR__ . '/../bootstrap.php';

use YATA\Statuses;

class StatusesTest extends \PHPUnit_Framework_TestCase
{

  public function testCanSendStatusUpdate()
  {

    $statuses = new Statuses();
    $statuses->getRequest()
      ->setConsumerKey('<YOUR CONSUMER KEY>')
      ->setConsumerSecretKey('<YOUR CONSUMER SECRET KEY>')
      ->setOauthTokenSecret('<YOUR OAUTH SECRET TOKEN>')
      ->setOauthToken('<YOUR OAUTH TOKEN>');
    $tweet = $statuses->update("Tweeting with #YATA");
    $this->assertTrue(is_array($tweet));
    $this->assertArrayHasKey('text', $tweet);

  }

  public function testCanGetMentions()
  {

    $statuses = new Statuses();
    $statuses->getRequest()
      ->setConsumerKey('<YOUR CONSUMER KEY>')
      ->setConsumerSecretKey('<YOUR CONSUMER SECRET KEY>')
      ->setOauthTokenSecret('<YOUR OAUTH SECRET TOKEN>')
      ->setOauthToken('<YOUR OAUTH TOKEN>');
    $mentions = $statuses->mentions();
    
    $this->assertTrue(is_array($mentions));
    $this->assertArrayHasKey('text', $mentions[0]);

  }

}

