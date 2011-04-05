<?php

namespace YATA\Test\Request;

require __DIR__ . '/../../bootstrap.php';

use YATA\Request\OAuth,
    YATA\YATA;

class OAuthTest extends \PHPUnit_Framework_TestCase
{

  public function testGetOAuthRequestTokenWorks()
  {

    $config = array('http_request_type' => 'POST',
                    'request_url' => YATA::URL_OAUTH_REQUEST_TOKEN,
                    'consumer_key' => '<YOUR CONSUMER KEY>',
                    'consumer_secret_key' => '<YOUR CONSUMER SECRET KEY>',
                    );

    $request = new OAuth($config);
    $request->setOAuthHeader('oauth_callback',urlencode('http://localhost:3005/the_dance/process_callback?service_provider_id=11'));

    $response = $request->send();

    $regexp = '/oauth_token=[A-Za-z0-9]+&oauth_token_secret=[A-Za-z0-9]+&oauth_callback_confirmed=true/';
    $this->assertRegExp($regexp, $response);
    
  }

  public function testCanSendStatusUpdate()
  {

    $config = array('http_request_type' => 'POST',
                    'request_url' => YATA::URL_STATUSES_UPDATE,
                    'consumer_key' => '<YOUR CONSUMER KEY>',
                    'consumer_secret_key' => '<YOUR CONSUMER SECRET KEY>'
                    'oauth_token_secret' => '<YOUR OAUTH TOKEN SECRET>',
                    );

    $request = new OAuth($config);
    $request->setOAuthHeader('oauth_token','<YOUR OAUTH TOKEN>')
      ->setOAuthHeader('oauth_callback',urlencode('http://localhost:3005/the_dance/process_callback?service_provider_id=11'));
    $request->addParameter('status',"I'm going to bed #YATA");

    $response = $request->send();
    
    $regexp = '/"text":"I\'m going to bed #YATA"/';
    $this->assertRegExp($regexp, $response);

  }

}

