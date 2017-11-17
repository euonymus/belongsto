<?
namespace App\Shell;
use Cake\Console\Shell;

use Cake\Core\Configure;

use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use App\Model\Table\SubjectsTable;

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
    $query = 'ミュージシャン一覧_(グループ)';
    //$query = '日本のバンド一覧';
    //$query = '日本の老舗一覧';
    //$query = 'ベーシストの一覧';
    //$query = 'ドラマーの一覧';
    $xml = Wikipedia::readPage($query);
    self::readUls($xml->ul);
  }

  public function metal()
  {
    $query = 'ヘヴィメタル・アーティストの一覧';
    $xml = Wikipedia::readPage($query);
    $xpath = '//table[contains(@style,"text-align:left")]';
    $element = @$xml->xpath($xpath);

    foreach ($element[0]->tr->td as $td) {
      self::readUls($td->ul);
    }
  }

  public function guitarist()
  {
    $query = 'ギタリストの一覧';
    $xml = Wikipedia::readPage($query);
    $xpath = '//table[contains(@class,"multicol")]';
    $element = @$xml->xpath($xpath);

    foreach ($element as $table) {
      self::readUls($table->tr->td->ul);
    }
  }

  /*****************************************************/
  /* Tools                                             */
  /*****************************************************/
  public function saveQuarkFromList()
  {
    require_once("quark_candidates.php");

// TODO: delete ===
$i = 0;
//=================
    foreach ($candidates as $candidate) {
      $this->saveQuarkByType($candidate['name'], $candidate['type']);
// TODO: delete ===
if ($i > 0) break;
$i++;
//=================
    }
  }

  public function saveQuarkByType($name, $type = NULL)
  {
    Wikipedia::$internal = true; // in order not to access google search
    $this->Subjects->insertInfoFromWikipedia($name, $type);
  }

  public static function readUls($uls)
  {
    foreach ($uls as $ul) {
      foreach ($ul->li as $li) {
	debug($li->a);
      }
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
