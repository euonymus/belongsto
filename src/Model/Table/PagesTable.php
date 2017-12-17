<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pages Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Pages
 *
 * @method \App\Model\Entity\Page get($primaryKey, $options = [])
 * @method \App\Model\Entity\Page newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Page[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Page|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Page patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Page[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Page findOrCreate($search, callable $callback = null)
 */
class PagesTable extends Table
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

        $this->table('pages');
        $this->displayField('page_id');
        $this->primaryKey('page_id');

        $this->belongsTo('Pages', [
            'foreignKey' => 'page_id',
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
            ->integer('page_namespace')
            ->requirePresence('page_namespace', 'create')
            ->notEmpty('page_namespace');

        $validator
            ->requirePresence('page_title', 'create')
            ->notEmpty('page_title');

        $validator
            ->requirePresence('page_restrictions', 'create')
            ->notEmpty('page_restrictions');

        $validator
            ->requirePresence('page_counter', 'create')
            ->notEmpty('page_counter');

        $validator
            ->boolean('page_is_redirect')
            ->requirePresence('page_is_redirect', 'create')
            ->notEmpty('page_is_redirect');

        $validator
            ->boolean('page_is_new')
            ->requirePresence('page_is_new', 'create')
            ->notEmpty('page_is_new');

        $validator
            ->numeric('page_random')
            ->requirePresence('page_random', 'create')
            ->notEmpty('page_random');

        $validator
            ->requirePresence('page_touched', 'create')
            ->notEmpty('page_touched');

        $validator
            ->allowEmpty('page_links_updated');

        $validator
            ->integer('page_latest')
            ->requirePresence('page_latest', 'create')
            ->notEmpty('page_latest');

        $validator
            ->integer('page_len')
            ->requirePresence('page_len', 'create')
            ->notEmpty('page_len');

        $validator
            ->allowEmpty('page_content_model');

        $validator
            ->allowEmpty('page_lang');

        $validator
            ->boolean('is_treated')
            ->requirePresence('is_treated', 'create')
            ->notEmpty('is_treated');

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
        $rules->add($rules->existsIn(['page_id'], 'Pages'));

        return $rules;
    }

    /*******************************************************/
    /* where                                               */
    /*******************************************************/
    public static function whereViableMigrationCandidates()
    {
      return [self::whereNotTreated(), self::whereViable()];
    }
    public static function whereNotTreated()
    {
      return ['Pages.is_treated' => false];
    }
    public static function whereViable()
    {
      return [['Pages.page_title not like' => '%アップロードログ%'],
	      ['Pages.page_title not like' => '%削除記録%'],
	      ['Pages.page_title not like' => '%削除済み%'],
	      ['Pages.page_title not like' => '%Upload_log%'],
	      ['Pages.page_title not like' => '%Protection_log%'],
	      ['Pages.page_title not like' => '%-stub%'],
	      ];
    }

}
