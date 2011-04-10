<?php

namespace YATA;

use YATA\YATA,
    YATA\Request\OAuth,
    YATA\Response;

class Statuses {

  private $_request;
  private $_response;

  public function __construct(OAuth $request = null)
  {
    $this->_response = new Response();
    if (!isset($request)) {
      $request = new OAuth();
    }

    $this->setRequest($request);
  }

  public function getRequest()
  {
    return $this->_request;
  }

  public function setRequest(OAuth $request)
  {
    $this->_request = $request;
  }

  public function update($status, array $optParams = array())
  {
    $this->_request->setRequestUrl(YATA::URL_STATUSES_UPDATE);
    $this->_request->setHttpRequestType('POST');
    
    return $this->_makeRequest(array_merge(array('status' => $status), $optParams));

  }

  public function mentions(array $optParams = array())
  {
    $this->_request->setRequestUrl(YATA::URL_STATUSES_MENTIONS);
    $this->_request->setHttpRequestType('GET');

    return $this->_makeRequest($optParams);
  }

  private function _makeRequest(array $params)
  {

    $this->_request->setParameters($params);
    $rawResponse = $this->_request->send();

    $this->_response->setRawBody($rawResponse);

    return $this->_response->getResponse();

  }

}

