<?php

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
