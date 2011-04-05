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

use YATA\YATA;

class YATATest extends \PHPUnit_Framework_TestCase
{

  /**
   * @dataProvider optionProvider 
   */
  public function testNormaliseOptionWorks($option, $expected)
  {

    $norm = YATA::normaliseOption($option);

    $this->assertEquals($expected, $norm);

  }

  public function optionProvider()
  {

    return array(
      array('option', 'Option'),
      array('option_with_underscore','OptionWithUnderscore'),
    );

  }

}
