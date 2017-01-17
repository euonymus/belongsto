<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Actives Model
 *
 * @property \Cake\ORM\Association\HasMany $Relations
 *
 * @method \App\Model\Entity\Active get($primaryKey, $options = [])
 * @method \App\Model\Entity\Active newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Active[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Active|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Active patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Active[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Active findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ActivesTable extends AppTable
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

        $this->table(self::$subjects);
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Relations', [
            'foreignKey' => 'active_id'
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

        $validator
            ->allowEmpty('url');

        $validator
            ->allowEmpty('affiliate');

        return $validator;
    }
    /*******************************************************/
    /* where                                               */
    /*******************************************************/
    public function wherePrivacyId($id)
    {
      return [self::whereId($id), self::wherePrivacy()];
    }
    public function wherePrivacy()
    {
      if ($this->privacyMode == \App\Controller\AppController::PRIVACY_PUBLIC) {
	return self::wherePublic();
      } elseif ($this->privacyMode == \App\Controller\AppController::PRIVACY_PRIVATE) {
	return self::wherePrivate($this->auth->user('id'));
      } elseif ($this->privacyMode == \App\Controller\AppController::PRIVACY_ALL) {
	return self::whereAllPrivacy($this->auth->user('id'));
      } elseif ($this->privacyMode == \App\Controller\AppController::PRIVACY_ADMIN) {
	return self::whereAllRecord();
      }
      return self::whereNoRecord();
    }

    public static function whereId($id)
    {
      return ['Actives.id' => $id];
    }

    public static function wherePublic()
    {
      return ['Actives.is_private' => false];
    }
    public static function wherePrivate($user_id)
    {
      return ['Actives.is_private' => true, 'Actives.user_id' => $user_id];
    }
    public static function whereAllPrivacy($user_id)
    {
      return ['or' => [self::wherePrivate($user_id), self::wherePublic()]];
    }


    public static function whereAllRecord()
    {
      return [true];
    }
    public static function whereNoRecord()
    {
      return ['Actives.id' => false];
    }
}
