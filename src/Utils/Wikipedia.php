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

  public static function readPageForQuark($query)
  {
    $res = self::readPage($query);
    return self::constructData($res[0]);
  }

  public static $internal = false;
  public static function constructData($element)
  {
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
