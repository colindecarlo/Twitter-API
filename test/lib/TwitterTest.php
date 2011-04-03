<?php

namespace Twitter\Test;

require __DIR__ . '/../bootstrap.php';

use Twitter\Twitter;

class TwitterTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @dataProvider optionProvider 
   */
  public function testNormaliseOptionWorks($option, $expected)
  {

    $norm = Twitter::normaliseOption($option);

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
