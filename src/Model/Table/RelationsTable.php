<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

use App\Utils\U;

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
}
