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

  static $xpath_main = '//div[contains(@class, "mw-parser-output")]';
  static $xpath_infobox = '//table[contains(@class,"infobox")]';

  public static function readPage($query, $infobox = false)
  {
    if (!is_string($query) || empty($query)) return false;
    $template = 'https://ja.wikipedia.org/wiki/%s';
    $path = sprintf($template, urlencode($query));

    if ($infobox) {
      $element = self::$xpath_infobox;
    } else {
      $element = self::$xpath_main;
    }
    $res = U::getXpathFromUrl($path, $element);
    if (!$res) return false;

    return $res[0];
  }

  public static function parseInfoBox($xml)
  {
    if (!is_object($xml)) return false;
    $element = @$xml->xpath(self::$xpath_infobox);
    if (!$element || !is_array($element) || !property_exists($element[0], 'tr')) return false;
    return $element[0]->tr;
  }

  /*********************************************************************************/
  /* quark                                                                         */
  /*********************************************************************************/
  public static $internal = false;
  public static function readPageForQuark($query)
  {
    $xml = self::readPage($query);
    if (!$xml) return false;

    $ret = self::constructData($xml);
    if (!$ret || !is_array($ret)) return false;

    // get google image
    if (!self::$internal) {
      $res =  GoogleSearch::getFirstImageFromImageSearch($query);
      if ($res) {
	$ret['image_path'] =  $res;
      }
    }

    $ret['name'] = $query;
    return $ret;
  }

  public static function constructData($xml)
  {
    // get description
    $description = ($res = self::retrieveDescription($xml)) ? $res : '';

    // get image_path
    $image_path = ($res = self::retrieveImagePath($xml)) ? $res : NULL;

    // get start array
    $start = self::retrieveStart($xml);
    $dateArr = U::normalizeDateArrayFormat($start);
    if ($dateArr) {
      $start          = $dateArr['date'];
      $start_accuracy = $dateArr['date_accuracy'];
    } else {
      $start          = NULL;
      $start_accuracy = '';
    }

    // get end array
    $end = self::retrieveEnd($xml);
    $dateArr = U::normalizeDateArrayFormat($end);
    if ($dateArr) {
      $end          = $dateArr['date'];
      $end_accuracy = $dateArr['date_accuracy'];
    } else {
      $end          = NULL;
      $end_accuracy = '';
    }

    // get url
    $url = ($res = self::retrieveUrl($xml)) ? $res : '';

    return [
	    'image_path'            => $image_path,
	    'description'           => $description,
	    'start'                 => $start,
	    'start_accuracy'        => $start_accuracy,
	    'end'                   => $end,
	    'end_accuracy'          => $end_accuracy,
	    'is_momentary'          => false,
	    'url'                   => $url,
	    'user_id'               => 1,
	    ];
  }


  public static function retrieveDescription($xml)
  {
    $txt = self::retrieveFirstP($xml);
    if (!$txt || !is_string($txt)) return false;
    return U::abbreviateStr($txt, 255);
  }
  public static function retrieveStart($xml)
  {
    if ($ret = self::retrieveStartItemFromInfobox($xml)) return $ret;
    return  self::retrieveStartItemFromFirstP($xml);
  }
  public static function retrieveEnd($xml)
  {
    if ($ret = self::retrieveEndItemFromInfobox($xml)) return $ret;
    return  self::retrieveEndItemFromFirstP($xml);
  }
  public static function retrieveStartItemFromFirstP($xml)
  {
    $txt = self::retrieveFirstP($xml);
    if (!$txt) return false;
    return U::getStartDateFromText($txt);
  }
  public static function retrieveEndItemFromFirstP($xml)
  {
    $txt = self::retrieveFirstP($xml);
    if (!$txt) return false;
    return U::getEndDateFromText($txt);
  }
  public static function retrieveFirstP($xml)
  {
    return self::getPlainText($xml->p);
  }
  public static function retrieveStartItemFromInfobox($xml)
  {
    $element = self::parseInfoBox($xml);
    if (!$element) return false;

    foreach($element as $val) {
      if (!property_exists($val, 'th')) continue;
      if (!property_exists($val, 'td')) continue;

      // TODO: This covers only when the element is a person. Add logic for some other types of elements
      if (!self::isBirthdayItem((string)$val->th)) continue;

      $txt = self::getPlainText($val->td);
      if (!$txt) return false;
      return U::normalizeDateFormat($txt);
    }
    return false;
  }
  public static function retrieveEndItemFromInfobox($xml)
  {
    $element = self::parseInfoBox($xml);
    if (!$element) return false;

    foreach($element as $val) {
      if (!property_exists($val, 'th')) continue;
      if (!property_exists($val, 'td')) continue;

      // TODO: This covers only when the element is a person. Add logic for some other types of elements
      if (!self::isDeathdayItem((string)$val->th)) continue;

      $txt = self::getPlainText($val->td);
      if (!$txt) return false;
      return U::normalizeDateFormat($txt);
    }
    return false;
  }




  public static function retrieveUrl($xml)
  {
    if ($ret = self::retrieveUrlFromInfobox($xml)) return $ret;
    return  self::retrieveUrlFromContent($xml);
  }
  public static function retrieveUrlFromInfobox($xml)
  {
    $element = self::parseInfoBox($xml);
    if (!$element) return false;

    foreach($element as $val) {
      if (!property_exists($val, 'th')) continue;
      if (!property_exists($val, 'td')) continue;

      if (!self::isUrlItem((string)$val->th)) continue;

      if (!property_exists($val->td, 'a') || !$val->td->a->attributes()) return false;
      return (string)$val->td->a->attributes()->href;
    }
    return false;
  }
  public static function retrieveUrlFromContent($xml)
  {
    // get the element next to 外部リンク header
    $target = false;
    $flg = false;
    foreach($xml as $val) {
      if ($flg) {
	$target = $val;
	break;
      } else {
	$txt = self::getPlainText($val);
	if (preg_match('/\A外部リンク/', $txt, $matches)) $flg = true;
      }
    }
    if (!$target) return false;

    if (!is_object($target)
	|| !property_exists($target, 'li')
	|| empty($target->li)
	|| !is_object($target->li[0])
	|| !property_exists($target->li[0], 'a')
	|| !$target->li[0]->a->attributes()
    ) return false;
    return (string)$target->li[0]->a->attributes()->href;
  }

  // sample:   https://upload.wikimedia.org/wikipedia/commons/4/49/SONY_VAIO_%E7%9F%B3%E7%94%B0%E7%B4%94%E4%B8%80_%E4%BD%90%E7%94%B0%E7%9C%9F%E7%94%B1%E7%BE%8E.jpg
  public static function retrieveImagePath($xml)
  {
    $src = self::readImageSrcFromInfoBox($xml);
    if (!$src) {
      $src = self::readImageSrcFromThumbinner($xml);
      if (!$src) return false;
    }

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

  public static function readImageSrcFromThumbinner($xml)
  {
    if (!is_object($xml)) return false;

    $xpath = '//div[contains(@class,"thumbinner")]';
    $element = @$xml->xpath($xpath);
    if (!is_array($element) || empty($element) || !$element[0] ||
	!is_object($element[0]) || !property_exists($element[0], 'a') || !property_exists($element[0]->a, 'img') ||
	!$element[0]->a->img->attributes()) return false;

    // prepare source
    return (string)$element[0]->a->img->attributes()->src;
  }

  public static function readImageSrcFromInfoBox($xml)
  {
    $element = self::parseInfoBox($xml);
    if (!$element) return false;

    // image is always on the second element in "infobox" class
    if (!$element[1] || !self::isImageItem($element[1])) return false;

    // prepare source
    return (string)$element[1]->td->a->img->attributes()->src;
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
    $xml = self::readPage($query);
    if (!$xml) return false;

    $element = self::parseInfoBox($xml);
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
  public static function isBirthdayItem($str)
  {
    return ((strcmp($str, '生年月日') === 0) ||
	    (strcmp($str, '出生') === 0) ||
	    (strcmp($str, '誕生') === 0) ||
	    (strcmp($str, '生誕') === 0)
	    );
  }
  public static function isDeathdayItem($str)
  {
    return ((strcmp($str, '没年月日') === 0) ||
	    (strcmp($str, '死没') === 0) ||
	    (strcmp($str, '崩御') === 0)
	    );
  }
  public static function isUrlItem($str)
  {
    return ((strcmp($str, '公式サイト') === 0) ||
	    (strcmp($str, '外部リンク') === 0)
	    );
  }


}
