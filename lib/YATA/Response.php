<?php

namespace YATA;

class Response {

  private $_rawBody = null;
  private $_format = null;
  private $_response = null;

  public function __construct($rawBody = null, $format = 'json')
  {

    $this->_format = $format;

    if(isset($rawBody)) {
      $this->setRawBody($rawBody);
    }

  }

  public function setRawBody($raw)
  {
    $this->_rawBody = $raw;
    $this->_parseResponse();
  }

  public function getResponse()
  {
    return $this->_response;
  }

  private function _parseResponse()
  {
    $parseMethod = sprintf('_parseAs%s',ucwords($this->_format));
    $this->_response = $this->$parseMethod();
  }

  private function _parseAsJson()
  {
    return json_decode($this->_rawBody, true);
  }

}

