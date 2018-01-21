<?
namespace App\Shell;
use Cake\Console\Shell;

use Cake\Core\Configure;

use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use App\Model\Table\RelationsTable;

use App\Utils\U;
use App\Utils\Wikipedia;

class GluonShell extends Shell
{
  public static $type_texts = [];
  public function startup()
  {
    Configure::write('Belongsto.lang',     'ja');
    Configure::write('Belongsto.lang_eng', 'eng');
    Configure::write('Belongsto.privacyMode', \App\Controller\AppController::PRIVACY_PUBLIC);
    $this->Subjects = TableRegistry::get('Subjects');
    $this->Relations = TableRegistry::get('Relations');

    require_once("gluon_type_text.php");
    self::$type_texts = $type_texts;
  }

  public function setGluonTypeIds()
  {
    $this->Relations = TableRegistry::get('Relations');
    $where = RelationsTable::whereNoGluonTypeId();
    debug($where);
    $relations = $this->Relations->find()->where($where);
    foreach($relations as $relation) {
      $this->setGluonTypeId($relation);
    }
  }

  public function setGluonTypeId($relation)
  {
    foreach(self::$type_texts as $text => $gluon_type_id) {
      if (!U::sameStr($text, $relation->relation)) continue;
      $relation->gluon_type_id = $gluon_type_id;
      $this->Relations->save($relation);
    }

  }
}
