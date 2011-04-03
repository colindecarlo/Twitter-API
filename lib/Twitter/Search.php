<?php

namespace Twitter;

use Twitter\Request;
use Twitter\Exception;

class Search
{

  protected $_tRequest = null;
  protected $_results = null;

  public function __construct()
  {
    $this->_tRequest = new Request();
  }

  public function getRequest()
  {
    return $this->_tRequest;
  }

  public function search()
  {
    $this->_results = $this->_tRequest->send();

    // figure out how to parse the results
    if ($this->_tRequest->getFormat() == 'json') {
      $this->_parseAsJson();
    } else {
      $this->_parseAsAtom();
    }

    return $this->_results;

  }

  public function getResults()
  {
    return $this->_results;
  }

  protected function _parseAsJson()
  {
    $this->_results = json_decode($this->_results, true);
  }

  protected function _parseAsAtom()
  {
    throw new Exception('Just use json');
  }


}
