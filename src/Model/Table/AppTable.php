<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use Cake\Core\Configure;

class AppTable extends Table
{
    const TABLE_SUBJECT        = 'subjects';
    const TABLE_SUBJECT_SEARCH = 'subject_searches';
    const TABLE_RELATION       = 'relations';

    static $subjects;
    static $subject_searches;
    static $relations;

    public $lang;
    public $lang_eng;

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
	$prefix = '';

	$this->lang = Configure::read('Belongsto.lang');
	$this->lang_eng = Configure::read('Belongsto.lang_eng');
	if ($this->lang != $this->lang_eng) {
	  $prefix = $this->lang . '_';
	}

	self::$subjects         = $prefix . self::TABLE_SUBJECT;
	self::$subject_searches = $prefix . self::TABLE_SUBJECT_SEARCH;
	self::$relations        = $prefix . self::TABLE_RELATION;

        $this->privacyMode = Configure::read('Belongsto.privacyMode');
        $this->auth = Configure::read('Belongsto.auth');
    }

    public function isOwnedBy($id, $userId)
    {
        return $this->exists(['id' => $id, 'user_id' => $userId]);
    }
}
