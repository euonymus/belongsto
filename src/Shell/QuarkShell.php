<?
namespace App\Shell;
use Cake\Console\Shell;

use Cake\Core\Configure;

use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use App\Model\Table\SubjectsTable;
use App\Model\Table\QuarkTypesTable;

use App\Utils\U;
use App\Utils\Wikipedia;

class QuarkShell extends Shell
{
  public static $type_texts = [];
  public function startup()
  {
    Configure::write('Belongsto.lang',     'ja');
    Configure::write('Belongsto.lang_eng', 'eng');
    Configure::write('Belongsto.privacyMode', \App\Controller\AppController::PRIVACY_PUBLIC);
    $this->Subjects = TableRegistry::get('Subjects');
    $this->Relations = TableRegistry::get('Relations');
  }

  public function setHoge()
  {
    $this->Subjects = TableRegistry::get('Subjects');
    $where = [SubjectsTable::whereNoQuarkTypeId()];
    $subjects = $this->Subjects->find()->where([$where])->limit(50000);

    foreach($subjects as $subject) {
      //$subject->quark_type_id = QuarkTypesTable::TYPE_PERSON;
      debug($subject->name);
      //$this->Subjects->save($subject);
    }
  }
  /*****************************************************************/
  /* Done                                                          */
  /*****************************************************************/
  public function setCorporation()
  {
    $this->Subjects = TableRegistry::get('Subjects');
    $where = [SubjectsTable::whereNoQuarkTypeId()];
    $subjects = $this->Subjects->find()->where([$where,['Subjects.name like' => '%株式会社%']]);

    foreach($subjects as $subject) {
      $subject->quark_type_id = QuarkTypesTable::TYPE_CORPORATION;
      debug($subject->name);
      $this->Subjects->save($subject);
    }
  }
  public function setSchool()
  {
    $this->Subjects = TableRegistry::get('Subjects');
    $where = [SubjectsTable::whereNoQuarkTypeId()];
    $subjects = $this->Subjects->find()->where([$where,['Subjects.name like' => '%学校']]);

    foreach($subjects as $subject) {
      $subject->quark_type_id = QuarkTypesTable::TYPE_SCHOOL;
      debug($subject->name);
      $this->Subjects->save($subject);
    }
  }
  public function setHighSchool()
  {
    $this->Subjects = TableRegistry::get('Subjects');
    $where = [SubjectsTable::whereNoQuarkTypeId()];
    $subjects = $this->Subjects->find()->where([$where,['Subjects.name like' => '%高校']]);
    //$subjects = $this->Subjects->find()->where([$where,['Subjects.name like' => '%高等学校']]);

    foreach($subjects as $subject) {
      $subject->quark_type_id = QuarkTypesTable::TYPE_HIGH_SCHOOL;
      debug($subject->name);
      $this->Subjects->save($subject);
    }
  }
  public function setMiddleSchool()
  {
    $this->Subjects = TableRegistry::get('Subjects');
    $where = [SubjectsTable::whereNoQuarkTypeId()];
    $subjects = $this->Subjects->find()->where(['Subjects.name like' => '%中学校']);

    foreach($subjects as $subject) {
      $subject->quark_type_id = QuarkTypesTable::TYPE_MID_SCHOOL;
      debug($subject->name);
      $this->Subjects->save($subject);
    }
  }
  public function setElementarySchool()
  {
    $this->Subjects = TableRegistry::get('Subjects');
    $where = [SubjectsTable::whereNoQuarkTypeId()];
    $subjects = $this->Subjects->find()->where([$where,['Subjects.name like' => '%小学校']]);

    foreach($subjects as $subject) {
      $subject->quark_type_id = QuarkTypesTable::TYPE_ELEM_SCHOOL;
      debug($subject->name);
      $this->Subjects->save($subject);
    }
  }
  public function setUniversity()
  {
    $this->Subjects = TableRegistry::get('Subjects');
    $where = [SubjectsTable::whereNoQuarkTypeId()];
    //$subjects = $this->Subjects->find()->where($where)->limit(50000)->order(['Subjects.name' => 'DESC']);
    $subjects = $this->Subjects->find()->where([$where,['Subjects.name like' => '%大学%']]);//->limit(50000)->order(['Subjects.name' => 'DESC']);

    foreach($subjects as $subject) {
      if (preg_match('/大学(?![付附]属)/', $subject->name)) {
	if (preg_match('/^(?!.*([小中]学|高[校等])).*$/', $subject->name)) {
	  $subject->quark_type_id = QuarkTypesTable::TYPE_UNIVERSITY;
	  debug($subject->name);
	  $this->Subjects->save($subject);
	}
      }
    }
  }
  public function setPerson()
  {
    $this->Subjects = TableRegistry::get('Subjects');    
    $where = [SubjectsTable::whereNoQuarkTypeId(), SubjectsTable::whereIsPerson()];
    $subjects = $this->Subjects->find()->where($where);

    /* $i = 0; */
    /* $repeating = 100; */
    foreach($subjects as $subject) {
      $subject->quark_type_id = QuarkTypesTable::TYPE_PERSON;
      debug($subject->name);
      $this->Subjects->save($subject);
      //$i++; if ($i >= $repeating) break;
    }
  }
  public function setPerson2()
  {
    require_once("quark_candidates.php");

    $this->Subjects = TableRegistry::get('Subjects');
    foreach($candidates as $candidate) {
      $subjects = $this->Subjects->find()->where(SubjectsTable::whereName($candidate['name']));
      foreach($subjects as $subject) {
    	$subject->quark_type_id = QuarkTypesTable::TYPE_PERSON;
    	debug($subject->name);
    	$this->Subjects->save($subject);
      }
    }
  }
  public function setMovie()
  {
    require_once("quark_candidates.php");

    $this->Subjects = TableRegistry::get('Subjects');
    foreach($candidates as $candidate) {
      $subjects = $this->Subjects->find()->where(SubjectsTable::whereName($candidate['name']));
      foreach($subjects as $subject) {
	$subject->quark_type_id = QuarkTypesTable::TYPE_MOVIE;
	debug($subject->name);
	$this->Subjects->save($subject);
      }
    }
  }
}
