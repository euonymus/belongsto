<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * QuarkTypes Model
 *
 * @property \Cake\ORM\Association\HasMany $QpropertyTypes
 * @property \Cake\ORM\Association\HasMany $QtypeProperties
 *
 * @method \App\Model\Entity\QuarkType get($primaryKey, $options = [])
 * @method \App\Model\Entity\QuarkType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\QuarkType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\QuarkType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\QuarkType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\QuarkType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\QuarkType findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class QuarkTypesTable extends Table
{
    const TYPE_THING       = 1;
    const TYPE_PERSON      = 2;
    const TYPE_MOVIE       = 10;
    const TYPE_CORPORATION = 23;
    const TYPE_UNIVERSITY  = 25;
    const TYPE_ELEM_SCHOOL = 26;
    const TYPE_HIGH_SCHOOL = 27;
    const TYPE_MID_SCHOOL  = 28;
    const TYPE_PRE_SCHOOL  = 29;
    const TYPE_SCHOOL      = 30;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('quark_types');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

	// These are the properties the quark type contains through gluon
        $this->belongsToMany('QuarkProperties', [
	    'through' => 'QtypeProperties',
            'foreignKey' => 'quark_type_id',
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
            ->requirePresence('image_path', 'create')
            ->notEmpty('image_path');

        $validator
            ->requirePresence('name_prop', 'create')
            ->notEmpty('name_prop');

        $validator
            ->requirePresence('start_prop', 'create')
            ->notEmpty('start_prop');

        $validator
            ->requirePresence('end_prop', 'create')
            ->notEmpty('end_prop');

        $validator
            ->integer('has_gender')
            ->requirePresence('has_gender', 'create')
            ->notEmpty('has_gender');

        return $validator;
    }
    /*******************************************************/
    /* where                                               */
    /*******************************************************/
    public static function whereIsPerson()
    {
      return ['QuarkTypes.id' => self::TYPE_PERSON];
    }
    public static function whereIsMovie()
    {
      return ['QuarkTypes.id' => self::TYPE_MOVIE];
    }

    public static function whereAllRecord()
    {
      return ['1' => '1'];
    }
    public static function whereNoRecord()
    {
      return ['QuarkTypes.id' => false];
    }
}
