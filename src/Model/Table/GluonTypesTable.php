<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GluonTypes Model
 *
 * @property \Cake\ORM\Association\HasMany $QpropertyGtypes
 *
 * @method \App\Model\Entity\GluonType get($primaryKey, $options = [])
 * @method \App\Model\Entity\GluonType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\GluonType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GluonType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GluonType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GluonType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\GluonType findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GluonTypesTable extends Table
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

        $this->table('gluon_types');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

	// These are the possible properties of the gluon type
        $this->belongsToMany('QuarkProperties', [
	    'through' => 'QpropertyGtypes',
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

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('caption', 'create')
            ->notEmpty('caption');

        $validator
            ->requirePresence('caption_ja', 'create')
            ->notEmpty('caption_ja');

        return $validator;
    }
}
