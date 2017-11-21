<?
namespace App\Shell;
use Cake\Console\Shell;

use Cake\Core\Configure;

use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use App\Model\Table\SubjectsTable;

use App\Utils\U;
use App\Utils\Wikipedia;

class RetrieveShell extends Shell
{
  public function startup()
  {
    Configure::write('Belongsto.lang',     'ja');
    Configure::write('Belongsto.lang_eng', 'eng');
    Configure::write('Belongsto.privacyMode', \App\Controller\AppController::PRIVACY_PUBLIC);
    $this->Subjects = TableRegistry::get('Subjects');
    $this->Relations = TableRegistry::get('Relations');
  }

  public function retrieveRelatives()
  {
    $this->Subjects->findAndSaveRelatives(100);
  }

  public function retrieveTalents($generation = 10, $page = 1)
  {
    $this->Subjects->retrieveAndSaveTalents($generation, $page);
  }

  /********************************************/
  /* Migration                                */
  /********************************************/
  public function talentCollector()
  {
    $generation = 10;
    $page_range = [1,2];

    /********* All List *********/
    //$page_range = [1,100];
    //$page_range = [101,200];
    //$page_range = [201,284];

    //$generation = 20;
    //$page_range = [1,100];
    //$page_range = [101,200];
    //$page_range = [201,300];
    //$page_range = [301,400];
    //$page_range = [401,500];
    //$page_range = [501,600];
    //$page_range = [601,700];
    //$page_range = [701,825];

    //$generation = 30;
    //$page_range = [1,100];
    //$page_range = [101,200];
    //$page_range = [201,300];
    //$page_range = [301,400];
    //$page_range = [401,500];
    //$page_range = [501,600];
    //$page_range = [601,700];
    //$page_range = [701,800];
    //$generation = 30;
    //$page_range = [801,940];

    //$generation = 40;
    //$page_range = [1,100];
    //$page_range = [101,200];
    //$page_range = [201,300];
    //$page_range = [301,400];
    //$page_range = [401,500];
    //$page_range = [501,600];
    //$page_range = [601,663];

    //$generation = 50;
    //$page_range = [1,100];
    //$page_range = [101,200];
    //$page_range = [201,300];
    //$page_range = [301,385];

    //$generation = 60;
    //$page_range = [1,100];
    //$page_range = [101,200];
    //$page_range = [201,210];

    //$generation = 70;
    //$page_range = [1,10];
    //$page_range = [11,20];
    //$page_range = [21,22];
    //$page_range = [23,106];

    //$generation = 80;
    //$page_range = [1,46];

    //$generation = 90;
    //$page_range = [1,6];
    /***************************/

    for ($page = $page_range[0]; $page <= $page_range[1]; $page++) {
      $this->retrieveTalents($generation, $page);
    }
  }

  public function quarkBuilder()
  {
    $list = [
	     //'髙木義明',
	     ];

    $i = 0;
    foreach($list as $str) {
      $res = $this->Subjects->forceGetQuark($str);
      if ($res) {
	$i++;
	debug($res->name);
      }
    }
    debug($i);
  }

  //$candidates = [
  //  ['吉川貴盛', '第47回衆議院議員総選挙', 'にて北海道2区に自民党から出馬して当選した', '2014/12/14', NULL, TRUE],
  //];
  public function gluonBuilder()
  {
    require_once("gluon_candidates.php");
    $options = ['checkRules' => false];

    $i = 0;
    foreach($candidates as $relation) {
      $res = $this->Relations->saveGluonByRelation($relation, $options);
      if ($res) {
	$i++;
	debug($relation[0]);
      }
    }
    debug($i);
  }

  /********************************************/
  /* Movies                                   */
  /********************************************/
  public function movieCollector()
  {
    // 範囲
    //$range = [1924, 2017];
    // done all
    $range = [1924, 2017];

    $url = '年度別日本公開映画';
    $xml = Wikipedia::readPage($url);

    $xpath = '//div[contains(@class,"mw-parser-output")]/ul';
    $element = @$xml->xpath($xpath);
    foreach ($element as $val) {
      foreach ($val->li as $val2) {
	if (!empty((string)$val2->a->attributes()->class)) continue;

	$title = (string)$val2->a->attributes()->title;
	$res = preg_match('/年の日本公開映画\z/', $title, $matches);
	if (!$res) continue;

	$path = (string)$val2->a->attributes()->href;
	$query = urldecode(preg_replace('/\/wiki\//', '', $path));
	$year = preg_replace('/年の日本公開映画\z/', '', $query);
	if ( ($year < $range[0]) || ($year > $range[1]) ) continue;

	$this->movieCollectorByGeneration($query);
      }
    }
  }

  public function movieCollectorByGeneration($query)
  {
    $xml = Wikipedia::readPage($query);

    $xpath = '//div[contains(@class,"mw-parser-output")]/ul';
    $element = @$xml->xpath($xpath);
    foreach ($element as $val) {
      foreach($val->li as $val2) {
	$res = preg_match('/\d{1,2}日/', (string)$val2, $matches);
	if (!$res) continue;

	foreach ($val2->ul->li as $val3) {
	  if (!empty((string)$val3->a->attributes()->class)) continue;
	  $path = (string)$val3->a->attributes()->href;
	  $query = urldecode(preg_replace('/\/wiki\//', '', $path));
	  $this->movieCollectorByTitle($query);
	}
      }
    }
  }

  public function movieCollectorByTitle($query)
  {
// TODO
    debug($query);
    $this->Subjects->retrieveAndSaveMovie($query);
  }

  public function tryTest()
  {
// TODO
    $query = '牙狼-GARO-_〜RED_REQUIEM〜';
    debug($query);
    $this->Subjects->retrieveAndSaveMovie($query);
  }

  /********************************************/
  /* Books                                    */
  /********************************************/
  public function bookCollector()
  {
    require_once("writer_candidates.php");
    foreach ($writers as $writer) {

      
      $xml = Wikipedia::readPage($writer);

      $xpath = '//div[contains(@class,"mw-parser-output")]/ul';
      $element = @$xml->xpath($xpath);
      debug($element);

      break;
    }
  }
}
