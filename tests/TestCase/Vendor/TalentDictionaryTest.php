<?php
namespace App\Test\TestCase\Vendor;

use Cake\Core\Configure;

use App\Utils\TalentDictionary;
use Cake\TestSuite\TestCase;
use Cake\Cache\Cache;

use App\Utils\U;
/**
 * App\Vendor\TalentDictionary Test Case
 */
class TalentDictionaryTest extends TestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
	$this->TalentDictionary = new TalentDictionary;
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TalentDictionary);
        parent::tearDown();
    }

    // Dummy function for TalentDictionary::readPagesOfAllGenerations('default')
    public static function dummyReadOfTalentDictionary()
    {
      $path = ROOT .DS. "tests" . DS . "DummyData" . DS . "talent_dictionary.html";
      $element = '//div[contains(@class,"main")]/div[contains(@class,"home_talent_list_wrapper")]/ul/li';
      $res = U::getXpathFromUrl($path, $element);

      // record loop
      $ret = [];
      foreach ($res as $val) {
	$rec = TalentDictionary::constructData($val->div->div);
	if (!$rec) continue;
	$ret[] = $rec;
      }
      return $ret;
    }

    public function testFilterMatch()
    {
      // Actual read
      $res = TalentDictionary::readPagesOfAllGenerations('default');
      debug($res);

      // Dummy read
      $res = self::dummyReadOfTalentDictionary();
      debug($res);
    }

}
