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


	$query = 'アルベルト・アインシュタイン';
	$res = Wikipedia::readPageForGluons($query);
	$this->assertSame($res['relatives'][0]['main'], 'リーゼル');
	$this->assertSame($res['relatives'][0]['relative_type'], '子供');
	$this->assertSame($res['relatives'][1]['main'], 'ハンス・アルベルト');
	$this->assertSame($res['relatives'][1]['relative_type'], '子供');
	$this->assertSame($res['relatives'][2]['main'], 'エドゥアルト');
	$this->assertSame($res['relatives'][2]['relative_type'], '子供');

	// test movie
	Wikipedia::$contentType = Wikipedia::CONTENT_TYPE_MOVIE;

        //$query = 'アラビアの女王_愛と宿命の日々';
        //$query = '新宿スワン';
        //$query = 'いしゃ先生';
        $query = '本能寺ホテル';
	$res = Wikipedia::readPageForGluons($query);
	$this->assertSame($res['scenario_writers'][0], '相沢友子');
	$this->assertSame($res['actors'][0], '綾瀬はるか');
	$this->assertSame($res['actors'][1], '堤真一');
	$this->assertSame($res['directors'][0], '鈴木雅之');


        $query = '白鯨との闘い';
	$res = Wikipedia::readPageForGluons($query);
	$this->assertSame($res['scenario_writers'][0], 'チャールズ・リーヴィット');
	$this->assertSame($res['original_authors'][0], 'ナサニエル・フィルブリック');
	$this->assertSame($res['directors'][0], 'ロン・ハワード');
	$this->assertSame($res['actors'][0], 'クリス・ヘムズワース');
	$this->assertSame($res['actors'][1], 'ベンジャミン・ウォーカー');
	$this->assertSame($res['actors'][2], 'キリアン・マーフィー');
	$this->assertSame($res['actors'][3], 'トム・ホランド');
	$this->assertSame($res['actors'][4], 'ベン・ウィショー');
	$this->assertSame($res['actors'][5], 'ブレンダン・グリーソン');
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


	Wikipedia::$contentType = Wikipedia::CONTENT_TYPE_PERSON;
	$res = Wikipedia::readPageForQuark($query);
	debug($res);

	// test for reading firstHeading h1
	Wikipedia::$contentType = Wikipedia::CONTENT_TYPE_MOVIE;
        $query = 'アラビアの女王_愛と宿命の日々';
	$res = Wikipedia::readPageForQuark($query);
	$this->assertSame($res['name'], 'アラビアの女王 愛と宿命の日々');
      }
    }

    public function testReadPageForMovie()
    {
      if (self::$apitest) {
	$query = '新宿スワン';

	Wikipedia::$contentType = Wikipedia::CONTENT_TYPE_MOVIE;
	$res = Wikipedia::readPageForQuark($query);
	debug($res);
      }
    }

    public function testParseRelative()
    {
      //$query = '中川昭一';
      //$res = Wikipedia::readPageForGluons($query);
      //debug($res);

      $str = 'あああ（父）'; // 石田純一
      $res = Wikipedia::parseRelative($str);
      $this->assertSame($res['main'], 'あああ');
      $this->assertSame($res['relative_type'], '父');

      $str = 'あああ（父）[要出典]'; // 武井証
      $res = Wikipedia::parseRelative($str);
      $this->assertSame($res['main'], 'あああ');
      $this->assertSame($res['relative_type'], '父');

      $str = '父・あああ'; // 田中角栄
      $res = Wikipedia::parseRelative($str);
      $this->assertSame($res['main'], 'あああ');
      $this->assertSame($res['relative_type'], '父');

      $str = '父・あああ（参議院議員）'; // 中川昭一
      $res = Wikipedia::parseRelative($str);
      $this->assertSame($res['main'], 'あああ');
      $this->assertSame($res['relative_type'], '父');

      $str = 'あああ・いいい（父）';
      $res = Wikipedia::parseRelative($str);
      $this->assertSame($res['main'], 'あああ・いいい');
      $this->assertSame($res['relative_type'], '父');

      $str = '父：あああ（俳優）'; // 佐久間良子
      $res = Wikipedia::parseRelative($str);
      $this->assertSame($res['main'], 'あああ');
      $this->assertSame($res['relative_type'], '父');

      $str = 'あああ・いいい・ううう（英語版）（父）'; // デイヴィッド・ロックフェラー
      $res = Wikipedia::parseRelative($str);
      $this->assertSame($res['main'], 'あああ・いいい・ううう');
      $this->assertSame($res['relative_type'], '父');

      // このケースは識別不能：子と長女どちらを採用するかわからないのと、長女をrelative_typeとした場合も子とあああのどちらが名前か判別できない
      //$str = '子（長女）：あああ'; // 野村萬斎
      //$res = Wikipedia::parseRelative($str);
      //$this->assertSame($res['main'], 'あああ');
      //$this->assertSame($res['relative_type'], '長女');
    }

    public function testCall()
    {
      if (self::$apitest) {
	$option = [
		   'action' => 'query',
		   'titles' => 'エマ・ワトソン',
		   'prop' => 'revisions',
		   'rvprop' => 'content',
		   ];

	$res = Wikipedia::call($option);
	//debug((string)$res->query->pages->page->revisions->rev);
	$this->assertSame((int)$res->query->pages->page->attributes()->pageid, 128948);
	$this->assertSame((string)$res->query->pages->page->attributes()->title, $option['titles']);
      }
    }
    public function testCallByTitle()
    {
      if (self::$apitest) {
	// case: as markdown
	$title = 'エマ・ワトソン';
	$res = Wikipedia::callByTitle($title);
	$this->assertSame($res['pageid'], 128948);
	$this->assertSame($res['title'], $title);
	$this->assertTrue(is_string($res['content']));

	// case: as xml object
	$title = 'ラリー・サンガー';
	Wikipedia::$is_markdown = false;
	$res = Wikipedia::callByTitle($title);
	$this->assertSame($res['pageid'], 470070);
	$this->assertSame($res['title'], $title);
	$this->assertTrue($res['content'] instanceof \SimpleXMLElement);
      }
    }

    public function testReadApiForQuark()
    {
      if (self::$apitest) {
	$title = 'ラリー・サンガー';
	$res = Wikipedia::readApiForQuark($title);
	$this->assertSame($res['name'], $title);
	$this->assertSame($res['wid'], 470070);
	$this->assertSame($res['image_path'], 'https://upload.wikimedia.org/wikipedia/commons/a/a5/L_Sanger.jpg');
	$this->assertSame($res['start'], '1968-07-16 00:00:00');
      }
    }

    public function testRetrieveDescription()
    {
      if (self::$apitest) {
	$title = 'ラリー・サンガー';
	Wikipedia::$is_markdown = false;
	$dataset = Wikipedia::callByTitle($title);
	$res = Wikipedia::retrieveDescription($dataset['content']);
	$this->assertSame($res, 'アメリカ合衆国の哲学者、大学教授。専門家が参加するフリー百科事典プロジェクトCitizendium（シチズンジアム）の創始者');
      }
    }
}
