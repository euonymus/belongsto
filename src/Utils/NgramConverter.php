<?php
namespace App\Utils;
class NgramConverter{
  // MEMO: euonymus custom start here
  //  const DELIMITER = '/([\\s,\\.":;\\(\\)\\[\\]\\{\\}\\!\\?\\-\\+\\|\\/<>\\\'{}_\\\\]|　|。|、|・|：|；|「|」|（|）|｛|｝|《|》|〈|〉|【|】|［|］|＜|＞)+/';
  const DELIMITER = '/([\\s,\\.":;\\(\\)\\[\\]\\{\\}\\!\\?\\-\\+\\|\\/<>\\\'{}_\\\\]|　|。|、|・|：|；|「|」|（|）|｛|｝|《|》|〈|〉|【|】|［|］|＜|＞)+/u';
  // euonymus custom end
   
  function NgramConverter(){}
   
  static protected function _to_ngram_fulltext($str, $n){
    $ngrams = array();
    $str = trim($str);
    if ($str == ''){
      return '';
    }
    if (preg_match('/^[0-9a-zA-Z]+$/', $str)){
      return $str;
    }
     
    $length = mb_strlen($str,'UTF-8') ;
    for ($i = 0; $i < $length; $i++) {
      $ngram = mb_substr($str, $i, $n, 'UTF-8');
      $ngrams[] = $ngram;
    }
     
    return join(' ', $ngrams);
  }
   
  static protected function _to_ngram_query($str, $n){
    $str = trim($str);
    if ($str == ''){
      return '';
    }
    if (preg_match('/^[0-9a-zA-Z]+$/', $str)){
      return "+" . $str;
    }
     
    $length = mb_strlen($str,'UTF-8') ;
    if ($length < $n){
      return "+". $str ."*";
    }
     
    $ngrams = array();
    for ($i = 0; $i < $length - $n + 1; $i++) {
      $ngram = mb_substr($str, $i, $n,'UTF-8');
      $ngrams[] = $ngram;
    }
     
    return '+"' . join(' ', $ngrams) . '"';
  }
   
  static protected function _to_ngram($str, $n, $query_flag = FALSE){
    $temp_encoding = mb_regex_encoding();
    mb_regex_encoding('UTF-8');

    // MEMO: euonymus custom start here. セキュリティ＋パフォーマンス改善。
    //    $str = mb_ereg_replace("^(\s|　)+", "", $str);
    //    $str = mb_ereg_replace("(\s|　)+$", "", $str);
    $str = preg_replace("/^(\s|　)+/u", '', $str);
    $str = preg_replace("/(\s|　)+$/u", '', $str);
    // euonymus custom end
    $str_array = preg_split(self::DELIMITER, $str);
     
    mb_regex_encoding($temp_encoding);
     
    $result = array();
    foreach ($str_array as $str){
      if (strlen($str) == 0) {
        continue;
      }
      $length = mb_strlen($str, 'UTF-8') ;
      $tmpArr = array();
      $i = 0;
      while ($i < $length) {
        $char = mb_substr($str, $i, 1, 'UTF-8');
        $j = $i;
        $loopFlag = preg_match('/[0-9a-zA-Z]/', $char) ? false : true;
        while ((preg_match('/[0-9a-zA-Z]/', mb_substr($str, $j, 1, 'UTF-8')) === 0) 
                === $loopFlag) {
          if ($j == $length) {
            break;
          }
          $j++;
        }
        if ($j > $i) {
          $str2 = mb_substr($str, $i, $j - $i, 'UTF-8');
          array_push($tmpArr, $str2);
        }
        $i = $j;
        if ($i == $length) {
          break;
        }
      }
      foreach ($tmpArr as $tmp) {
        if ($query_flag){
          $result[] = self::_to_ngram_query($tmp, $n);
        } else {
          $result[] = self::_to_ngram_fulltext($tmp,$n);
        }
      }
    }
    return join(' ',$result);
  }
   
  public static function to_fulltext($str, $n) {
    return self::_to_ngram($str, $n);
  }
   
  public static function to_query($str, $n) {
    return self::_to_ngram($str,$n,TRUE);
  }
}
