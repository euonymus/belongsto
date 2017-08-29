<?php
namespace App\Test\TestCase\Vendor;

use Cake\Core\Configure;

use App\Utils\GoogleSearch;
use Cake\TestSuite\TestCase;
use Cake\Cache\Cache;
/**
 * App\Vendor\GoogleSearch Test Case
 */
class GoogleSearchTest extends TestCase
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
	$this->GoogleSearch = new GoogleSearch;
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->GoogleSearch);
        parent::tearDown();
    }

    public function testHoge()
    {
      if (self::$apitest) {
	$query = 'とくだね';
	$res = GoogleSearch::getFirstImageFromImageSearch($query);
	debug($res);
      }
    }
}
