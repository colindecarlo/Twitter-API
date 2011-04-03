<?php

namespace Twitter\Test;

require __DIR__ . '/../bootstrap.php';

use Twitter\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{

  public function testRequestWorks()
  {

    $request = new Request();
    $request->addParameter('q','@colindecarlo');
    $result = $request->send();

    echo $result;
  }

}
