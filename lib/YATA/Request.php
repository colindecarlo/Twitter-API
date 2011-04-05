<?php

/*
 * This file is part of the YATA package.
 *
 * (c) Colin DeCarlo <colin@thedecarlos.ca>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace YATA;

use YATA\Exception;

class Request
{


  protected $_config = array('format' => 'json',
                             'request_url' => YATA::URL_SEARCH,
                             'http_request_type' => 'GET',);

  protected $_parameters = array();
  protected $_response = null;

  public function __construct(array $config = array())
  {
    $this->_config = array_merge($this->_config, $config);

    $this->_init();

  }

  protected function _init()
  {

    foreach ($this->_config as $option => $value) {
      $setter = 'set' . YATA::normaliseOption($option);
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

  public function setRequestUrl($url)
  {
    $this->_config['request_url'] = $url;

    return $this;
  }

  public function getRequestUrl()
  {
    $url = strtr($this->_config['request_url'], array('%format%' => $this->_config['format']));
    return $url;
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

    $url = strtr($this->_config['request_url'], array('%format%' => $this->_config['format']));

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
