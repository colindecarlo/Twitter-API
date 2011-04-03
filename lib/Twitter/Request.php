<?php

namespace Twitter;

class Request
{

  const URL_SEARCH = 'http://search.twitter.com/search.%format%';

  protected $_config = array('format' => 'json',
                             'request_type' => self::URL_SEARCH,
                             'http_request_type' => 'GET',);

  protected $_parameters = array();
  protected $_response = null;

  public function __construct(array $config = array())
  {
    $this->_config = array_merge_recursive($this->_config, $config);

    $this->_init();
    if (isset($config['parameters'])) {
      $this->setParameters($config['parameters']);
    }

  }

  protected function _init()
  {

    foreach ($this->_config as $option => $value) {
      $setter = 'set' . Twitter::normaliseOption($option);
      if (method_exists($this, $setter)) {
        $this->$setter($value);
      }
    }

  }

  public function getFormat()
  {
    return $this->_config['format'];
  }

  public function setFormat($format)
  {
    $this->_config['format'] = $format;
    
    return $this;
  }

  public function setHttpRequestType($type)
  {
    $this->_config['http_request_type'] = $type;

    return $this;
  }

  public function getHttpRequestType()
  {
    return $this->_config['http_request_type'];
  }

  public function setRequestType($type)
  {
    $this->_config['request_type'] = $type;

    return $this;
  }

  public function getRequestType()
  {
    return $this->_config['request_type'];
  }

  public function setParameters(array $params)
  {
    $this->_parameters = array();
    $this->addParameters($params);

    return $this;
  }

  public function addParameter($name, $value)
  {
    $this->_parameters[$name] = $value;

    return $this;
  }

  public function removeParameter($name)
  {
    if (isset($this->_parameters[$name])) {
      unset($this->_parameters[$name]);
    }

    return $this;
  }

  public function addParameters(array $params)
  {
    foreach ($params as $name => $value) {
      $this->addParameter($name, $value);
    }

    return $this;
  }

  public function send()
  {

    $url = strtr($this->_config['request_type'], array('%format%' => $this->_config['format']));

    $ch = curl_init($url);
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
          throw new Twitter_Exception('Unknown http_request_type: ' . $this->_config['http_request_type']);

      }
    }

    $response = curl_exec($ch);

    if ($response === false) {
      throw new Twitter_Exception(curl_error($ch));
    }

    return $response;

  }

}
