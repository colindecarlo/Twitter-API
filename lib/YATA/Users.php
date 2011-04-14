<?php

namespace YATA;

use YATA\AuthorisedOperation;

class Users extends AuthorisedOperation
{

  public function search($query, array $optParams = array())
  {

    $this->_request->setRequestUrl(YATA::URL_USERS_SEARCH);
    $this->_request->setHttpRequestType('GET');
    
    return $this->_makeRequest(array_merge(array('q' => $query), $optParams));

  }

  public function show($userId, $screenName, array $optParams = array())
  {

    $this->_request->setRequestUrl(YATA::URL_USERS_SHOW);
    $this->_request->setHttpRequestType('GET');
    
    return $this->_makeRequest(array_merge(array('user_id' => $userId, 'screen_name' => $screenName), $optParams));

  }

  public function showByUserId($userId, array $optParams = array())
  {

    $this->_request->setRequestUrl(YATA::URL_USERS_SHOW);
    $this->_request->setHttpRequestType('GET');
    
    return $this->_makeRequest(array_merge(array('user_id' => $userId), $optParams));

  }

  public function showByScreenName($screenName, array $optParams = array())
  {

    $this->_request->setRequestUrl(YATA::URL_USERS_SHOW);
    $this->_request->setHttpRequestType('GET');
    
    return $this->_makeRequest(array_merge(array('screen_name' => $screenName), $optParams));

  }

}
