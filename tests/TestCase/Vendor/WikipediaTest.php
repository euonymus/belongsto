<?php
namespace App\Test\TestCase\Vendor;

use Cake\Core\Configure;

use App\Utils\Wikipedia;
use Cake\TestSuite\TestCase;
use Cake\Cache\Cache;

use App\Utils\U;
/**
 * App\Vendor\Wikipedia Test Case
 */
class WikipediaTest extends TestCase
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
	$this->Wikipedia = new Wikipedia;
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Wikipedia);
        parent::tearDown();
    }

    public function testHoge()
    {
      $query = '石田純一';
      $this->Wikipedia->readPage($query);
    }
}
