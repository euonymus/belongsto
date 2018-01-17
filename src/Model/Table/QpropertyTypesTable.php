<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * QpropertyTypes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $QuarkProperties
 * @property \Cake\ORM\Association\BelongsTo $QuarkTypes
 *
 * @method \App\Model\Entity\QpropertyType get($primaryKey, $options = [])
 * @method \App\Model\Entity\QpropertyType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\QpropertyType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\QpropertyType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\QpropertyType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\QpropertyType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\QpropertyType findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class QpropertyTypesTable extends Table
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

        $this->table('qproperty_types');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('QuarkProperties', [
            'foreignKey' => 'quark_property_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('QuarkTypes', [
            'foreignKey' => 'quark_type_id',
            'joinType' => 'INNER'
        ]);
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
            ->integer('id')
            ->allowEmpty('id', 'create');

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
        $rules->add($rules->existsIn(['quark_property_id'], 'QuarkProperties'));
        $rules->add($rules->existsIn(['quark_type_id'], 'QuarkTypes'));

        return $rules;
    }
}
