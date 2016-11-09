<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use Cake\ORM\TableRegistry;
use App\Model\Table\SubjectSearchesTable;

use App\Utils\U;
use App\Utils\NgramConverter;

/**
 * Subjects Model
 *
 * @property \Cake\ORM\Association\HasMany $Relations
 *
 * @method \App\Model\Entity\Subject get($primaryKey, $options = [])
 * @method \App\Model\Entity\Subject newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Subject[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Subject|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Subject patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Subject[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Subject findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SubjectsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('subjects');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Relations', [
            'foreignKey' => 'active_id'
        ]);

        $this->hasOne('SubjectSearches', [
            'className'  => 'SubjectSearches',
	    'foreignKey' => 'id',
	    'dependent' => true,
        ]);
        $this->belongsToMany('Passives', [
            'through' => 'Relations',
            'foreignKey' => 'active_id'
        ]);
        $this->belongsToMany('Actives', [
            'through' => 'Relations',
            'foreignKey' => 'passive_id'
        ]);
    }

    public function formToEntity($arr)
    {
      $ret = $this->newEntity($arr);
      $ret->id = U::buildGuid(); // varchar 36 フィールドのinsertには必要。
      return $ret;
    }
    public function patchSearchOnData($data)
    {
      $arr = $data->toArray();
      $arr['subject_search'] = self::composeSearchArr($data);
      $ret = $this->newEntity($arr, ['associated' => ['SubjectSearches']]);
      $ret->id = $data->id;
      return $ret;
    }
    public static function composeSearchArr($data)
    {
      if (!is_object($data)) return false;
      $search_words = self::bigramize($data->name . $data->description);
      if (!$search_words) return false;
      $ret = ['id' => $data->id, 'search_words' => $search_words];
      return $ret;
    }
    public function formToSaving($form)
    {
      if (!is_array($form)) return false;
      $data = $this->formToEntity($form);
      return $this->patchSearchOnData($data);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->allowEmpty('image_path');

        $validator
            ->allowEmpty('description');

        $validator
            ->dateTime('start')
            ->allowEmpty('start');

        $validator
            ->dateTime('end')
            ->allowEmpty('end');

        $validator
            ->allowEmpty('start_accuracy');

        $validator
            ->allowEmpty('end_accuracy');

        $validator
            ->boolean('is_momentary')
            ->requirePresence('is_momentary', 'create')
            ->notEmpty('is_momentary');

        return $validator;
    }

    /****************************************************************************/
    /* Edit Data                                                                */
    /****************************************************************************/

    /****************************************************************************/
    /* Get Data                                                                 */
    /****************************************************************************/
    public function getRelations($id, $contain = NULL, $level = 1)
    {
      if (!is_numeric($level) || ($level > 2)) return false;

      $options = [];
      if (($level != 0) && !is_null($contain)) {
	$options = ['contain' => $contain];
      }
      $subject = $this->get($id, $options);

      // 2nd level relations
      if (($level == 2) && !is_null($contain)) {
	for($i = 0; count($subject->actives) > $i; $i++) {
	  $Relations = TableRegistry::get('Relations');
	  $subject->actives[$i]->relation
	    = $Relations->find('all', ['contain' => 'Actives'])->where(['passive_id' => $subject->actives[$i]->id]);
	}
	for($i = 0; count($subject->passives) > $i; $i++) {
	  $Relations = TableRegistry::get('Relations');
	  $subject->passives[$i]->relation
	    = $Relations->find('all', ['contain' => 'Actives'])->where(['passive_id' => $subject->passives[$i]->id]);
	}
      }
      return $subject;
    }

    public function search($search_words)
    {
      $expr = self::bigramize($search_words);
      $query = $this
	->find('all')
	->contain(['SubjectSearches', 'Actives'])
	->matching('SubjectSearches')
	->where(["MATCH(SubjectSearches.search_words) AGAINST(:search)"])->bind(":search", $expr);
      return $query;
    }


    /****************************************************************************/
    /* Tools                                                                    */
    /****************************************************************************/
    public static function bigramize($str)
    {
      return NgramConverter::to_query($str, 2);
    }
}
