<?php

namespace Twitter;

class Twitter
{

  public static function normaliseOption($option)
  {
    $parts = explode('_',$option);
    $parts = array_map('ucwords',$parts);
    $norm = implode('',$parts);

    return $norm;
  }

}
