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

/*
    public function testGetPassiveRelativeName()
    {
      $str = '息子';
      $res = GlobalDataSet::youngerLabelRelative($str);
      $this->assertFalse($res);

      $str = '父';
      $res = GlobalDataSet::youngerLabelRelative($str);
      debug($res);
    }
*/

}
