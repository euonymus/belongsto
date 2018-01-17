<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * QuarkProperties Model
 *
 * @property \Cake\ORM\Association\HasMany $QpropertyGtypes
 * @property \Cake\ORM\Association\HasMany $QpropertyTypes
 * @property \Cake\ORM\Association\HasMany $QtypeProperties
 *
 * @method \App\Model\Entity\QuarkProperty get($primaryKey, $options = [])
 * @method \App\Model\Entity\QuarkProperty newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\QuarkProperty[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\QuarkProperty|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\QuarkProperty patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\QuarkProperty[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\QuarkProperty findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class QuarkPropertiesTable extends Table
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

        $this->table('quark_properties');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

	// These are the possible quark types of the property
        $this->belongsToMany('QuarkTypes', [
	    'through' => 'QpropertyTypes',
        ]);

	// These are gluon types the property has
        $this->belongsToMany('GluonTypes', [
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
