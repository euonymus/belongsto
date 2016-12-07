<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class AppTable extends Table
{
    const LANG_ENG = 'eng';
    const LANG_JPY = 'jpy';

    static $lang = self::LANG_ENG;

    const TABLE_SUBJECT        = 'subjects';
    const TABLE_SUBJECT_SEARCH = 'subject_searches';
    const TABLE_RELATION       = 'relations';

    static $subjects;
    static $subject_searches;
    static $relations;

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

// if you want to change the language depending on the environments, config here.
self::$lang = self::LANG_JPY;

	if (self::$lang != self::LANG_ENG) {
	  $prefix = self::LANG_JPY . '_';
	}

	self::$subjects         = $prefix . self::TABLE_SUBJECT;
	self::$subject_searches = $prefix . self::TABLE_SUBJECT_SEARCH;
	self::$relations        = $prefix . self::TABLE_RELATION;
    }
}
