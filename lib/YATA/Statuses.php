<?php

namespace YATA;

use YATA\AuthorisedOperation;

class Statuses extends AuthorisedOperation
{

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

}
