<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Categorylinks Model
 *
 * @method \App\Model\Entity\Categorylink get($primaryKey, $options = [])
 * @method \App\Model\Entity\Categorylink newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Categorylink[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Categorylink|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Categorylink patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Categorylink[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Categorylink findOrCreate($search, callable $callback = null)
 */
class CategorylinksTable extends Table
{
    const STATUS_NOT_TREATED   = 0;
    const STATUS_QUARK_TREATED = 1;
    const STATUS_GLUON_TREATED = 2;

    const CATEGORY_TYPE_PERSON       = 'person';
    const CATEGORY_TYPE_MOVIE        = 'movie';
    const CATEGORY_TYPE_ALBUM        = 'album';
    const CATEGORY_TYPE_ELEMENTARY   = 'elementary';
    const CATEGORY_TYPE_JUNIOR_HIGH  = 'junior_high';
    const CATEGORY_TYPE_HIGH_SCHOOL  = 'high_school';
    const CATEGORY_TYPE_UNIVERSITY   = 'university';

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('categorylinks');
        $this->displayField('cl_from');
        $this->primaryKey(['cl_from', 'cl_to']);
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
            ->integer('cl_from')
            ->allowEmpty('cl_from', 'create');

        $validator
            ->allowEmpty('cl_to', 'create');

        $validator
            ->requirePresence('cl_sortkey', 'create')
            ->notEmpty('cl_sortkey');

        $validator
            ->dateTime('cl_timestamp')
            ->requirePresence('cl_timestamp', 'create')
            ->notEmpty('cl_timestamp');

        $validator
            ->requirePresence('cl_sortkey_prefix', 'create')
            ->notEmpty('cl_sortkey_prefix');

        $validator
            ->requirePresence('cl_collation', 'create')
            ->notEmpty('cl_collation');

        $validator
            ->requirePresence('cl_type', 'create')
            ->notEmpty('cl_type');

        $validator
            ->integer('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }

    /*******************************************************/
    /* save                                                */
    /*******************************************************/
    public function saveAsQuarkTreated($data)
    {
      $query = $this->findByClFromAndClTo($data->cl_from, $data->cl_to);
      if (!$query || !$query->first()) return false;

      $data->status = self::STATUS_QUARK_TREATED;
      return $this->save($data);
    }

    /*******************************************************/
    /* read                                                */
    /*******************************************************/
    public function getNonTreated($type)
    {
      if ($type == self::CATEGORY_TYPE_PERSON) {
	$where2 = self::wherePerson();
      } elseif ($type == self::CATEGORY_TYPE_MOVIE) {
        $where2 = self::whereMovie();
      } elseif ($type == self::CATEGORY_TYPE_ALBUM) {
        $where2 = self::whereAlbum();
      } elseif ($type == self::CATEGORY_TYPE_ELEMENTARY) {
        $where2 = self::whereElementary();
      } elseif ($type == self::CATEGORY_TYPE_JUNIOR_HIGH) {
        $where2 = self::whereJuniorHigh();
      } elseif ($type == self::CATEGORY_TYPE_HIGH_SCHOOL) {
        $where2 = self::whereHighSchool();
      } elseif ($type == self::CATEGORY_TYPE_UNIVERSITY) {
        $where2 = self::whereUniversity();
      } else return false;

      $where = [self::whereNotTreated(), $where2];
      return $this->find()->where([$where]);
    }

    public function getQuarkTreated($type)
    {
      if ($type == self::CATEGORY_TYPE_ALBUM) {
        $where2 = self::whereAlbumByArtist();
      //} elseif ($type == self::CATEGORY_TYPE_UNIVERSITY) {
      //   $where2 = self::whereUniversity();
      } else return false;

      $where = [self::whereQuarkTreated(), $where2];
      return $this->find()->where([$where]);
    }

    /*******************************************************/
    /* where                                               */
    /*******************************************************/
    public static function whereNotTreated()
    {
      return ['Categorylinks.status' => self::STATUS_NOT_TREATED];
    }
    public static function whereQuarkTreated()
    {
      return ['Categorylinks.status' => self::STATUS_QUARK_TREATED];
    }
    public static function wherePerson()
    {
      return ['Categorylinks.cl_to like' => '%人物'];
    }
    public static function whereMovie()
    {
      return ['Categorylinks.cl_to like' => '%映画'];
    }
    public static function whereAlbum()
    {
      return ['Categorylinks.cl_to like' => '%アルバム'];
    }
    public static function whereAlbumByArtist()
    {
      return [self::whereAlbum(), ['Categorylinks.cl_to not like' => '%年%']];
    }
    public static function whereElementarySchool()
    {
      return ['Categorylinks.cl_to like' => '%の小学校'];
    }
    public static function whereJuniorHigh()
    {
      return ['Categorylinks.cl_to like' => '%の中学校'];
    }
    public static function whereHighSchool()
    {
      return ['Categorylinks.cl_to like' => '%の高等学校'];
    }
    public static function whereUniversity()
    {
      return ['Categorylinks.cl_to like' => '%の大学'];
    }
}
