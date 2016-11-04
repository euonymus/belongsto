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
            'foreignKey' => 'subject_id'
        ]);
    }

    public function buildActiveRelation()
    {
	$association = [
          'belongsToMany' => [
              'Objects' => [
                  'joinTable' => 'subjects',
                  'through' => 'Relations',
               ]
          ],
        ];
	$this->addAssociations($association);
    }

    public function bindSubjectSearch()
    {
	$association = [
          'hasOne' => [
              'SubjectSearches' => [
                  'className'  => 'SubjectSearches',
		  'foreignKey' => 'id',
		  'dependent' => true,
               ]
          ],
        ];
	$this->addAssociations($association);
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
      $this->bindSubjectSearch();
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
    public static function bigramize($str)
    {
      return NgramConverter::to_query($str, 2);
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
    /* Conditions                                                               */
    /****************************************************************************/
    public function search($search_words)
    {
      $this->bindSubjectSearch();
      $expr = self::bigramize($search_words);
      $query = $this
	->find('all')
	->contain(['SubjectSearches'])
	->matching('SubjectSearches')
	->where(["MATCH(SubjectSearches.search_words) AGAINST(:search)"])->bind(":search", $expr);
      return $query;
    }
}
