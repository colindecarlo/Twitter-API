<?php

namespace YATA\Request;

use YATA\Request;

class OAuth extends Request
{

  private $_oAuthHeaders = array();
  private $_consumerSecretKey = null;
  private $_consumerKey = null;
  private $_oauthTokenSecret = null;

  protected function _init()
  {
    parent::_init();

    // set some static, reasonably default oauth headers
    $this->setOAuthHeaders(array('oauth_version' => '1.0',
                                 'oauth_signature_method' => 'HMAC-SHA1',
                                ), true);

  }

  public function setOauthTokenSecret($secret)
  {
    $this->_oauthTokenSecret = $secret;
  }

  public function getOauthTokenSecret()
  {
    return $this->_oauthTokenSecret;
  }

  public function setConsumerSecretKey($key)
  {
    $this->_consumerSecretKey = $key;
  }

  public function getConsumerSecretKey()
  {
    return $this->_consumerSecretKey;
  }

  public function setConsumerKey($key)
  {
    $this->_consumerKey = $key;
    $this->setOAuthHeader('oauth_consumer_key',$key,true);
  }

  public function getConsumerKey()
  {
    return $this->_consumerKey;
  }

  public function setOAuthHeaders(array $headers, $overwrite = false)
  {
    foreach ($headers as $header => $value) {
      $this->setOAuthHeader($header, $value, $overwrite);
    }
  }

  public function setOAuthHeader($header, $value, $overwrite = false)
  {

    // set the oAuth header
    // the oAuth spec says that the headers must be sorted by lexigraphical 
    // order *and* in the event of a tie, then the value is used as the tie 
    // breaker, this means that a header could appear *more than one time* 

    if (isset($this->_oAuthHeaders[$header]) && !$overwrite) {
      if (is_array($this->_oAuthHeaders[$header])) {
        $this->_oAuthHeaders[$header][] = $value;
      } else {
        $this->_oAuthHeaders[$header] = array($this->_oAuthHeaders[$header], $value);
      }
    } else {
      $this->_oAuthHeaders[$header] = $value;
    }

    return $this;

  }

  public function _generateSignatureBaseString()
  {

    $requestMethod = $this->getHttpRequestType();
    $baseUri = $this->getRequestUrl();

    $this->_sortOAuthHeaders();
    
    $params = array_merge($this->_oAuthHeaders, array_map('rawurlencode',$this->_parameters));
    ksort($params);

    $baseString = $requestMethod . '&' . rawurlencode($baseUri) . '&';
    
    $encodedParams = array();
    foreach ($params as $key => $value) {

      if (is_array($value)) {
        foreach ($value as $subValue) {
          $encodedParams[] = rawurlencode($key) . '%3D' . rawurlencode($subValue);
        }
      } else {
        $encodedParams[] = rawurlencode($key) . '%3D' . rawurlencode($value);
      }

    }

    $baseString .= implode('%26', $encodedParams);

    return $baseString;

  }

  public function _generateOAuthSignature()
  {
    $key = rawurlencode($this->_consumerSecretKey) . '&';
    if (isset($this->_oauthTokenSecret)) {
      $key .= rawurlencode($this->_oauthTokenSecret);
    }


    $hash = hash_hmac('sha1',$this->_generateSignatureBaseString(),$key, true);
    $signature = base64_encode($hash);

    return $signature;
  }

  public function _getAuthenticationHeader()
  {
    // create a nonce and timestamp the request
    $this->setOAuthHeader('oauth_timestamp', time(), true);
    $this->setOAuthHeader('oauth_nonce', $this->_generateNonce(), true);
    
    // generate the signature
    $signature = $this->_generateOAuthSignature();

    $gluedHeaders = array();
    foreach ($this->_oAuthHeaders as $header => $value) {
      $gluedHeaders[] = sprintf("%s=\"%s\"", $header, $value);
    }
    $gluedHeaders[] = sprintf("%s=\"%s\"", 'oauth_signature',rawurlencode($signature));

    $header = 'Authorization: OAuth ' . implode(', ', $gluedHeaders);

    return $header;

  }

  private function _generateNonce()
  {

    $chars  = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $chars .= 'abcdefghijklmnopqrstuvwxyz';
    $chars .= '0123456789';

    $nonce = '';
    for ($i = 0; $i < 44; $i++) {
      $nonce .= substr($chars, (rand() % (strlen($chars))), 1); 
    }

    return $nonce;

  }

  private function _sortOAuthHeaders()
  {

    // first iterate over the headers sorting the headers that have more than 
    // one value
    foreach ($this->_oAuthHeaders as $header => $value) {
      if (is_array($value)) {
        sort($value);
        $this->_oAuthHeaders[$header] = $value;
      }
    }

    // now ksort that bitch
    ksort($this->_oAuthHeaders);

  }

  public function send()
  {

    $url = strtr($this->_config['request_url'], array('%format%' => $this->_config['format']));

    $ch = curl_init($url);

    // add the oauth header
    curl_setopt($ch, CURLOPT_HTTPHEADER, array($this->_getAuthenticationHeader()));
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->_parameters));

    // since the default curl request is GET we only have to change it if its 
    // *not* GET
    if ($this->_config['http_request_type'] != 'GET') {

      switch ($this->_config['http_request_type']) {

        case 'POST':
          curl_setopt($ch, CURLOPT_POST, true);
          break;

        case 'PUT':
          curl_setopt($ch, CURLOPT_PUT, true);
          break;

        default:
          throw new Exception('Unknown http_request_type: ' . $this->_config['http_request_type']);

      }
    }

    $response = curl_exec($ch);

    if ($response === false) {
      throw new Exception(curl_error($ch));
    }

    return $response;

  }

}
