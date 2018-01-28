<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use Cake\ORM\TableRegistry;
use Cake\Network\Http\Client;
use Cake\Cache\Cache;

use App\Model\Entity\Subject;
use App\Model\Table\SubjectSearchesTable;
use App\Model\Table\CategorylinksTable;

use Cake\Network\Exception\NotFoundException;

use App\Utils\U;
use App\Utils\NgramConverter;
use App\Utils\Wikipedia;
use App\Utils\TalentDictionary;
use App\Utils\GoogleSearch;

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
    const IMG_PATH_PERSON     = '/img/person.png';
    const IMG_PATH_COMPANY    = '/img/company.png';
    const IMG_PATH_MOVIE      = '/img/movie.png';
    const IMG_PATH_MUSIC      = '/img/music.png';
    const IMG_PATH_MUSIC_BAND = '/img/music_band.png';
    const IMG_PATH_SCHOOL     = '/img/school.png';
    const IMG_PATH_UNIVERSITY = '/img/university.png';

    // relation btw subjects and categorylinks
    public static $img_path_list = [
				    CategorylinksTable::CATEGORY_TYPE_PERSON      => self::IMG_PATH_PERSON,
				    CategorylinksTable::CATEGORY_TYPE_MOVIE       => self::IMG_PATH_MOVIE,
				    CategorylinksTable::CATEGORY_TYPE_ALBUM       => self::IMG_PATH_MUSIC,
				    CategorylinksTable::CATEGORY_TYPE_ELEMENTARY  => self::IMG_PATH_SCHOOL,
				    CategorylinksTable::CATEGORY_TYPE_JUNIOR_HIGH => self::IMG_PATH_SCHOOL,
				    CategorylinksTable::CATEGORY_TYPE_HIGH_SCHOOL => self::IMG_PATH_SCHOOL,
				    CategorylinksTable::CATEGORY_TYPE_UNIVERSITY  => self::IMG_PATH_UNIVERSITY,
				    ];

    public static $relative_collected_non  = 0;
    public static $relative_collected_done = 1;
    public static $relative_collected_fail = 2;
    public static $cachedRead = false;

    public static $internal = false;

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
	$this->belongsTo('QuarkTypes', [
            'foreignKey' => 'quark_type_id',
        ]);
	// These are the properties the quark type contains through gluon
        $this->belongsToMany('QuarkProperties', [
	    'through' => 'QtypeProperties',
	    // somehow foreignKey, bindingKey both are needed to be quark_type_id
            'foreignKey' => 'quark_type_id',
            'bindingKey' => 'quark_type_id',
        ]);

	$this->belongsToManyPassives();
	$this->belongsToManyActives();
    }

    public function belongsToManyPassives()
    {
        $options = [
            'through' => 'Relations',
            'foreignKey' => 'active_id',
            'sort' => ['Relations.order_level' => 'ASC', 'Relations.start' => 'DESC', 'Relations.end' => 'DESC',
		       'Passives.start' => 'DESC'],
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
            'sort' => ['Relations.order_level' => 'ASC', 'Relations.start' => 'DESC', 'Relations.end' => 'DESC',
		       'Actives.start' => 'DESC'],
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
      if (!$data->auto_fill) {
	$QuarkTypes = TableRegistry::get('QuarkTypes');
	if (empty($data->quark_type_id)) $data->quark_type_id = 1;
	$quark_type = $QuarkTypes->get($data->quark_type_id);
	$data->image_path = $quark_type->image_path;
	return $data;
      }
      if (self::$internal) return $data;

      $res = GoogleSearch::getFirstImageFromImageSearch($data->name);
      $image_path = ($res && (strlen($res) <= 255)) ? $res : NULL;
      //$image_path = self::simpleGetImageUrl($data->name);
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

    public function botToSaving($arr)
    {
      if (!is_array($arr)) return false;
      $arr['is_private']   = false;
      $arr['is_exclusive'] = true;
      $arr['user_id']      = 1;
      return $this->formToSaving($arr);
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
    // $filling arr: single retrieved data from foreign site
    // $existing obj: single record to update.
    public function fillMissingData($filling, $existing)
    {
      if (!$existing || !is_object($existing)) return false;

      // sanitization
      $filling_name = self::removeAllSpaces($filling['name']);
      $existing_name = self::removeAllSpaces($existing->name);
      if (strcasecmp($filling_name, $existing_name) !== 0) return false;
      // never update private record automatically
      if ($existing->is_private) return false;

      // Start choosing filling data
      $ret = [];
      if (empty($existing->image_path) && array_key_exists('image_path', $filling) && !empty($filling['image_path'])) {
	$ret['image_path'] = $filling['image_path'];
      }
      if (empty($existing->description) && array_key_exists('description', $filling) && !empty($filling['description'])) {
	$ret['description'] = $filling['description'];
      }
      if (empty($existing->url) && array_key_exists('url', $filling) && !empty($filling['url'])) {
	$ret['url'] = $filling['url'];
      }

      $new_date     = array_key_exists('start', $filling) ? $filling['start'] : false;
      $new_accuracy = array_key_exists('start_accuracy', $filling) ? $filling['start_accuracy'] : false;
      $datePair = self::chooseMoreAccurateDatePair($existing->start, $existing->start_accuracy,
						   $new_date, $new_accuracy);
      if (array_key_exists('date', $datePair)) {
	$ret['start'] = $datePair['date'];
	if (array_key_exists('accuracy', $datePair)) {
	  $ret['start_accuracy'] = $datePair['accuracy'];
	}
      }

      $new_date     = array_key_exists('end', $filling) ? $filling['end'] : false;
      $new_accuracy = array_key_exists('end_accuracy', $filling) ? $filling['end_accuracy'] : false;
      $datePair = self::chooseMoreAccurateDatePair($existing->end, $existing->end_accuracy,
						   $new_date, $new_accuracy);
      if (array_key_exists('date', $datePair)) {
	$ret['end'] = $datePair['date'];
	if (array_key_exists('accuracy', $datePair)) {
	  $ret['end_accuracy'] = $datePair['accuracy'];
	}
      }

      if (array_key_exists('is_momentary', $filling) && !is_null($filling['is_momentary'])) {
	$ret['is_momentary'] = $filling['is_momentary'];
      }

      if (array_key_exists('is_person', $filling) && !is_null($filling['is_person'])) {
	$ret['is_person'] = $filling['is_person'];
      }

      if (array_key_exists('wikipedia_sourced', $filling) && !empty($filling['wikipedia_sourced'])) {
	$ret['wikipedia_sourced'] = $filling['wikipedia_sourced'];
      }
      if (array_key_exists('t_dictionary_sourced', $filling) && !empty($filling['t_dictionary_sourced'])) {
	$ret['t_dictionary_sourced'] = $filling['t_dictionary_sourced'];
      }
      if (array_key_exists('wid', $filling) && !empty($filling['wid'])) {
	$ret['wid'] = $filling['wid'];
      }

      if (array_key_exists('created', $filling) && !empty($filling['created'])) {
	$ret['created'] = $filling['created'];
      }
      if (array_key_exists('modified', $filling) && !empty($filling['modified'])) {
	$ret['modified'] = $filling['modified'];
      }

      if (empty($ret)) return false;
      return $ret;
    }

    public static function chooseMoreAccurateDatePair($existing_date, $existing_accuracy, $new_date, $new_accuracy)
    {
      $ret = [];
      if (empty($existing_date) && $new_date) {
	$ret['date'] = $new_date;
	if (empty($existing_accuracy) && $new_accuracy) {
	  $ret['accuracy'] = $new_accuracy;
	}
      } elseif ((($existing_accuracy == 'month' && empty($new_accuracy))
		 || ($existing_accuracy == 'year'))
		&& $new_date) {
	$ret['date'] = $new_date;
	$ret['accuracy'] = !!$new_accuracy ? $new_accuracy : '';
      }
      return $ret;
    }

    /****************************************************************************/
    /* Get Data                                                                 */
    /****************************************************************************/
    public function getRelationsByName($name, $contain = NULL, $level = 1, $second_type = null, $baryon_id = NULL)
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
      if (self::$cachedRead) {
	$query = $query->cache('Subject_' . $this->lang . '_' . $level . '_' . $name);
      }

      //$where = $this->wherePrivacyId($id);
      $where = $this->wherePrivacyName($name);

      $query = $query->where($where);
      $subject = $query->first();
      if (empty($subject)) {
	throw new NotFoundException('Record not found in table "subjects"');
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
	  $where2 = [$relationKey => $subject->actives[$i]->id];
	  if ($baryon_id !== false) {
	    if (is_null($baryon_id)) {
	      $where2[] = 'baryon_id is NULL';
	    } else {
	      $where2[] = ['baryon_id' => $baryon_id];
	    }
	  }

	  $Relations = TableRegistry::get('Relations');
	  $query2 = $Relations->find('all', ['contain' => $secondModel]);
	  if (self::$cachedRead) {
	    $query2 = $query2->cache('actives_' . $this->lang . '_' . $second_type . '_' . $subject->actives[$i]->id);
	  }
	  $subject->actives[$i]->relation
	    = $query2->where($where2)->order(['Relations.start' =>'DESC']);
	}
	for($i = 0; count($subject->passives) > $i; $i++) {
	  $where2 = [$relationKey => $subject->passives[$i]->id];
	  if ($baryon_id !== false) {
	    if (is_null($baryon_id)) {
	      $where2[] = 'baryon_id is NULL';
	    } else {
	      $where2[] = ['baryon_id' => $baryon_id];
	    }
	  }

	  $Relations = TableRegistry::get('Relations');
	  $query3 = $Relations->find('all', ['contain' => $secondModel]);
	  if (self::$cachedRead) {
	    $query3 = $query3->cache('passives_' . $this->lang . '_' . $second_type . '_' . $subject->passives[$i]->id);
	  }
	  $subject->passives[$i]->relation
	    = $query3->where($where2)->order(['Relations.start' =>'DESC']);
	}
      }
      return $subject;
    }

    // lang, lang_eng, privacyMode 設定しないと検索できないので注意
    // 例
    // Configure::write('Belongsto.lang',     'ja');
    // Configure::write('Belongsto.lang_eng', 'eng');
    // Configure::write('Belongsto.privacyMode', 1);
    public function search($search_words, $limit = 20)
    {
      $expr = self::bigramize($search_words);

      $whereSearch = "MATCH(SubjectSearches.search_words) AGAINST(:search)";
      $where = [$this->wherePrivacy(), $whereSearch];
      $query = $this->find('all');

      if (self::$cachedRead) {
	$query = $query->cache('Subjects_' . $this->lang . '_' . $search_words);
      }
      $query = $query
	->contain(['SubjectSearches', 'Actives'])
	->matching('SubjectSearches')
        ->where($where)
	->bind(":search", $expr);

      if (is_numeric($limit)) {
	$query = $query->limit($limit);
      }

      return $query;
    }

    public static $escapeForTest = false;
    // findByNameだとスペース区切りの違いで取得できない場合があるのでわざわざsearch()から取得する
    public function getOneWithSearch($str)
    {
      //// MEMO: 本当は search() だけど、phpunit testできないためfindByNameでテスト中。
      //if (self::$escapeForTest) {
      //	$existings = $this->findByName($str);
      //} else {
      //	$existings = $this->search($str, 100);
      //}
      //return $this->findTargetFromSearchedData($str, $existings);
      return $this->findByName($str)->first();
    }

    // 文字列の名前のデータがあれば取得、なければWikipediaから取得、Wikipediaにもなければ名前だけでsaveして取得
    public function forceGetQuark($str)
    {
      $data = $this->getOneWithSearch($str);
      if (is_array($data)) return false; // If there are many records matches, system can't detect which, so returns false.
      if ($data) return $data;

      $res = $this->insertInfoFromWikipedia($str);
      if ($res) return $res;

      $arr = ['name' => $str, 'is_momentary' => false];
      return $this->saveBotArray($arr);
    }

    /*******************************************************/
    /* Save Data                                           */
    /*******************************************************/
    public function saveNewArray($arr)
    {
      if (!is_array($arr) || !array_key_exists('name', $arr)) return false;
      //$filling_name = self::removeAllSpaces($arr['name']);
      $filling_name = $arr['name'];

      $existing = self::getOneWithSearch($filling_name);
      if (is_array($existing)) return false; // If there are many records matches, system can't detect which, so returns false.
      if ($existing) {
	return $this->saveToFillEmptyField($existing, $arr);
      } else {
	return $this->saveBotArray($arr);
      }
      return false;
    }

    public function saveBotArray($arr)
    {
      $saving = $this->botToSaving($arr);
      $saving->last_modified_user = 1; // static
      return $this->save($saving);
    }

    public function saveToFillEmptyField($data, $arr)
    {
      $filling = self::fillMissingData($arr, $data);
      if (!$filling) return false;

      $saving = $this->formToEditing($data, $filling);
      $saving->last_modified_user = 1; // static
      return $this->save($saving);
    }

    /*******************************************************/
    /* where                                               */
    /*******************************************************/
    public function wherePrivacyId($id)
    {
      return [self::whereId($id), self::wherePrivacy()];
    }
    public function wherePrivacyName($name)
    {
      return [self::whereName($name), self::wherePrivacy()];
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
    public static function whereName($name)
    {
      return ['Subjects.name' => $name];
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
    public static function whereIsPerson($bool = true)
    {
      return ['Subjects.is_person' => $bool];
    }


    public static function whereNoQuarkTypeId()
    {
      return ['Subjects.quark_type_id is NULL'];
    }
    public static function whereAllRecord()
    {
      return ['1' => '1'];
    }
    public static function whereNoRecord()
    {
      return ['Subjects.id' => false];
    }

    /*******************************************************/
    /* quarks                                              */
    /*******************************************************/
    public function retrieveAndSaveTalents($generation, $page)
    {
      $talents = TalentDictionary::readPage($generation, $page);
      foreach($talents as $saving) {
	$res = $this->saveNewArray($saving);
debug($res);
      }
    }

    /*******************************************************/
    /* gluons                                              */
    /*******************************************************/
    public function findAndSaveRelatives($limit = 10)
    {
      $datas = $this->findByRelativeCollectedAndIsPerson(self::$relative_collected_non, true)->limit($limit);
      if (!$datas) return false;

      foreach ($datas as $val) {
	//debug($val->toArray());
	// checkRules = falseとしないとrelationsの保存に失敗するのでしかたなく。
	$options = ['checkRules' => false];
	$res = $this->Relations->saveGluonsFromWikipedia($val, $options);
	if (!$res) {
	  $val->relative_collected = self::$relative_collected_fail;
	  $this->save($val);
	  continue;
	}

	$val->relative_collected = self::$relative_collected_done;
	$saved = $this->save($val);
      }
      return true;
    }

    public function buildGluonWithCategorylink($type)
    {
      $Categorylinks = TableRegistry::get('Categorylinks');
      $data = self::getCategorylistQuarkTreated($type);
      if (!$data) return false;


// TODO: still working
      $passiveName = preg_replace('/の(?!.*の).+$/', '', $data->cl_to);
      debug($passiveName);

      $activeWid = $data->cl_from;
      debug($activeWid);
    }

    /****************************************************************************/
    /* Tools                                                                    */
    /****************************************************************************/
    public static function bigramize($str)
    {
      return NgramConverter::to_query($str, 2);
    }

    // remove all the spaces.
    // this will remove all the spaces, even in between the strings.
    public static function removeAllSpaces($str, $includeIdeographicSpace = true)
    {
      return U::removeAllSpaces($str, $includeIdeographicSpace);
    }

    // $name: name of the quark
    // $existings obj: multiple records found by search function.
    public function findTargetFromSearchedData($name, $existings)
    {
      // sanitization
      $name = self::removeAllSpaces($name);

      $candidates = [];
      foreach($existings as $existing) {
      	// sanitization
      	$comparison = self::removeAllSpaces($existing->name);
	if (strcmp($name, $comparison) === 0) {
	  $candidates[] = $existing;
	}
      }
      //if (count($candidates) == 1) return $candidates[0];
      if (count($candidates) == 1) {
	return $candidates[0];
      } elseif (count($candidates) > 1) {
	return $candidates;
      }
      return false;
    }

    /****************************************************************************/
    /* API call                                                                 */
    /****************************************************************************/
    /** MS Image API **/
    /*
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
    */

    /****************************************************************************/
    /* Wikipedia                                                                */
    /****************************************************************************/
    public function insertInfoFromWikipedia($txt, $type = NULL)
    {
      $existing = $this->getOneWithSearch($txt);
      if ($existing) return false;

      //$query = self::removeAllSpaces($txt);
      $query = str_replace(' ', '_', $txt);
      if (!$query) return false;

      // check if there is $type
      if (in_array($type, Subject::$typeListHuman)) {
	Wikipedia::$contentType = Wikipedia::CONTENT_TYPE_PERSON;
      } elseif (in_array($type, Subject::$typeListBooks)) {
	Wikipedia::$contentType = Wikipedia::CONTENT_TYPE_BOOK;
      } elseif (in_array($type, Subject::$typeListMangas)) {
	Wikipedia::$contentType = Wikipedia::CONTENT_TYPE_MANGA;
      }

      $res = Wikipedia::readPageForQuark($query);
      if (!$res || !is_array($res) || !array_key_exists('name', $res)) return false;

      // check if it's already there.
      $data = $this->getOneWithSearch($res['name']);
      if ($data) return false;

      // check if there is $type. I know it is redundant
      $res['is_person'] = Subject::isPersonByType($type);
      if (Subject::momentaryByType($type)) {
	$res['is_momentary'] = true;
	$res['end']          = NULL;
	$res['end_accuracy'] = NULL;
      }
// TODO
debug($res);
      return $this->saveBotArray($res);
    }
    public function updateInfoFromWikipedia($data)
    {
      //$query = self::removeAllSpaces($data->name);
      $query = str_replace(' ', '_', $data->name);
      if (!$query) return false;

      $res = Wikipedia::readPageForQuark($query);
      return $this->saveToFillEmptyField($data, $res);
    }

    public function retrieveAndSaveMovie($query)
    {
      // avoiding movie
      if (strcmp($query, '青いパパイヤの香り') == 0) return false;
      if (strcmp($query, 'グッド・ウィル・ハンティング/旅立ち') == 0) return false;
      if (strcmp($query, 'プレッジ') == 0) return false;
      if (strcmp($query, 'リダクテッド_真実の価値') == 0) return false;
      if (strcmp($query, 'ニューヨーク、アイラブユー') == 0) return false;
      if (strcmp($query, '100,000年後の安全') == 0) return false;
      if (strcmp($query, '黒騎士_(1952年の映画)') == 0) return false;
      Wikipedia::$contentType = Wikipedia::CONTENT_TYPE_MOVIE;
      $data = $this->insertInfoFromWikipedia($query);
      if (!$data) return false;

      // checkRules = falseとしないとrelationsの保存に失敗するのでしかたなく。
      $options = ['checkRules' => false];
      return $this->Relations->saveGluonsFromWikipedia($data, $options);
    }

    /****************************************************************************/
    /* Wikipedia Oriented Tables                                                */
    /****************************************************************************/
    public function saveFromPages()
    {
      $Pages = TableRegistry::get('Pages');
      $where = $Pages->whereViableMigrationCandidates();
      $page = $Pages->find()->where([$where])->first();

      // call api
      $arr = Wikipedia::readApiForQuark($page->page_title);
      if (!$arr) {
	$page->is_treated = true;
	$savedPage = $Pages->save($page);
	return true;
      }

      $arr['created'] = '2016-11-01 00:00:00';
      $arr['modified'] = '2016-11-01 00:00:00';

      // google 画像は取得しない
      self::$internal = true;
      $saved = $this->saveNewArray($arr);
      if (!$saved) {
	$page->is_treated = true;
	$savedPage = $Pages->save($page);
	return true;
      }

      $page->is_treated = true;
      $savedPage = $Pages->save($page);
      if (!$savedPage) return false;

      debug($saved);
      return $saved;
    }

    public function updateWithCategorylink($type)
    {
      $Categorylinks = TableRegistry::get('Categorylinks');
      $data = self::getNonTreated($type);
      if (!$data) return false;

      $arr = ['id' => $data->id];
      $arr['name'] = $data->name;
      $arr['image_path'] = self::$img_path_list[$type];
      if ($type == CategorylinksTable::CATEGORY_TYPE_PERSON) {
	$arr['is_person'] = true;
      }

      // google 画像は取得しない
      self::$internal = true;
      $saved = $this->saveToFillEmptyField($data, $arr);
      if (!$saved) return false;

      debug($saved);
      return $saved;
    }

    public function getNonTreated($type)
    {
      $Categorylinks = TableRegistry::get('Categorylinks');
      $cl_query = $Categorylinks->getNonTreated($type);
      // $cl_query はでかすぎて foreach できない。
      if (!$cl_query || !($categorylink = $cl_query->first())) return false;

      // 処理しきったかどうか判断できないので、この時点ですぐquark_treatedにしてしまう。
      $res = $Categorylinks->saveAsQuarkTreated($categorylink);
      if (!$res) return false;

      $data = $this->findByWid($categorylink->cl_from);
      if (!$data->first()) return false;

      return $data->first();
    }

    public function getCategorylistQuarkTreated($type)
    {
      $Categorylinks = TableRegistry::get('Categorylinks');
      $cl_query = $Categorylinks->getQuarkTreated($type);
      // $cl_query はでかすぎて foreach できない。
      if (!$cl_query || !($categorylink = $cl_query->first())) return false;


/*       // 処理しきったかどうか判断できないので、この時点ですぐquark_treatedにしてしまう。 */
/*       $res = $Categorylinks->saveAsQuarkTreated($categorylink); */
/* debug(__LINE__); */
/*       if (!$res) return false; */

      return $categorylink;
    }

}
