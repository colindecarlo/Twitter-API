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

use YATA\Users;

class UsersTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @dataProvider searchProvider
   */
  public function testCanSearch($query, $optParams)
  {
    $users = new Users();
    $users->getRequest()
      ->setConsumerKey('<YOUR CONSUMER KEY>')
      ->setConsumerSecretKey('<YOUR CONSUMER SECRET KEY>')
      ->setOauthTokenSecret('<YOUR OAUTH SECRET TOKEN>')
      ->setOauthToken('<YOUR OAUTH TOKEN>');
    $results = $users->search($query, $optParams);
    
    $this->assertTrue(is_array($results));
    $this->assertArrayHasKey('id', $results[0]);

  }

  /**
   * @dataProvider searchProvider
   */
  public function testCanShowByScreenName($screenName, $optParams)
  {
    $users = new Users();
    $users->getRequest()
      ->setConsumerKey('<YOUR CONSUMER KEY>')
      ->setConsumerSecretKey('<YOUR CONSUMER SECRET KEY>')
      ->setOauthTokenSecret('<YOUR OAUTH SECRET TOKEN>')
      ->setOauthToken('<YOUR OAUTH TOKEN>');
    $results = $users->showByScreenName($screenName, $optParams);
    
    $this->assertTrue(is_array($results));
    $this->assertArrayHasKey('id', $results);

  }

  public function searchProvider()
  {

    return array(
      array('bnmrrs', array()),
      array('burningbeardev', array()),
      array('cbitton', array()),
      array('colindecarlo', array()),
      array('getbadged', array()),
      array('gordl', array()),
      array('iservice', array()),
      array('KoreaOnTheRocks', array()),
      array('sammirza', array()),
      array('shacklady', array()),
      array('ts2_ca', array()),
    );

  }

}
