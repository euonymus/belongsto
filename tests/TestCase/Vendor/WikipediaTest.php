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
	Wikipedia::$internal = true; // in order not to access google search
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
	// test person
	Wikipedia::$contentType = Wikipedia::CONTENT_TYPE_PERSON;
	/* $query = '石田純一'; */
	/* $query = '安倍晋三'; */
	/* $query = '伊東博文'; */
	/* $query = '渡辺謙'; */
	/* $query = '東出昌大'; */
	/* $query = '中川昭一'; */
	$query = '田中角栄';
	$res = Wikipedia::readPageForGluons($query);
	$this->assertSame($res['relatives'][0]['main'], '田中眞紀子');
	$this->assertSame($res['relatives'][0]['relative_type'], '長女');
	$this->assertSame($res['relatives'][0]['source'], 'wikipedia');
	$this->assertSame($res['relatives'][1]['main'], '田中直紀');
	$this->assertSame($res['relatives'][1]['relative_type'], '娘婿');
	$this->assertSame($res['relatives'][1]['source'], 'wikipedia');

	// test movie
	Wikipedia::$contentType = Wikipedia::CONTENT_TYPE_MOVIE;

        //$query = 'アラビアの女王_愛と宿命の日々';
        //$query = '新宿スワン';
        //$query = '本能寺ホテル';
        //$query = 'いしゃ先生';
        $query = '本能寺ホテル';
	$res = Wikipedia::readPageForGluons($query);
	$this->assertSame($res['scenario_writers'][0], '相沢友子');
	$this->assertSame($res['actors'][0], '綾瀬はるか');
	$this->assertSame($res['actors'][1], '堤真一');
	$this->assertSame($res['directors'][0], '鈴木雅之');
      }
    }

    public function testReadPageForQuark()
    {
      if (self::$apitest) {
	$query = '石田純一';
	/* $query = '石田桃子'; */
	/* $query = '佐伯日菜子'; */
	/* $query = '松平信子';   // no infobox, but thumbnail in thumbinner */
	/* $query = '高倉健'; */
	/* $query = '明治天皇'; */
	/* $query = '出澤剛';  // URL in main contents */


	$res = Wikipedia::readPageForQuark($query);
	debug($res);
      }
    }

    public function testReadPageForMovie()
    {
      if (self::$apitest) {
	$query = '本能寺ホテル';
	$query = 'アラビアの女王_愛と宿命の日々';
	$query = '新宿スワン';

	Wikipedia::$contentType = Wikipedia::CONTENT_TYPE_MOVIE;
	$res = Wikipedia::readPageForQuark($query);
	debug($res);
      }
    }
}
