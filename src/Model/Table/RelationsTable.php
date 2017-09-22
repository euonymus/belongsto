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
    public function saveGluonsFromWikipedia($subject, $options =[])
    {
      $Subjects = TableRegistry::get('Subjects');

      $query = U::removeAllSpaces($subject->name);
      $relations = Wikipedia::readPageForGluons($query);
      if (!$relations) return false;

      $ret = false;
      if (array_key_exists('relatives', $relations) && $relations['relatives']) {
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

	  $saved = $this->save($saving, $options);
	}
	$ret = true;
      }
      if (array_key_exists('scenario_writers', $relations) && $relations['scenario_writers']) {
	foreach($relations['scenario_writers'] as $val) {
	  if (!is_string($val)) continue;
	  $subject2 = $Subjects->forceGetQuark($val);
	  $gluon = self::constGluonSub2OnSub1($subject, $subject2, 'の脚本を手がけた');
	  if (!$gluon) continue;

	  // if the relation already exists, skip it.
	  if ($this->checkRelationExists($gluon['active_id'], $gluon['passive_id'])) continue;

	  $saving = $this->formToEntity($gluon);
	  $saving->user_id = 1;
	  $saving->last_modified_user = 1;
	  $saved = $this->save($saving, $options);
	}
	$ret = true;
      }
      if (array_key_exists('original_authors', $relations) && $relations['original_authors']) {
	foreach($relations['original_authors'] as $val) {
	  if (!is_string($val)) continue;
	  $subject2 = $Subjects->forceGetQuark($val);
	  $gluon = self::constGluonSub2OnSub1($subject, $subject2, 'の原作者');
	  if (!$gluon) continue;

	  // if the relation already exists, skip it.
	  if ($this->checkRelationExists($gluon['active_id'], $gluon['passive_id'])) continue;

	  $saving = $this->formToEntity($gluon);
	  $saving->user_id = 1;
	  $saving->last_modified_user = 1;
	  $saved = $this->save($saving, $options);
	}
	$ret = true;
      }
      if (array_key_exists('actors', $relations) && $relations['actors']) {
	foreach($relations['actors'] as $val) {
	  if (!is_string($val)) continue;
	  $subject2 = $Subjects->forceGetQuark($val);
	  $gluon = self::constGluonSub2OnSub1($subject, $subject2, 'に出演した');
	  if (!$gluon) continue;

	  // if the relation already exists, skip it.
	  if ($this->checkRelationExists($gluon['active_id'], $gluon['passive_id'])) continue;

	  $saving = $this->formToEntity($gluon);
	  $saving->user_id = 1;
	  $saving->last_modified_user = 1;
	  $saved = $this->save($saving, $options);
	}
	$ret = true;
      }
      if (array_key_exists('directors', $relations) && $relations['directors']) {
	foreach($relations['directors'] as $val) {
	  if (!is_string($val)) continue;
	  $subject2 = $Subjects->forceGetQuark($val);
	  $gluon = self::constGluonSub2OnSub1($subject, $subject2, 'の監督');
	  if (!$gluon) continue;

	  // if the relation already exists, skip it.
	  if ($this->checkRelationExists($gluon['active_id'], $gluon['passive_id'])) continue;

	  $saving = $this->formToEntity($gluon);
	  $saving->user_id = 1;
	  $saving->last_modified_user = 1;
	  $saved = $this->save($saving, $options);
	}
	$ret = true;
      }
      return $ret;
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


      if (array_key_exists('source', $relative) && $relative['source']) {
	$source = $relative['source'];
      } else {
	$source = NULL;
      }

      return [
	      'active_id'      => $active_id,
	      'passive_id'     => $passive_id,
	      'relation'       => $relation,
	      'start'          => $start,
	      'start_accuracy' => $start_accuracy,
	      'is_momentary'   => true,
	      'source'         => $source,
      ];
    }
    public static function constGluonSub2OnSub1($subject1, $subject2, $relation)
    {
      $active_id      = $subject2->id;
      $passive_id     = $subject1->id;
      $relation       = $relation;
      $start          = $subject1->start ? $subject1->start->format('Y-m-d H:i:s') : NULL;
      $start_accuracy = $subject1->start_accuracy;

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
