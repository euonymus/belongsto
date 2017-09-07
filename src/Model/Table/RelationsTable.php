<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

use App\Utils\U;
use App\Utils\GlobalDataSet;
use App\Utils\Wikipedia;

/**
 * Relations Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Actives
 * @property \Cake\ORM\Association\BelongsTo $Passives
 *
 * @method \App\Model\Entity\Relation get($primaryKey, $options = [])
 * @method \App\Model\Entity\Relation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Relation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Relation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Relation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Relation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Relation findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RelationsTable extends AppTable
{
    public $privacyMode = \App\Controller\AppController::PRIVACY_PUBLIC;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table(self::$relations);
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->privacyMode = Configure::read('Belongsto.privacyMode');
	$this->belongsToActives();
	$this->belongsToPassives();
    }

    public function belongsToActives()
    {
        $options = [
            'foreignKey' => 'active_id',
            'joinType' => 'INNER'
        ];

	$Actives = TableRegistry::get('Actives');
	$conditions = $Actives->wherePrivacy();
	$options['conditions'] = $conditions;

        $this->belongsTo('Actives', $options);
    }
    public function belongsToPassives()
    {
        $options = [
            'foreignKey' => 'passive_id',
            'joinType' => 'INNER'
        ];

	$Passives = TableRegistry::get('Passives');
	$conditions = $Passives->wherePrivacy();
	$options['conditions'] = $conditions;

        $this->belongsTo('Passives', $options);
    }

    public function formToEntity($arr)
    {
      $ret = $this->newEntity($arr);
      $ret->id = U::buildGuid(); // varchar 36 フィールドのinsertには必要。
      return $ret;
    }

    public function formToSaving($form)
    {
      if (!is_array($form)) return false;
      return $this->formToEntity($form);
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
            ->requirePresence('relation', 'create')
            ->notEmpty('relation');

        $validator
	  // なぜか validation errorが起きるので停止。
	  // ->dateTime('start')
            ->allowEmpty('start');

        $validator
	  // なぜか validation errorが起きるので停止。
	  // ->dateTime('end')
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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['active_id'], 'Actives'));
        $rules->add($rules->existsIn(['passive_id'], 'Passives'));

        return $rules;
    }

    public function getByBaryon($baryon_id, $contain = NULL)
    {
      return $this->findByBaryonId($baryon_id)->contain($contain);
    }

    /*******************************************************/
    /* where                                               */
    /*******************************************************/
    public static function whereActivePassivePair($active_id, $passive_id)
    {
      return ['Relations.active_id' => $active_id, 
	      'Relations.passive_id' => $passive_id];
    }
    
    /*******************************************************/
    /* batch                                               */
    /*******************************************************/
    public function saveGluonsFromWikipedia($subject)
    {
      $Subjects = TableRegistry::get('Subjects');
      $relations = Wikipedia::readPageForGluons($subject->name);
      // treat relatives
      foreach($relations['relatives'] as $val) {
	if (!is_array($val) || !array_key_exists('main', $val)) continue;
	$subject2 = $Subjects->forceGetQuark($val['main']);
	$gluon = self::constRelativeGluon($subject, $subject2, $val);
	if (!$gluon) continue;

	// if the relation already exists, skip it.
	if ($this->checkRelationExists($gluon['active_id'], $gluon['passive_id'])) continue;

	$saving = $this->formToEntity($gluon);
	$saving->user_id = 1;
	$saving->last_modified_user = 1;
// TODO: なぜか保存されない。意味不明
	$saved = $this->save($saving);
      }
    }
    public function checkRelationExists($active_id, $passive_id)
    {
      $where = self::whereActivePassivePair($active_id, $passive_id);
      $data = $this->find()->where($where)->first();
      return !!$data;
    }

    /*******************************************************/
    /* Tools                                               */
    /*******************************************************/
    public static function constRelativeGluon($subject1, $subject2, $relative)
    {
      if (!self::checkRelativeInfoFormat($relative)) return false;
      if (GlobalDataSet::isYoungerRelativeType($relative['relative_type'])) {
	$active_id      = $subject2->id;
	$passive_id     = $subject1->id;
	$relation       = 'の' . $relative['relative_type'];
	$start          = $subject2->start ? $subject2->start->format('Y-m-d H:i:s') : NULL;
	$start_accuracy = $subject2->start_accuracy;
      } elseif (GlobalDataSet::isOlderRelativeType($relative['relative_type'])) {
	$active_id      = $subject1->id;
	$passive_id     = $subject2->id;
	$relation       = 'を' . $relative['relative_type'] . 'に持つ';
	$start          = $subject1->start ? $subject1->start->format('Y-m-d H:i:s') : NULL;
	$start_accuracy = $subject1->start_accuracy;
      } else return false;

      return [
	      'active_id'      => $active_id,
	      'passive_id'     => $passive_id,
	      'relation'       => $relation,
	      'start'          => $start,
	      'start_accuracy' => $start_accuracy,
	      'is_momentary'   => true,
      ];
    }
    public static function checkRelativeInfoFormat($relative)
    {
      return (is_array($relative) && array_key_exists('main', $relative) && array_key_exists('relative_type', $relative));
    }
}
