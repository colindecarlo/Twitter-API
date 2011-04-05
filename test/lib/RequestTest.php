<?php

/*
 * This file is part of the YATA package.
 *
 * (c) Colin DeCarlo <colin@thedecarlos.ca>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
