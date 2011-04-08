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

class YATA
{
  const URL_SEARCH = 'http://search.twitter.com/search.%format%';
  const URL_OAUTH_REQUEST_TOKEN = 'https://api.twitter.com/oauth/request_token';
  const URL_OAUTH_AUTHORIZE = 'https://api.twitter.com/oauth/authorize';
  const URL_OAUTH_AUTHENTICATE = 'https://api.twitter.com/oauth/authenticate';
  const URL_OAUTH_ACCESS_TOKEN = 'https://api.twitter.com/oauth/access_token';
  const URL_STATUSES_UPDATE = 'http://api.twitter.com/statuses/update.%format%';
  const URL_STATUSES_MENTIONS = 'http://api.twitter.com/statuses/mentions.%format%';

  public static function normaliseOption($option)
  {
    $parts = explode('_',$option);
    $parts = array_map('ucwords',$parts);
    $norm = implode('',$parts);

    return $norm;
  }

}
