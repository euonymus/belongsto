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
class TalentDictionary
{
  public function __construct(array $token = array(), array $consumer = array())
  {
  }

  // $retrieveCacheConfig: For now, only 'defalut' is acceptable
  public static function readPagesOfAllGenerations($retrieveCacheConfig = false)
  {
    // TODO: 1 for test, 9 for production
    //$maxI = 9;
    $maxI = 1;
    $ret = [];
    for($i = 1; $i <= $maxI; $i++) {
      $generation = $i . '0';
      $tmp = self::readPages($generation, $retrieveCacheConfig);
      if (!$tmp) break;
      $ret = array_merge($ret, $tmp);
    }
    return $ret;
  }
  // Dummy function for self::readPagesOfAllGenerations('default')
  public static function dummyReadOfTalentDictionary()
  {
    $path = ROOT .DS. "tests" . DS . "DummyData" . DS . "talent_dictionary.html";
    $element = '//div[contains(@class,"main")]/div[contains(@class,"home_talent_list_wrapper")]/ul/li';
    $res = U::getXpathFromUrl($path, $element);

    // record loop
    $ret = [];
    foreach ($res as $val) {
      $rec = self::constructData($val->div->div);
      if (!$rec) continue;
      $ret[] = $rec;
    }
    return $ret;
  }

  // $retrieveCacheConfig: For now, only 'defalut' is acceptable
  public static function readPages($generation, $retrieveCacheConfig = false)
  {
    U::$retrieveCacheConfig = $retrieveCacheConfig;

    // TODO: 2 for test, 1000 for production
    //$maxPage = 1000;
    $maxPage = 2;
    $ret = [];
    for($page = 1; $page <= $maxPage; $page++) {
      $tmp = self::readPage($generation, $page);
      if (!$tmp) break;
      $ret = array_merge($ret, $tmp);
    }
    return $ret;
  }

  // $generation: 10 / 20 / 30 / 40 / 50 / 60 / 70 / 90
  // $page: int
  public static function readPage($generation, $page)
  {
    $template = 'https://talent-dictionary.com/s/age/p/%s?page=%u';
    $path = sprintf($template, $generation, $page);

    $element = '//div[contains(@class,"main")]/div[contains(@class,"home_talent_list_wrapper")]/ul/li';
    $res = U::getXpathFromUrl($path, $element);
    if (!$res) return false;

    // record loop
    $ret = [];
    foreach ($res as $val) {
      $rec = self::constructData($val->div->div);
      if (!$rec) continue;
      $ret[] = $rec;
    }
    return $ret;
  }

  public static $internal = false;
  public static function constructData($element)
  {
    // get main object
    $main = self::readProfDivMain($element);
    if (!$main) return false;

    // get image object
    $img = self::readProfDivImg($element);

    $ret = [];
    // get name
    $name = self::readName($main);
    if (!$name) return false;
    $ret = ['name' => $name];

    // get image
    if (self::$internal) {
      $image = self::readImg($img);
    } else {
      $image = GoogleSearch::getFirstImageFromImageSearch($name);
    }
    if ($image) $ret['image_path'] = $image;

    // get description
    $description = self::readDesc($main);
    if ($description) $ret['description'] = $description;

    // get start
    $startArr = self::readStartArr($main);
    $ret = array_merge($ret, $startArr);

    $ret['is_momentary'] = false;
    $ret['is_person'] = true;
    $ret['t_dictionary_sourced'] = 1;

    return $ret;
  }

  public static function readImg($element)
  {
    if (!is_object($element)) return false;
    if (!property_exists($element, 'a')) return false;
    if (!property_exists($element->a, 'div')) return false;

    $thumbnail = (string)$element->a->div->attributes()->{'data-original'};
    $option = ['pattern' => '/thumbnail_/', 'replacement' => ''];
    return U::regReplace($thumbnail, $option);
  }
  public static function readName($element)
  {
    return U::trimSpace((string)$element->a);
  }
  public static function readDesc($element)
  {
    foreach($element->div as $val) {
      if ((string)$val->attributes()->class != 'info') continue;
      return (string)$val->a;
    }
    return false;
  }
  public static function readStartArr($element)
  {
    $priority1 = false;
    $priority2 = false;
    foreach($element->div as $val) {
      if ((string)$val->attributes()->class == 'info') {
	$age_tmp = (string)$val->span;
	
	$pattern = '/[才歳]/';
	$replacement = '';
	$age = preg_replace($pattern, $replacement, $age_tmp);

	// to increase accuracy
	$month = (int)date('m', time());
	if ($month < 7) $age++;

	$priority2 = date('Y-01-01 00:00:00', strtotime($age.' years ago'));
	continue;
      }

      $txt = (string)$val;

      $pattern = '/\A(.+)(\d{4})\s?年\s?(\d{1,2})\s?月\s?(\d{1,2})\s?日\s?生まれ(.+)\z/';
      $replacement = '$2-$3-$4';
      $tmp = preg_replace($pattern, $replacement, $txt);
      if (strcmp($txt, $tmp) == 0) break;
      $priority1 = U::tableDate($tmp);
      if (!$priority1) break;
    }

    $ret = [];
    if ($priority1) {
      $ret = ['start' => $priority1, 'start_accuracy' => ''];
    } elseif ($priority2) {
      $ret = ['start' => $priority2, 'start_accuracy' => 'year'];
    } else return false;
    return $ret;
  }

  public static function readProfDivMain($element)
  {
      foreach($element as $val) {
	if ((string)$val->attributes()->class == 'right') return $val;
      }
      return false;
  }
  public static function readProfDivImg($element)
  {
      foreach($element as $val) {
	if ((string)$val->attributes()->class == 'left') return $val;
      }
      return false;
  }

}
