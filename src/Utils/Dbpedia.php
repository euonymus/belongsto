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
  // references
  // mapping: http://mappings.dbpedia.org/index.php/Mapping_ja
  // Ontology: http://mappings.dbpedia.org/server/ontology/classes/

use Cake\Cache\Cache;
use Cake\Cache\Engine\FileEngine;
use Cake\Log\Log;
class Dbpedia
{
  public function __construct(array $token = array(), array $consumer = array())
  {
  }

  public static function readPage($query)
  {
    if (!is_string($query) || empty($query)) return false;
    $template = 'http://ja.dbpedia.org/page/%s';
    $path = sprintf($template, urlencode($query));

    $element = '//table';
    $res = U::getXpathFromUrl($path, $element);
    foreach($res[0] as $val) {
      if (!property_exists($val, 'td')) continue;

      $type = (string)$val->td[0]->a;

      $content_base = $val->td[1]->ul->li->span;
      if (property_exists($content_base, 'a')) {
	$content_item = $content_base->a;
      } elseif (property_exists($content_base, 'span')) {
	$content_item = $content_base->span;
      }
      $content = preg_replace('/\A:/','',(string)$content_item);

debug($type. ' ' . $content);
    }


  }
  
}
