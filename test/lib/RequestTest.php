<?php

namespace YATA\Test;

require __DIR__ . '/../bootstrap.php';

use YATA\Request;

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
