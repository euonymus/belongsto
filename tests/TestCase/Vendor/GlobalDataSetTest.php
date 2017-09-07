<?php
namespace App\Test\TestCase\Vendor;

use Cake\Core\Configure;

use App\Utils\GlobalDataSet;
use Cake\TestSuite\TestCase;
use Cake\Cache\Cache;

use App\Utils\U;
/**
 * App\Vendor\GlobalDataSet Test Case
 */
class GlobalDataSetTest extends TestCase
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
	$this->GlobalDataSet = new GlobalDataSet;
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->GlobalDataSet);
        parent::tearDown();
    }

    public function testIsOlderRelativeType()
    {
      $str = '息子';
      $res = GlobalDataSet::isOlderRelativeType($str);
      $this->assertFalse($res);

      $str = '父';
      $res = GlobalDataSet::isOlderRelativeType($str);
      $this->assertTrue($res);


      $str = '長男';
      $res = GlobalDataSet::isYoungerRelativeType($str);
      $this->assertTrue($res);

      $str = '星川との間の長男';
      $res = GlobalDataSet::isYoungerRelativeType($str);
      $this->assertTrue($res);
    }

}
