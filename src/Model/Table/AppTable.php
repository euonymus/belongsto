<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use App\Utils\U;

class AppTable extends Table
{
    const LANG_ENG = 'en';
    const LANG_JPY = 'jp';
    static $langs = [
      self::LANG_ENG,
      self::LANG_JPY,
    ];

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

	$subdomain = U::getSubdomain();
	if (in_array($subdomain, self::$langs)) {
	  self::$lang = $subdomain;
	}

	if (self::$lang != self::LANG_ENG) {
	  $prefix = self::$lang . '_';
	}

	self::$subjects         = $prefix . self::TABLE_SUBJECT;
	self::$subject_searches = $prefix . self::TABLE_SUBJECT_SEARCH;
	self::$relations        = $prefix . self::TABLE_RELATION;
    }

}
