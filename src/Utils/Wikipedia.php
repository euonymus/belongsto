<?php
namespace App\Utils;

/**
 * Utility : 
 * 
 * @category Awesomeness
 * @package  Utility
 * @author   euonymus
 * @license  euonymus
 * @version  1.0.0
 */

use Cake\Cache\Cache;
use Cake\Cache\Engine\FileEngine;
use Cake\Log\Log;
class Wikipedia
{
  public function __construct(array $token = array(), array $consumer = array())
  {
  }

  public static function readPage($query)
  {
    if (!is_string($query) || empty($query)) return false;
    $template = 'https://ja.wikipedia.org/wiki/%s';
    $path = sprintf($template, urlencode($query));

    $element = '//table[contains(@class,"infobox")]';
    $res = U::getXpathFromUrl($path, $element);
    if (!$res) return false;

    return $res[0];
  }

  /*********************************************************************************/
  /* quark                                                                         */
  /*********************************************************************************/
  public static function readPageForQuark($query)
  {
    $res = self::readPage($query);
    $ret = self::constructData($res[0]);
    if (!$ret || !is_array($ret)) return false;
    $ret['name'] = $query;
    return $ret;
  }

  public static $internal = false;
  public static function constructData($element)
  {
    $image_path = ($res = self::retrieveImagePath($element->tr)) ? $res : NULL;
    foreach($element->tr as $val) {
      // get start array
      $startArr = self::retrieveStartArr($val);
      if ($startArr) {
	$start          = $startArr['start'];
	$start_accuracy = $startArr['start_accuracy'];
      } else {
	$start          = NULL;
	$start_accuracy = '';
      }

    }

    return [
	    'image_path'         => $image_path,
	    'description'        => '',
	    'start'              => $start,
	    'start_accuracy'     => $start_accuracy,
	    'end'                => NULL,
	    'end_accuracy'       => '',
	    'is_momentary'       => false,
	    'url'                => '',
	    'user_id'            => 1,
	    'last_modified_user' => 1,
	    ];
  }
  public static function retrieveStartArr($element)
  {
    debug($element);
  }

  // sample:   https://upload.wikimedia.org/wikipedia/commons/4/49/SONY_VAIO_%E7%9F%B3%E7%94%B0%E7%B4%94%E4%B8%80_%E4%BD%90%E7%94%B0%E7%9C%9F%E7%94%B1%E7%BE%8E.jpg
  public static function retrieveImagePath($element)
  {
    // image is always on the second element in "infobox" class
    if (!$element[1] || !self::isImageItem($element[1])) return false;

    // prepare source
    $src = (string)$element[1]->td->a->img->attributes()->src;

    // get file name
    $res = preg_match('/\/([^\/]*?)\.(jpg|JPG|jpeg|JPEG|gif|GIF|png|PNG)\//', $src, $matches);
    if (!$res) return false;
    $encoded_imagename = str_replace('/', '', $matches[0]);

    // get number part
    $res = preg_match('/\/\/upload\.wikimedia\.org\/wikipedia\/commons\/thumb\/(([^\/]*?)\/([^\/]*?))\//', $src, $matches);
    if (!$res) return false;
    $number_part = $matches[1];

    // generate image path
    $template = 'https://upload.wikimedia.org/wikipedia/commons/%s/%s';
    return sprintf($template, $number_part, $encoded_imagename);
  }

  public static function isImageItem($element)
  {
    if (!is_object($element) || !property_exists($element, 'td') || !property_exists($element->td, 'a') ||
	!$element->td->a->attributes()) return false;
    return ((string)$element->td->a->attributes()->class == 'image');
  }

  /*********************************************************************************/
  /* gluons                                                                        */
  /*********************************************************************************/
  public static function readPageForGluons($query)
  {
    $element = self::readPage($query);
    if (!$element) return false;

    // find relative information
    $relatives = [];
    foreach($element as $val) {
      if ($res = self::findRelatives($val)) {
	$relatives = array_merge($relatives, $res);
      }
    }
    return ['relatives' => $relatives];
  }

  public static function findRelatives($element)
  {
    if (!property_exists($element, 'th')) return false;
    if (!property_exists($element, 'td')) return false;
    if (!self::isRelativesItem((string)$element->th)) return false;

    $list = self::getPlainList($element->td);
    if (!$list) return false;

    $arr = [];
    foreach($list as $val) {
      $arr[] = self::parseRelative($val);
    }
    return $arr;
  }

  public static function parseRelative($str)
  {
    $main = preg_replace('/（(.*)）/', "", $str);
    $sub = preg_replace('/\A.*?（(.*)）.*?\z/', "$1", $str);
    if (strcmp($main, $sub) === 0) $sub = NULL;

    $relative_type = false;

    // try exploding
    $tmp = explode('・', $main);
    if (count($tmp) > 1) {
      foreach($tmp as $val) {
	if (GlobalDataSet::isRelativeType($val)) {
	  $relative_type = $val;
	} else {
	  $rest = $val;
	}
      }
    }

    if ($relative_type) {
      $main = $rest;
    } else {
      $relative_type = $sub;
    }
    if (!$relative_type) return false;

    return ['main' => $main, 'relative_type' => $relative_type];
  }

  public static function isRelativesItem($str)
  {
    return ((strcmp($str, '著名な家族') === 0) ||
	    (strcmp($str, '親族') === 0) ||
	    (strcmp($str, '父親') === 0) ||
	    (strcmp($str, '母親') === 0) ||
	    (strcmp($str, '子女') === 0) ||
	    (strcmp($str, '子供') === 0)
	    );
  }

  /*********************************************************************************/
  /* Tools                                                                         */
  /*********************************************************************************/
  public static function getPlainList($element)
  {
    $txt = self::getPlainText($element);
    $tmp = explode("\n", $txt);
    return array_values(array_filter($tmp, "strlen"));
  }
  public static function getPlainText($element)
  {
    return strip_tags(preg_replace('/\n?\<br\/\>\n?/',"\n",$element->asXml()));
  }
}
