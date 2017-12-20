<?
namespace App\Shell;
use Cake\Console\Shell;

use Cake\Core\Configure;

use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use App\Model\Table\SubjectsTable;
use App\Model\Table\CategorylinksTable;

use App\Utils\U;
use App\Utils\Wikipedia;

class WikipediaShell extends Shell
{
  public static $retrieveCacheConfig = 'default';
  public function startup()
  {
    Configure::write('Belongsto.lang',     'ja');
    Configure::write('Belongsto.lang_eng', 'eng');
    Configure::write('Belongsto.privacyMode', \App\Controller\AppController::PRIVACY_PUBLIC);
    $this->Subjects = TableRegistry::get('Subjects');
    $this->Relations = TableRegistry::get('Relations');
  }

  public static $category_depth = 0; // Do not change this. this is the default value.
  public function category($path = NULL)
  {
    self::$category_depth++;
    // TODO: 下のself::$category_depth の限界値を操作して実行範囲を決める
    if (self::$category_depth > 2) return false;

    if (!$path) {
      $query = 'Category:日本の女性声優';
      //$query = 'Category:日本の男性声優';
      //$query = 'Category:日本の実業家';

      $template = 'https://ja.wikipedia.org/wiki/%s';
      $path = sprintf($template, urlencode($query));
    }

    U::$retrieveCacheConfig = self::$retrieveCacheConfig;
    $xmlraw = U::getXpathFromUrl($path, Wikipedia::$xpath_main);
    $xml = $xmlraw[0];
    $xpath = '//div[contains(@id,"mw-pages")]';
    $element = @$xml->xpath($xpath);

    foreach ($element[0]->div->div->div as $div) {
      self::readUls($div->ul);
    }
debug('Depth: ' . self::$category_depth . ' done.');

    $next = self::retrieveNextUrl($element);
    if (!$next) return false;

    self::category($next);
  }

  public function simplelist()
  {
    //$query = 'ミュージシャン一覧_(グループ)';
    //$query = '日本のバンド一覧';
    //$query = '日本の老舗一覧'; // failed
    //$query = 'ベーシストの一覧';
    //$query = 'ドラマーの一覧';
    //$query = '日本の大学一覧';
    $xml = Wikipedia::readPage($query);
    self::readUls($xml->ul);
  }

  // DONE
  //public function metal()
  //{
  //  $query = 'ヘヴィメタル・アーティストの一覧';
  //  $xml = Wikipedia::readPage($query);
  //  $xpath = '//table[contains(@style,"text-align:left")]';
  //  $element = @$xml->xpath($xpath);
  //
  //  foreach ($element[0]->tr->td as $td) {
  //    self::readUls($td->ul);
  //  }
  //}
  // DONE
  //public function guitarist()
  //{
  //  $query = 'ギタリストの一覧';
  //  $xml = Wikipedia::readPage($query);
  //  $xpath = '//table[contains(@class,"multicol")]';
  //  $element = @$xml->xpath($xpath);
  //
  //  foreach ($element as $table) {
  //    foreach ($table->tr as $tr) {
  //	foreach ($tr->td as $td) {
  //	  self::readUls($td->ul);
  //	}
  //    }
  //  }
  //}

  /*****************************************************/
  /* Table                                             */
  /*****************************************************/
  public function saveFromPage()
  {
    // TODO: change executing number below.
    $repeating = 300000;
    for ($page = 0; $page < $repeating; $page++) {
      $res = $this->Subjects->saveFromPages();
      if (!$res) {
	echo 'something wrong happened';
	break;
      }
    }
  }

  public function updateWithCategorylink()
  {
    $type = CategorylinksTable::CATEGORY_TYPE_PERSON;
    //$type = CategorylinksTable::CATEGORY_TYPE_ALBUM;
    //$type = CategorylinksTable::CATEGORY_TYPE_ELEMENTARY;
    //$type = CategorylinksTable::CATEGORY_TYPE_JUNIOR_HIGH;
    //$type = CategorylinksTable::CATEGORY_TYPE_HIGH_SCHOOL;
    //$type = CategorylinksTable::CATEGORY_TYPE_UNIVERSITY;

    $this->Subjects->updateWithCategorylink($type);
  }


  public function buildGluonWithCategorylink()
  {
    $type = CategorylinksTable::CATEGORY_TYPE_ALBUM;
    //$type = CategorylinksTable::CATEGORY_TYPE_ELEMENTARY;
    //$type = CategorylinksTable::CATEGORY_TYPE_JUNIOR_HIGH;
    //$type = CategorylinksTable::CATEGORY_TYPE_HIGH_SCHOOL;
    //$type = CategorylinksTable::CATEGORY_TYPE_UNIVERSITY;

    $this->Subjects->buildGluonWithCategorylink($type);
  }

  /*****************************************************/
  /* Tools                                             */
  /*****************************************************/
  public function saveQuarkFromList()
  {
    require_once("quark_candidates.php");

// TODO: delete ===
$i = 0;
$j = 0;
//=================
    foreach ($candidates as $candidate) {
      $saved = $this->saveQuarkByType($candidate['name'], $candidate['type']);
// TODO: delete ===
if ($saved) $j++;
if ($i > 600) break;
$i++;
//=================
    }
// TODO: delete ===
debug($j);
//=================
  }

  public function saveQuarkByType($name, $type = NULL)
  {
    Wikipedia::$internal = true; // in order not to access google search
    SubjectsTable::$internal = true; // in order not to access google search
    return $this->Subjects->insertInfoFromWikipedia($name, $type);
  }

  public static $i = 0;
  public function readUls($uls)
  {
    $start = 0;
    $end = $start + 100000;

    foreach ($uls as $ul) {
      foreach ($ul->li as $li) {

	self::$i++;
	if ((self::$i < $start) || (self::$i >= $end)) continue;
	//debug(self::$i);

	if (!is_object($li) || !property_exists($li, 'a') ||
	!$li->a->attributes()) continue;

	//debug((string)$li->a->attributes()->title);
	$xml = Wikipedia::readPageByPath((string)$li->a->attributes()->href);
	if (!$xml) continue;
	$ret = Wikipedia::constructData($xml);

	SubjectsTable::$internal = true;
	$saved = $this->Subjects->saveNewArray($ret);
	if ($saved) {
	  debug($ret);
	}
/*
*/

// TODO remove
//break;
      }
// TODO remove
//break;
    }
  }

  public static function retrieveNextUrl($element)
  {
    if (!is_array($element) || empty($element) || !$element[0] ||
	!is_object($element[0]) || !property_exists($element[0], 'a') ||
	!$element[0]->a->attributes()) return false;
    return "https://ja.wikipedia.org" . (string)$element[0]->a->attributes()->href;
  }
}
