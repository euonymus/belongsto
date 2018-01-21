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
class U
{
  public function __construct(array $token = array(), array $consumer = array())
  {
  }

  /*******************************************************/
  /* Regex Modules                                       */
  /*******************************************************/
  public static function regReplace($src, $option)
  {
    if (!is_string($src)) return false;
    if (!is_array($option)) return false;
    if (!array_key_exists('replacement', $option) || !array_key_exists('pattern', $option)) return false;
    if (!is_string($option['replacement']) || !is_string($option['pattern'])) return false;
    return preg_replace($option['pattern'], $option['replacement'], $src);
  }
  /**
   *  @param $src: original source text
   *  @param array $options: 
   */
  public static function multipleRegex($src, $options)
  {
    if (!is_array($options)) return false;
    $ret = $src;
    foreach($options as $option) {
      $ret = self::regReplace($ret, $option);
      if ($ret === false) return false; // MEMO: 空文字の場合もあるので。
    }
    return $ret;
  }
  public static function buildRegexOption($replacement, $pattern, $s = false, $m = false, $i = false, $u = true)
  {
    if (!is_string($replacement)) return false;
    $regex = self::buildRegex($pattern, $s, $m, $i, $u);
    if (!$regex) return false;
    $ret = array('replacement' => $replacement, 'pattern' => $regex);
    return $ret;
  }
  // MEMO: PHP doesn't have g modifier, instead use preg_match_all.
  // s	ワイルドカードのドット( . )が改行にもマッチするようにする
  // m	文字列を複数行として扱う
  // i	英字の大文字、小文字を区別しない
  // g	繰り返してマッチ
  // o	PATTERNの評価を 1回だけにする
  // x	拡張正規表現を使用する
  //public static function buildRegex($pattern, $g = false, $s = false, $m = false, $i = false)
  public static function buildRegex($pattern, $s = false, $m = false, $i = false, $u = true)
  {
    if (!is_string($pattern)) return false;
    $options = '';
    //if ($g) $options .= 'g';
    if ($s) $options .= 's';
    if ($m) $options .= 'm';
    if ($i) $options .= 'i';
    if ($u) $options .= 'u';
    return $pattern . $options;
  }

  public static function regExUrl()
  {
    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME
    $regex .= "([a-zA-Z0-9+!*(),;?&=\$_.-]+(\:[a-zA-Z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass
    $regex .= "([a-zA-Z0-9-.]*)\.([a-zA-Z]{2,3})"; // Host or IP
    $regex .= "(\:[0-9]{2,5})?"; // Port
    //$regex .= "(\/([a-zA-Z0-9+\$\_-]\.?)+)*\/?"; // Path
    //$regex .= "(\/([a-zA-Z0-9+\$\_\-\:\/]\.?)+)*\/?"; // Path
    $regex .= "(\/([a-zA-Z0-9+\$\_\-\:\/\%\,]\.?)+)*\/?"; // Path
    //$regex .= "(\?[a-zA-Z+&\$_.-][a-zA-Z0-9;:@&%=+\/\$_.-]*)?"; // GET Query
    $regex .= "(\?[a-zA-Z0-9+&\$_.-][a-zA-Z0-9;:@&%=+\/\$_.-]*)?"; // GET Query. gekisakaのURLが変なのでしょうがなく 0-9を追加
    $regex .= "(#[a-zA-Z_.-][a-zA-Z0-9+\$_.-]*)?"; // Anchor
    return $regex;
  }

  /*******************************************************/
  /* XML Modules                                         */
  /*******************************************************/
  const FEED_TYPE_RSS   = 'rss';
  const FEED_TYPE_ATOM  = 'atom';
  const FEED_TYPE_RDF   = 'rdf';

  const XMLNS_PREF_RELATE     = 'relate';
  const XMLNS_PREF_DC         = 'dc';
  const XMLNS_PREF_GEO        = 'geo'; 
  const XMLNS_PREF_CONTENT    = 'content';
  const XMLNS_PREF_MEDIA      = 'media';
  const XMLNS_PREF_YT         = 'yt';
  const XMLNS_PREF_ATOM       = 'atom';
  const XMLNS_PREF_FEEDBURNER = 'feedburner';

  public static function getFeedType($xml) {
    if ($ret = self::getFeedTypeByXml($xml)) return $ret;
    return self::getFeedTypeByItem($xml);
  }
  public static function getFeedTypeByXml($xml) {
    if (isset($xml->item)) return self::FEED_TYPE_RDF;
    elseif (isset($xml->channel)) return self::FEED_TYPE_RSS;
    elseif (isset($xml->entry)) return self::FEED_TYPE_ATOM;
    return false;
  }
  public static function getFeedTypeByItem($item) {
    if (isset($item->pubDate)) return self::FEED_TYPE_RSS;
    if (isset($item->updated)) return self::FEED_TYPE_ATOM;
    return self::FEED_TYPE_RDF;
  }

  // $nameSpaceにはxmlns:content='url'のurl部分を渡す。
  public static function getChildren($item, $nameSpace) {
    $data = $item->children($nameSpace);
    return $data ? $data : $item->children($nameSpace . '/');
  }
  // MEMO: 同じrelate:linkに対して異なるURLでの宣言が存在したためgetChildren()ではなくgetChildrenOnPrefix()を使う事にした。
  // $nameSpaceにはcontent:encodedのcontent文字列を渡す
  public static function getChildrenOnPrefix($item, $nameSpace) {
    return $item->children($nameSpace, true);
  }

  public static function getXmlItem($xml, $item)
  {
    $layer = explode('.', $item);
    if (empty($layer)) return false;
    
    $srcObj = self::recursiveCall($xml, $layer);
    if (!$srcObj) return false;
    return $srcObj;
  }
  public static function recursiveCall($node, $funcs)
  {
    if (!is_array($funcs)) return false;
    $current = array_shift($funcs);
    if (!is_string($current)) return false;
    if ($current == 'attributes()') {
      $current = 'attributes';
      $next = $node->{$current}();
    } else {
      if (!property_exists($node, $current)) return false;
      $next = $node->{$current};
    }
    if (empty($funcs)) return $next;

    return self::recursiveCall($next, $funcs);
  }

  // 壊れたXMLを提供する外部サイトのスクレイプのためXMLテキストをサニタイズ。
  // 例： e-talentbank（総合） http://e-talentbank.co.jp/feeds/entertainment_feed/
  public static function sanitizeXml($text)
  {
    // XMLの先頭に改行が含まれる場合があるので
    $pattern = '/\A[\r\n]*/';
    $replacement = '';
    $options = self::buildRegexOption($replacement, $pattern);
    return self::regReplace($text, $options);
  }

  // 参照: http://qiita.com/kobake@github/items/3c5d09f9584a8786339d
  // 文字化け防止のため htmlのcharsetを正しく設定する
  public static function sanitizeHtmlCharset($text)
  {
    if (!is_string($text) || empty($text)) return false;
    // 既に '<meta http-equiv' partがあればオリジナルテキストを返す。
    $patternBase = '\<meta[^\>]*?http\-equiv\=\"[Cc]ontent\-[Tt]ype\"[^\>]*?[Cc]harset';
    if (self::matchesRegex($text, $patternBase)) return $text;

    // tv-asahi などがShift_JISを使っている。
    // '<meta charset="Shift_JIS"' の場合 強制的にutf-8にする。regReplace()でu指定をしているため。
    $patternBase = '\<meta[^\>]*?[cC]harset\=\"([sS]hift_(jis|JIS|Jis))\".*?\>';
    if (self::matchesRegex($text, $patternBase)) {
      // 文字コードを強制的にutf-8に返還
      $text = mb_convert_encoding($text, 'utf-8', 'SJIS'); // 'SJIS'を明示しないとうまくいかない。
      // 文中のshift_jis文字列をutf-8に返還
      $pattern = '/[sS]hift_(jis|JIS|Jis)/';
      $replacement = 'utf-8';
      $options = self::buildRegexOption($replacement, $pattern);
      $text = self::regReplace($text, $options);
    }

    // MEMO: nikkansports等で変な文字コードが混じるケースがあり、その場合、self::regReplace で壊れてfalseになるためconvertしておく
    $text = mb_convert_encoding($text, 'utf-8'); // 何が入っているか分からないので返還前は明示しない。

    // '<meta charset'の有無確認
    $patternBase = '\<meta[^\>]*?[cC]harset\=\"([^\"]*)\".*?\>';
    if (self::matchesRegex($text, $patternBase)) {
      $pattern = '/' . $patternBase . '/';
      $replacement = '$0<meta http-equiv="Content-Type" content="text/html; charset=$1" />';
      $options = self::buildRegexOption($replacement, $pattern);
      return self::regReplace($text, $options);
    }
    // それすら無い場合は単純に以下を追加
    $pattern = '/\<\/title\>/';
    $replacement = '</title><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
    $options = self::buildRegexOption($replacement, $pattern);
    return self::regReplace($text, $options);
  }

  // htmlテキストをSimpleXMLElementにして返却
  public static function simplexml_from_html($html)
  {
    // 文字化け防止
    $html = self::sanitizeHtmlCharset($html);

    $dom = new \DOMDocument(); // MEMO: \を付ける事でnamespacingの問題を解決できるみたい。
    // MEMO: if ($dom instanceof DOMDocument) がなぜか効かない。
    $ret = @$dom->loadHTML($html);
    if (!($dom instanceof \DOMDocument)) return false;
    if (!$ret) return false;

    $simplexml = @simplexml_import_dom($dom);
    if (!($simplexml instanceof \SimpleXMLElement)) return false;
    if (!$simplexml) return false;
    return $simplexml;
  }

  // samples
  //debug((string)$xml->single);
  //debug((string)$xml->recursive->recursiveinside);
  //debug((string)$xml->link->attributes()->href);
  //debug((string)$xml->related[0]->title);
  //debug((string)$xml->relatedItem[0]->title);
  //debug((string)self::getChildrenOnPrefix($xml, 'nhknews')->new);
  //debug((string)self::getChildrenOnPrefix($xml, 'feedburner')->origLink);
  //debug((string)self::getChildrenOnPrefix($xml, 'relate')->link[0]->attributes()->title);
  //debug((string)self::getChildrenOnPrefix($xml, 'dc')->rellink[0]->attributes()->title);
  public static function getXmlItem2($xml, $item)
  {
    if (!is_string($item) || empty($item)) return false;
    // Check if using namespace
    $namespaceArr = explode(':', $item);
    if (count($namespaceArr) > 1) {
      // deeper call
      $targetObj = self::getChildrenOnPrefix($xml, $namespaceArr[0]);
      $targetElm = $namespaceArr[1];
    } else {
      $targetObj = $xml;
      $targetElm = $item;
    }
    // Check if recursive elements
    $deeperElm = false;
    $recursiveArr = explode('.', $targetElm);
    if (count($recursiveArr) > 1) {
      // deeper call
      $targetElm = $recursiveArr[0];
      array_shift($recursiveArr); // 配列の最初の要素を削除
      $deeperElm = implode('.', $recursiveArr);
    }

    // MEMO: Parsing attribute must be before the parsing of condition
    // Check if attribute.
    $targetAttr = false;
    $attributeArr = explode('@', $targetElm);
    if (count($attributeArr) > 1) {
      if ($deeperElm) return false; // attribute call should be the last. shouldn't have $deeperElm
      $targetElm = $attributeArr[0];
      $targetAttr = $attributeArr[1];
    }

    // Check if it has a condition
    $conditionAttr = false;
    $conditionArr = explode('/', $targetElm);
    if (count($conditionArr) > 1) {
      $targetElm = $conditionArr[0];

      // get condition
      $attributeCnd = explode('=', $conditionArr[1]);
      if (count($attributeCnd) <= 1) return false; // 構造的に = が入る必要がある。無い場合はエラー。

      $conditionAttr = $attributeCnd[0];
      $conditionVal = $attributeCnd[1];
    }      

    // Finally get the item or items
    if (!is_object($targetObj) || !property_exists($targetObj, $targetElm)) return false;
    $elm = $targetObj->{$targetElm};
    if (is_string($elm)) $elm = [$elm]; // source_type = 5(html)の場合などsimplexmlobjectではなく文字列になる場合がある。

    // 複数アイテム存在する場合がある。
    $arr = [];
    foreach($elm as $val) {
      if ($conditionAttr) {
	$matchVal = (string)$val->attributes()->{$conditionAttr};
	if ($matchVal != $conditionVal) continue; // if attribute condition doesn't match skip it.
      }

      if ($targetAttr) {
	$single = (string)$val->attributes()->{$targetAttr};
      } elseif ($deeperElm) {
	$single = self::getXmlItem2($val, $deeperElm);
      } else {
	$single = (string)$val;
      }
      $arr[] = $single;
    }
    if (count($arr) == 0) {
      $ret = false;
    } elseif (count($arr) == 1) {
      $ret = $arr[0];
    } else {
      $ret = $arr;
    }
    return $ret;
  }

  public static function avoidSelfclosing($html)
  {
    $pattern = '/(\<((?!(area|base|br|col|command|embed|hr|img|input|keygen|link|meta|param|source|track|wbr))\w*?) [^>]*?)\/\>/';
    $replacement = '$1></$2>';
    $option = self::buildRegexOption($replacement, $pattern, false, false, false);
    return self::regReplace($html, $option);
  }

  /*******************************************************/
  /* Filter modules                                      */
  /*******************************************************/
  const FLAG_FORMER_HALF = 1;
  const FLAG_LATTER_HALF = 2;

  const FILTER_TYPE_CONTAIN     = 0;
  const FILTER_TYPE_NOT_CONTAIN = 1;
  const FILTER_TYPE_MATCH_REGEX = 2;
  const FILTER_TYPE_GREATER     = 3;
  const FILTER_TYPE_IS          = 4;
  const FILTER_TYPE_LESS        = 5;
  const FILTER_TYPE_AFTER       = 6;
  const FILTER_TYPE_BEFORE      = 7;

  /**
   * @param $src: input string
   * @param $type: 0: Contains, 1: Does not contain, 2: Matches regex,
   *               3: is greater than, 4: is, 5: is less than,
   *               6: is after, 7: is before
   * @param $condition: 
   */
  public static function filterMatch($src, $type, $condition)
  {
    if (!is_numeric($type)) return false;
    switch ($type) {
    case self::FILTER_TYPE_CONTAIN:
      $res = self::doesContain($src, $condition);
      break;
    case self::FILTER_TYPE_NOT_CONTAIN:
      $res = !self::doesContain($src, $condition);
      break;
    case self::FILTER_TYPE_MATCH_REGEX:
      $res = self::matchesRegex($src, $condition);
      break;
    case self::FILTER_TYPE_GREATER:
      $res = self::isGreater($src, $condition);
      break;
    case self::FILTER_TYPE_IS:
      $res = self::isSame($src, $condition);
      break;
    case self::FILTER_TYPE_LESS:
      $res = self::isLess($src, $condition);
      break;
    case self::FILTER_TYPE_AFTER:
      $res = self::isAfter($src, $condition);
      break;
    case self::FILTER_TYPE_BEFORE:
      $res = self::isBefore($src, $condition);
      break;
    default:
      $res = false;
      break;
    }
    return $res;
  }

  /*******************************************************/
  /* Judge                                               */
  /*******************************************************/
  public static function isUrl($str)
  {
    if (!is_string($str)) return false;
    $regex = self::regExUrl();
    return self::matchesRegex($str, "\A$regex\z");
  }
  public static function isImagefile($str)
  {
    // MEMO: gifを入れるか悩む所
    $regex = '\.(jpg|jpeg|jpe|jfif|bmp|png|gif)$';
    return self::matchesRegex($str, $regex);
  }

  public static function doesContain($src, $needle) {
    return (stripos($src, $needle) !== false);
  }
  public static function matchesRegex($src, $regBase) {
    if (!is_string($src) || empty($src)) return false;
    if (!is_string($regBase) || empty($regBase)) return false;
    $reg = '/' . $regBase . '/';
    return !!preg_match($reg, $src, $matches);
  }

  public static function isSame($src, $condition) {
    return ($src == $condition);
  }
  public static function isGreater($src, $condition) {
    return (self::compareNumbers($src, $condition) === self::FLAG_FORMER_HALF);
  }
  public static function isLess($src, $condition) {
    return (self::compareNumbers($src, $condition) === self::FLAG_LATTER_HALF);
  }
  public static function compareNumbers($num1, $num2) {
    if (!is_numeric($num1) || !is_numeric($num2)) return false;
    return ($num1 == $num2) ? 'same' : (($num1 > $num2) ? self::FLAG_FORMER_HALF : self::FLAG_LATTER_HALF);
  }

  public static function isAfter($src, $condition) {
    return (self::compareDates($src, $condition) === self::FLAG_FORMER_HALF);
  }
  public static function isBefore($src, $condition) {
    return (self::compareDates($src, $condition) === self::FLAG_LATTER_HALF);
  }
  // returns newer side. if $num1 is newer than $num2, return $num1.
  public static function compareDates($date1, $date2) {
    $time1 = strtotime($date1);
    $time2 = strtotime($date2);
    if (($time1 == false) || ($time2 == false)) return false;
    return ($time1 == $time2) ? 'same' : (($time1 > $time2) ? self::FLAG_FORMER_HALF : self::FLAG_LATTER_HALF);
  }

  public static function sameStr($str1, $str2)
  {
    $str1 = self::trimSpace($str1);
    $str2 = self::trimSpace($str2);
    $res = strcmp($str1, $str2);
    return ($res === 0);
  }

  /*******************************************************/
  /* Date Times                                          */
  /*******************************************************/
  public static function feedDate($str)
  {
    $time = strtotime($str);
    if (!$time) return false;
    return self::feedDateFromTime($time);
  }
  public static function tableDate($str)
  {
    $time = strtotime($str);
    if (!$time) return false;
    return self::tableDateFromTime($time);
  }
  public static function feedDateFromTime($time)
  {
    if (!is_numeric($time)) return false;
    return date('D, d M Y H:i:s O', $time);
  }
  public static function tableDateFromTime($time)
  {
    if (!is_numeric($time)) return false;
    return date('Y-m-d H:i:s', $time);
  }



  public static function getStartDateFromText($txt)
  {
    $period = self::salvagePeriodFromText($txt);
    if (!$period) return false;
    $roughDateTxt = self::salvageStartFromPeriodText($period);
    if (!$roughDateTxt) return false;
    return self::normalizeDateFormat($roughDateTxt);
  }
  public static function getEndDateFromText($txt)
  {
    $period = self::salvagePeriodFromText($txt);
    if (!$period) return false;
    $roughDateTxt = self::salvageEndFromPeriodText($period);
    if (!$roughDateTxt) return false;
    return self::normalizeDateFormat($roughDateTxt);
  }

  // 和暦と区別つかないため、３桁以上の年にしか対応できない
  static $pattern_date = '(（)?\d{3,4} ?年(）)?( ?\d{1,2} ?月( ?\d{1,2} ?日)?)?';
  public static function salvageDateFromText($txt)
  {
    $pattern = '/' . self::$pattern_date . '/';
    $res = preg_match($pattern, $txt, $matches);
    if (!$res) return false;
    return $matches[0];
  }

  public static function salvagePeriodFromText($txt)
  {
    // \D{6} はUTF-8漢字二文字（昭和・平成など）に対応
    $pattern = '/' . self::$pattern_date . ' ?[\-\~] ?(\D{6}\d{1,2} ?年 ?)?(' . self::$pattern_date . ')?/';
    $res = preg_match($pattern, $txt, $matches);
    if (!$res) return false;
    return $matches[0];
  }
  public static function salvageStartFromPeriodText($roughPeriodTxt)
  {
    $pattern = '/\A' . self::$pattern_date . '/';
    $res = preg_match($pattern, $roughPeriodTxt, $matches);
    if (!$res) return false;
    return $matches[0];
  }  
  public static function salvageEndFromPeriodText($roughPeriodTxt)
  {
    $pattern = '/' . self::$pattern_date . '\z/';
    $res = preg_match($pattern, $roughPeriodTxt, $matches);
    if (!$res) return false;
    return $matches[0];
  }  

  public static function normalizeDateFormat($roughDateTxt)
  {
    $pattern = '/(\d{3,4} ?)年/';
    $res = preg_match($pattern, $roughDateTxt, $matches);
    if (!$res) return false;
    $ret = $matches[1];

    $pattern = '/(\d{1,2}) ?月/';
    $res = preg_match($pattern, $roughDateTxt, $matches);
    if ($res) {
      $month = $matches[1];
      $ret = sprintf($ret . '-%02d', $month);

      $pattern = '/(\d{1,2}) ?日/';
      $res = preg_match($pattern, $roughDateTxt, $matches);
      if ($res) {
	$day = $matches[1];
	$ret = sprintf($ret . '-%02d', $day);
      }
    }
    return $ret;
  }
  // $dateTxt: 'y-m-d'
  public static function normalizeDateArrayFormat($dateTxt)
  {
    if (!is_string($dateTxt)) return false;

    $arr = explode('-', $dateTxt);
    if (count($arr) == 1) {
      if (!is_numeric($arr[0])) return false;
      $date = $arr[0] . '-01-01 00:00:00';
      $accuracy = 'year';
    } elseif (count($arr) == 2) {
      if (!is_numeric($arr[0]) || !is_numeric($arr[1])) return false;
      $date = $arr[0] . '-' .sprintf('%02d', $arr[1]) .'-01 00:00:00';
      $accuracy = 'month';
    } elseif (count($arr) == 3) {
      if (!is_numeric($arr[0]) || !is_numeric($arr[1]) || !is_numeric($arr[2])) return false;
      $date = $arr[0] . '-' .sprintf('%02d', $arr[1]) . '-' . sprintf('%02d', $arr[2]) .' 00:00:00';
      $accuracy = NULL;
    } else {
      return false;
    }
    return ['date' => $date, 'date_accuracy' => $accuracy];
  }

  /*******************************************************/
  /* Sanitize Strings                                    */
  /*******************************************************/
  public static function trimSpace($str)
  {
    if (!is_string($str)) return '';
    // MEMO: pregに渡せる文字列には限界があり、下記パターンの正規表現にたいしては、14155が限界値。
    // 　　　これより長い値を渡すとセグメンテーションフォルトとなってしまう。
    if (strlen($str) > 14155) return $str;
    // MEMO: (?:.|\n)は改行を含む全ての文字列。因に、\rは.に含まれる。
    //    return preg_replace('/^[ 　\r\n]*(.*?)[ 　\r\n]*$/u', '$1', $str);
    return preg_replace('/^[ 　\r\n]*((?:.|\n)*?)[ 　\r\n]*$/u', '$1', $str);
  }
  // remove all the spaces.
  // this will remove all the spaces, even in between the strings.
  // TODO: 全角スペースの有無をコンフィグできるようにする。
  public static function removeAllSpaces($str, $includeIdeographicSpace = true)
  {
    $tmp = preg_replace('/ /', '', $str);
    return preg_replace('/　/', '', $tmp);
  }
  public static function abbreviateStr($str, $length)
  {
    $str = self::trimSpace($str);
    $count = mb_strlen($str, "UTF-8" );
    if( $count <= $length ) return $str;
    return mb_substr($str, 0, $length, "UTF-8" ) . '…';
  }
  public static function shortenDots($str)
  {
    $replacement = '…';
    $pattern = '/[\・]{6,}/';  // どうも半角の文字数でカウントされてるっぽいので2ではなく6(3bite x 2)。（文字化け回避）
    $option = self::buildRegexOption($replacement, $pattern, false, false, false, false);
    return self::regReplace($str, $option);
  }
  public static function stripParenthesisBold($str)
  {
    $str = self::trimSpace($str);
    $replacement = '$1：';
    $pattern = '/^【(.+?)】/';
    $option = self::buildRegexOption($replacement, $pattern, false, false, false);
    return self::regReplace($str, $option);
  }
  public static function removeWWWW($str)
  {
    $replacement = '$1';
    $pattern = '/w{2,}([^w^\.^\s])/';
    $option1 = self::buildRegexOption($replacement, $pattern, false, false, false);

    $replacement = '';
    $pattern = '/w+$/';
    $option2 = self::buildRegexOption($replacement, $pattern, false, false, false);
    $option = array($option1, $option2);
    return self::multipleRegex($str, $option);
  }
  public static function omitUrlInText($str)
  {
    if (!is_string($str)) return false;
    $regex = self::regExUrl();
    $option = self::buildRegexOption('', '/' . $regex . '/');
    $replaced = self::regReplace($str, $option);
    if ($replaced === false) return false;
    return self::trimSpace($replaced);
  }

  /*******************************************************/
  /* Retrieve data                                       */
  /*******************************************************/
  // Get Json data
  public static function retrieveJsonFromUrl($path, $withAgent = false)
  {
    $file = self::retrieveFileFromUrl($path, $withAgent);
    if (!$file) return false;

    $res = json_decode($file);
    if (!$res) return false;
    return $res;
  }
  // Get Json data as an array
  public static function retrieveJsonArrayFromUrl($path, $withAgent = false)
  {
    $file = self::retrieveFileFromUrl($path, $withAgent);
    if (!$file) return false;

    $res = json_decode($file, true);
    if (!$res) return false;
    return $res;
  }
  // Get RSS items
  public static function retrieveFeedItemsFromUrl($path, $withAgent = false)
  {
    $res = self::retrieveFeedFromUrl($path, $withAgent);
    if (!$res || !property_exists($res, 'channel') || !property_exists($res->channel, 'item')) return false;
    return $res->channel->item;
  }
  // Get RDF items
  public static function retrieveRdfItemsFromUrl($path, $withAgent = false)
  {
    $res = self::retrieveFeedFromUrl($path, $withAgent);
    if (!$res || !property_exists($res, 'item')) return false;
    return $res->item;
  }
  // Get Atom items
  public static function retrieveAtomItemsFromUrl($path, $withAgent = false)
  {
    $res = self::retrieveFeedFromUrl($path, $withAgent);
    if (!$res || !property_exists($res, 'entry')) return false;
    return $res->entry;
  }
  // You can choose how to retrieve simplexml from either way of simplexml_load_file or file_get_contents.
  static $retrieveXmlViaText = false; // simplexml_load_file is prefered.
  public static function retrieveFeedFromUrl($path, $withAgent = false)
  {
    if (self::$retrieveXmlViaText) {
      $ret = self::retrieveXmlViaTextFromUrl($path, $withAgent);
    } else {
      $ret = self::retrieveXmlFromUrl($path, $withAgent);
    }
    return $ret;
  }
  // Get Xpath data from html
  public static function getXpathFromUrl($url, $xpath, $asString = false, $withAgent = false)
  {
    $xml = self::simplexml_from_html_path($url, $withAgent);
    if (!($xml instanceof \SimpleXMLElement)) return false;
    $node = @$xml->xpath($xpath);
    if (!$node) return false;
    if ($asString) {
      $ret = array();
      foreach ($node as $item) {
	$ret[] = (string)$item;
      }
    } else {
      $ret = $node;
    }
    return $ret;
  }

  /*******************************************************/
  /* Retrieve data primitive                             */
  /*******************************************************/
  const USER_AGENT = 'gluons crawler';
  // Get text data
  public static function retrieveFileFromUrl($path, $withAgent = false)
  {
    if ($withAgent) {
      ini_set('user_agent', self::USER_AGENT);
    }
    return self::cachedRetrieve($path, 'file_get_contents');
  }

  // Get XML data
  public static function retrieveXmlFromUrl($path, $withAgent = false)
  {
    if ($withAgent) {
      ini_set('user_agent', self::USER_AGENT);
    }
    //ini_set("max_execution_time", 0);
    //ini_set("memory_limit", "10000M");
    //return @simplexml_load_file($path);
    return self::cachedRetrieveForXml($path, 'simplexml_load_file');
  }
  // Get XML data of html
  public static function simplexml_from_html_path($path, $withAgent = false)
  {
    $html = self::retrieveFileFromUrl($path, $withAgent);
    if (empty($html)) return false;
    return self::simplexml_from_html($html);
  }
  // Get broken XML data
  public static function retrieveXmlViaTextFromUrl($path, $withAgent = false)
  {
    $text = self::retrieveFileFromUrl($path, $withAgent);
    if (!$text) return false;
    $clean = self::sanitizeXml($text);
    return @simplexml_load_string($clean);
  }

  static $retrieveCacheConfig = false;
  static $logForCachedCall = false;
  public static function cachedRetrieve($path, $func)
  {
    $useCache = false;
    if (is_string(self::$retrieveCacheConfig)) {
      // $pathから作成されるkeyの長さチェック
      $FileEngine = new FileEngine;
      $key = 'cake_' . self::$retrieveCacheConfig . '_' . $FileEngine->key($path);
      if (strlen($key) <= 255) $useCache = true;
    }
    if ($useCache) {
      $type = 'USING CACHE:';
      if (($data = Cache::read($path, self::$retrieveCacheConfig)) === false) {
	$type .= 'actual call:';
	$data = @$func($path);
	Cache::write($path, $data, self::$retrieveCacheConfig);
      }
    } else {
      $type = 'WITHOUT CACHE:';
      $data = @$func($path);
    }
    if (self::$logForCachedCall) Log::info($type . $path, 'retrieval');

    return $data;
  }
  // MEMO: SimpleXMLElementがCache::write()できないため cachedRetrieve()と分けて関数作成
  public static function cachedRetrieveForXml($path, $func)
  {
    if (self::$retrieveCacheConfig) {
      $asText = Cache::read($path, self::$retrieveCacheConfig);
      if ($asText !== false) {
	$data = @simplexml_load_string($asText);
      } else {
	$data = @$func($path);
	if ($data) {
	  // SimpleXMLElementはそのままcacheできないっぽい。一度xmlテキストにする。
	  $caching = $data->asXML();
	} else $caching = false;
	Cache::write($path, $caching, self::$retrieveCacheConfig);
      }
    } else {
      $data = @$func($path);
    }
    return $data;
  }

  /*******************************************************/
  /* Primitives                                          */
  /*******************************************************/
  public static function buildGuid()
  {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
  }
  public static function expandUrl($short_url)
  {
    $h = @get_headers($short_url, 1);
    if (!$h) return false;
    if(!isset($h['Location'])) return false;

    $long_url = $h['Location'];
    if(is_array($long_url)){ 
      $long_url = end($long_url);
    }
    return $long_url;
  }
  public static function smartArrayUnique($arr)
  {
    if (!is_array($arr)) return false;
    return array_merge(array_unique($arr)); // 歯抜けを直すためのarray_merge()
  }
  // 100レコードずつに分離する
  public static function objChunk($feed, $limit = 100)
  {
    $chunk = [];
    $arr = [];
    foreach($feed as $item) {
      $arr[] = $item;
      if (count($arr) >= $limit) {
	$chunk[] = $arr;
	$arr = [];
      }
    }
    if (count($arr) > 0) {
      $chunk[] = $arr;
    }
    return $chunk;
  }
  // 改行を除外する
  public static function removeLineBreak($text)
  {
    if (!is_string($text)) return false;

    $pattern = '/[\r\n]+/';
    $replacement = ' ';
    $options = self::buildRegexOption($replacement, $pattern);
    return self::regReplace($text, $options);    
  }

  public static function stripQueryString($url)
  {
    if (!self::isUrl($url)) return false;
    $regex = '/\?.*$/'; // querystring を削除する。
    return preg_replace($regex, "", $url);
  }

  // U以外からの呼び出しで$url毎にキャッシュで扱うケースが多かったので共通的に使うために作成した。
  public static function cachedFuncByUrl($func, $url, $retrieveCacheConfig = 'halfhour')
  {
    // config retrieveCache setting
    $cacheOrigin = self::$retrieveCacheConfig;
    self::$retrieveCacheConfig = $retrieveCacheConfig;
    // get result with $url arg
    $ret = self::{$func}($url);
    // put the cache setting back
    self::$retrieveCacheConfig = $cacheOrigin;
    return $ret;
  }

  public static function getSubdomain()
  {
    $domain            = 'gluons.link';
    $domain_local      = 'localhost:8765';
    $domain_virtualbox = 'local.gluons';

    $original = $_SERVER["HTTP_HOST"];
    $tmp = str_replace('.' . $domain, '', $original);
    $tmp = str_replace('.' . $domain_local, '', $tmp);
    $ret = str_replace('.' . $domain_virtualbox, '', $tmp);

    if (($tmp == $domain) || ($tmp == $domain_local) || ($tmp == $domain_virtualbox)) {
      $ret = '';
    }
    return $ret;
  }

}
