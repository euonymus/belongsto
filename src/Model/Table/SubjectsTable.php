<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use Cake\ORM\TableRegistry;
use Cake\Network\Http\Client;
use Cake\Cache\Cache;

use App\Model\Table\SubjectSearchesTable;
use Cake\Datasource\Exception\RecordNotFoundException;

use App\Utils\U;
use App\Utils\NgramConverter;

/**
 * Subjects Model
 *
 * @property \Cake\ORM\Association\HasMany $Relations
 *
 * @method \App\Model\Entity\Subject get($primaryKey, $options = [])
 * @method \App\Model\Entity\Subject newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Subject[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Subject|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Subject patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Subject[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Subject findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SubjectsTable extends AppTable
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

        $this->hasOne('SubjectSearches', [
            'className'  => 'SubjectSearches',
	    'foreignKey' => 'id',
	    'dependent' => true,
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('LastModifiedUsers', [
            'propertyName' => 'last_modified_user',
            'foreignKey' => 'last_modified_user',
            'joinType' => 'INNER'
        ]);

	$this->belongsToManyPassives();
	$this->belongsToManyActives();
    }

    public function belongsToManyPassives()
    {
        $options = [
            'through' => 'Relations',
            'foreignKey' => 'active_id',
            'sort' => ['Relations.order_level' => 'ASC', 'Relations.start' => 'DESC', 'Relations.end' => 'DESC'],
        ];

	$Passives = TableRegistry::get('Passives');
	$conditions = $Passives->wherePrivacy();
	$options['conditions'] = $conditions;

        $this->belongsToMany('Passives', $options);
    }
    public function belongsToManyActives()
    {
        $options = [
            'through' => 'Relations',
            'foreignKey' => 'passive_id',
            'sort' => ['Relations.order_level' => 'ASC', 'Relations.start' => 'DESC', 'Relations.end' => 'DESC'],
        ];

	$Actives = TableRegistry::get('Actives');
	$conditions = $Actives->wherePrivacy();
	$options['conditions'] = $conditions;

        $this->belongsToMany('Actives', $options);
    }




    public function formToEntity($arr)
    {
      $ret = $this->newEntity($arr);
      $ret->id = U::buildGuid(); // varchar 36 フィールドのinsertには必要。
      return $ret;
    }
    public static function addImageBySearch($data)
    {
      if (!empty($data->image_path)) return $data;
      if (empty($data->name)) return $data;

      $image_path = self::simpleGetImageUrl($data->name);
      if (!$image_path) return $data;
      $data->image_path = $image_path;
      return $data;
    }
    public function patchSearchOnData($data)
    {
      $arr = $data->toArray();
      $arr['subject_search'] = self::composeSearchArr($data);
      $ret = $this->newEntity($arr, ['associated' => ['SubjectSearches']]);
      $ret->id = $data->id;
      return $ret;
    }
    public static function composeSearchArr($data)
    {
      if (!is_object($data)) return false;
      $search_words = self::bigramize($data->name . ' ' . $data->description);
      if (!$search_words) return false;
      $ret = ['id' => $data->id, 'search_words' => $search_words];
      return $ret;
    }

    public function formToSaving($form)
    {
      if (!is_array($form)) return false;
      $data = $this->formToEntity($form);
      return $this->prepareForSave($data);
    }
    public function formToEditing($data, $form)
    {
      if (!is_array($form)) return false;
      $data = $this->patchEntity($data, $form);
      return $this->prepareForSave($data);
    }
    public function prepareForSave($data)
    {
      $data = self::addImageBySearch($data);
      return $this->patchSearchOnData($data);
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

        $validator
            ->allowEmpty('url');

        $validator
            ->allowEmpty('affiliate');

        return $validator;
    }

    /****************************************************************************/
    /* Edit Data                                                                */
    /****************************************************************************/

    /****************************************************************************/
    /* Get Data                                                                 */
    /****************************************************************************/
    public function getRelations($id, $contain = NULL, $level = 1, $second_type = null)
    {
      if (!is_numeric($level) || ($level > 2)) return false;

      $options = [];

      if (is_array($contain)) $contain[] = 'LastModifiedUsers';
      else $contain = ['LastModifiedUsers'];

      if (($level != 0) && !is_null($contain)) {
	$options = ['contain' => $contain];
      }

      //$subject = $this->get($id, $options);
      $query = $this->find()->contain($contain);


      $where = $this->wherePrivacyId($id);

      $query = $query->where($where);
      $subject = $query->first();
      if (empty($subject)) {
	throw new RecordNotFoundException('Record not found in table "subjects"');
      }

      // 2nd level type
      if (($level == 2) && !is_null($contain)) {
	if ($second_type == 'none') {
	  $level = 1;
	} elseif ($second_type == 'passive') {
	  $relationKey = 'passive_id';
 	  $secondModel = 'Actives';
	} else {
	  $relationKey = 'active_id';
	  $secondModel = 'Passives';
	}
      }

      // 2nd level relations
      if (($level == 2) && !is_null($contain)) {
	for($i = 0; count($subject->actives) > $i; $i++) {
	  $Relations = TableRegistry::get('Relations');
	  $subject->actives[$i]->relation
	    = $Relations->find('all', ['contain' => $secondModel])->where([$relationKey => $subject->actives[$i]->id]);
	}
	for($i = 0; count($subject->passives) > $i; $i++) {
	  $Relations = TableRegistry::get('Relations');
	  $subject->passives[$i]->relation
	    = $Relations->find('all', ['contain' => $secondModel])->where([$relationKey => $subject->passives[$i]->id]);
	}
      }
      return $subject;
    }

    public function search($search_words, $limit = 20)
    {
      $expr = self::bigramize($search_words);

      $whereSearch = "MATCH(SubjectSearches.search_words) AGAINST(:search)";
      $where = [$this->wherePrivacy(), $whereSearch];
      $query = $this
	->find('all')
	->contain(['SubjectSearches', 'Actives'])
	->matching('SubjectSearches')
        ->where($where)
	->bind(":search", $expr);

      if (is_numeric($limit)) {
	$query = $query->limit($limit);
      }

      return $query;
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
      return ['Subjects.id' => $id];
    }

    public static function wherePublic()
    {
      return ['Subjects.is_private' => false];
    }
    public static function wherePrivate($user_id)
    {
      return ['Subjects.is_private' => true, 'Subjects.user_id' => $user_id];
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
      return ['Subjects.id' => false];
    }

    /****************************************************************************/
    /* Tools                                                                    */
    /****************************************************************************/
    public static function bigramize($str)
    {
      return NgramConverter::to_query($str, 2);
    }

    /****************************************************************************/
    /* API call                                                                 */
    /****************************************************************************/
    public static $retrieveCacheConfig = 'default';
    public static function buildCacheKey($keywords)
    {
      return 'image_search_api_'.$keywords;
    }
    public static function simpleGetImageUrl($keywords)
    {
      $response = self::cachedSearchImage($keywords);
      if (!$response) return false;

      foreach($response->value as $value) {
	return $value->thumbnailUrl;
      }
      return false;
    }
    public static function cachedSearchImage($keywords)
    {
      $cached = Cache::read(self::buildCacheKey($keywords), self::$retrieveCacheConfig);
      if ($cached) return $cached;

      $images = self::searchImage($keywords);
      if (!$images) return false;
      Cache::write(self::buildCacheKey($keywords), $images, self::$retrieveCacheConfig);

      return $images;
    }
    public static function searchImage($keywords)
    {
      $response = self::callSearchImage($keywords);
      if (!$response) return false;

      $json = $response->body();
      return json_decode($json);
    }
    public static function callSearchImage($keywords)
    {
	require_once(ROOT . DS . 'config' . DS . 'secrets.php');
        $ms_key = getenv('MS_KEY');
	$endpoint = 'https://api.cognitive.microsoft.com/bing/v5.0/images/search';

	// Settings
	$headers = ['Content-Type' => 'multipart/form-data',
		    'Ocp-Apim-Subscription-Key' => $ms_key];
	$datas = ['q' => $keywords, 'license' => 'Share'];

	// Preparation of Http Client
	$http = new Client();
	$response = $http->get($endpoint, $datas, ['headers' => $headers]);
	if (!$response->isOk()) return false;
	return $response;
    }

}
