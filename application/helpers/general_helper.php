<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Image URL link - able to separate image url link to different server if needed. eg CDN
* Default will be base_url() or current domain
* @param String $url
* @return String
*/
if (!function_exists('image_url'))
{
  function image_url ($url = '')
  {
    $image_url = base_url();
    return $image_url.$url;
  }
}

/**
* Check is integer or number
* @param String $number
* @return Boolean
*/
if (!function_exists('check_empty_integer'))
{
  function check_empty_integer($number='')
  {
    if (empty($number) || !is_numeric($number))
    {
      return false;
    }
    return true;
  }
}

/**
* Date Difference
* @param String $datetime_1
* @param String $datetime_2
* @return Object
*/
if (!function_exists('date_difference'))
{
  function date_difference($datetime_1='',$datetime_2='')
  {
    $date1 = new DateTime($datetime_1);
    $date2 = new DateTime($datetime_2);
    $interval = $date1->diff($date2);
    return $interval;
  }
}

/**
 * Check User Login
 * @return Boolean
 */
if (!function_exists('check_user_login'))
{
  function check_user_login()
  {
    if (!empty($_SESSION['maskfinder_user']))
    {
      return true;
    }
    return false;

  }
}
?>
