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
class GlobalDataSet
{
  static $relative_types_older = [
    '父', '母',
    '兄', '姉',
    '祖父', '祖母',
    '伯父', '叔父', '小父', '伯母', '叔母', '小母',
    '大叔父', '大伯父', '大叔母', '大伯母',
    '曽祖父', '曾祖父', '曽祖母', '曾祖母',
    '高祖父', '高祖母',
    '義父', '義母', '義兄', '義姉',
    '曾祖伯父', '曾祖叔父', '曾祖伯母', '曾祖叔母',
    '五世祖父',
  ];
  static $relative_types_younger = [
    '息子', '娘', '子供',
    '長男', '次男', '二男', '三男', '四男', '五男', '六男', '七男', '八男', '九男',
    '長女', '次女', '二女', '三女', '四女', '五女', '六女', '七女', '八女', '九女',
    '弟', '妹',
    '孫', 'ひ孫', '曽孫', '曾孫', '玄孫',
    '娘婿', '義息子', '義娘',
  ];

  public function __construct(array $token = array(), array $consumer = array())
  {
  }

  public static function isRelativeType($str)
  {
    if (self::isOlderRelativeType($str)) return true;
    if (self::isYoungerRelativeType($str)) return true;
    return false;
  }
  public static function isOlderRelativeType($str)
  {
    foreach(GlobalDataSet::$relative_types_older as $val) {
      //if (strcmp($val, $str) === 0) return true;
      if (preg_match('/'. $val . '/', $str)) return true;
    }
    return false;
  }
  public static function isYoungerRelativeType($str)
  {
    foreach(GlobalDataSet::$relative_types_younger as $val) {
      //if (strcmp($val, $str) === 0) return true;
      if (preg_match('/'. $val . '/', $str)) return true;
    }
    return false;
  }

}
