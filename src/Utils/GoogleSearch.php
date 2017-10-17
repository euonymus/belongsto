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
class GoogleSearch
{
  public static $retrieveCacheConfig = 'default';
  public function __construct(array $token = array(), array $consumer = array())
  {
  }

/* {"cb":3,"cl":3,"cr":3,"ct":3,"id":"s_9xVgaILzPqEM:","isu":"fujitv.co.jp","itg":0,"ity":"jpg","oh":200,"ou":"http://www.fujitv.co.jp/tokudane/common/image/fblogo.jpg","ow":200,"pt":"とくダネ！ - フジテレビ","rid":"v8qUn0wwu5Dd9M","rmt":0,"rt":0,"ru":"http://www.fujitv.co.jp/tokudane/","s":"","sc":1,"st":"フジテレビ","th":200,"tu":"https://encrypted-tbn0.gstatic.com/images?q\u003dtbn:ANd9GcRxZzoWE_Imr0EJCsTDKtmdy4XU-dOC3TvV-Mu8xmtCzD5GxY4i","tw":200} */
  public static function getFirstImageFromImageSearch($query = NULL)
  {
    //$obj = self::getFirstOjbFromImageSearch($query);
    //if (!$obj) return false;
    //if (!property_exists($obj, 'ou')) return false;
    //return ($obj->ou && (strlen($obj->ou) <= 255)) ? $obj->ou : false;

    // This function is legacy.
    return self::getFirstOjbFromImageSearch($query);
  }
  public static function getFirstOjbFromImageSearch($query = NULL)
  {
    $xpath = self::getXpathFromImageSearch($query);
    if (!$xpath) return false;
    
    foreach($xpath as $val) {
      //return json_decode((string)$val);
      $image_path = self::getImageUrlFromImageSearchJson($val);
      if (preg_match('/\Ahttps\:\/\//', $image_path)) return $image_path;
    }
    return false;
  }

  public static function getImageUrlFromImageSearchJson($json)
  {
    $obj = json_decode((string)$json);
    if (!$obj) return false;
    if (!property_exists($obj, 'ou')) return false;
    return ($obj->ou && (strlen($obj->ou) <= 255)) ? $obj->ou : false;
  }

  public static function getXpathFromImageSearch($query = NULL)
  {
    if (empty($query)) return false;

    $template = 'https://www.google.co.jp/search?hl=ja&tbm=isch&biw=1912&bih=1045&q=%s';
    $path = sprintf($template, urlencode($query));
    $element = '//div[contains(@class,"rg_meta notranslate")]';

    ini_set('user_agent',
       'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36');
    U::$retrieveCacheConfig = self::$retrieveCacheConfig;
    return U::getXpathFromUrl($path, $element);
  }

}
