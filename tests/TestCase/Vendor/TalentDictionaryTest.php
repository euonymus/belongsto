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

    // MEMO: Twitter API callを頻繁にテストで使用したくないのでFalseにしておく。
    //static $apitest = true;
    static $apitest = false;

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

    public function testFilterMatch()
    {
      if (self::$apitest) {
	// Actual read
	$res = TalentDictionary::readPagesOfAllGenerations('default');
	debug($res);
      }

      // Dummy read
      $res = TalentDictionary::dummyReadOfTalentDictionary();
      debug($res);
    }

}
