<?php

namespace YATA;

use YATA\YATA,
    YATA\Request\OAuth,
    YATA\Response;

abstract class AuthorisedOperation {

  protected $_request;
  protected $_response;

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

  protected function _makeRequest(array $params)
  {

    $this->_request->setParameters($params);
    $rawResponse = $this->_request->send();

    $this->_response->setRawBody($rawResponse);

    return $this->_response->getResponse();

  }

}

