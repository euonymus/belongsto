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

    public function testReadPageForGluons()
    {
      if (self::$apitest) {
	/* $query = '石田純一'; */
	/* $query = '安倍晋三'; */
	/* $query = '伊東博文'; */
	/* $query = '渡辺謙'; */
	/* $query = '東出昌大'; */
	/* $query = '中川昭一'; */
	$query = '田中角栄';

	$res = Wikipedia::readPageForGluons($query);
	debug($res);
      }
    }

    public function testReadPageForQuark()
    {
      /* $query = '石田純一'; */
      /* $query = '石田桃子'; */
      /* $query = '佐伯日菜子'; */
      /* $query = '松平信子';   // no infobox, but thumbnail in thumbinner */
      /* $query = '高倉健'; */
      /* $query = '明治天皇'; */
      $query = '出澤剛';  // URL in main contents



      $res = Wikipedia::readPageForQuark($query);
      debug($res);
    }
}
