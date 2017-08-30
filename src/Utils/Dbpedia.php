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

  public function readPage($query)
  {
    if (!is_string($query) || empty($query)) return false;
    $template = 'http://ja.dbpedia.org/page/%s';
    $path = sprintf($template, urlencode($query));


    $element = '//body';
    $res = U::getXpathFromUrl($path, $element);
    debug($res);


  }
  
}
