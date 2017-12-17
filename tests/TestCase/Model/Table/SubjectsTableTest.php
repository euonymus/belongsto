<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SubjectsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

use App\Utils\U;
use App\Utils\TalentDictionary;
use App\Utils\Wikipedia;
/**
 * App\Model\Table\SubjectsTable Test Case
 */
class SubjectsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SubjectsTable
     */
    public $Subjects;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.subjects',
        'app.subject_searches',
        'app.relations',
    ];

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
        $config = TableRegistry::exists('Subjects') ? [] : ['className' => 'App\Model\Table\SubjectsTable'];
        $this->Subjects = TableRegistry::get('Subjects', $config);
	TalentDictionary::$internal = true; // in order not to access google search
	Wikipedia::$internal = true; // in order not to access google search
	SubjectsTable::$escapeForTest = true; // in order not to use FULL TEXT SEARCH
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Subjects);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    //public function testInitialize()
    //{
    //    $this->markTestIncomplete('Not implemented yet.');
    //}

    /**
     * Test validationDefault method
     *
     * @return void
     */
    //public function testValidationDefault()
    //{
    //    $this->markTestIncomplete('Not implemented yet.');
    //}

    public function testRemoveAllSpaces()
    {
      $str      = 'aaa iii ううう　eee　ooo かかか　ききき';
      $expected = 'aaaiiiうううeeeoooかかかききき';
      $res = SubjectsTable::removeAllSpaces($str);
      $this->assertSame($res, $expected);
    }

    public function testFindTargetFromSearchedData()
    {
      // Case 1: Normal
      // retreive the target array from Talent dictionary.
      $testTarget = '上白石萌歌';
      // You can't test search function because PhpUnit doesn't accept fulltext index, so this part is compromising.
      $existings = $this->Subjects->findByName($testTarget);

      // Test 1: 
      $res = $this->Subjects->findTargetFromSearchedData($testTarget, $existings);
      $this->assertSame($testTarget, $res->name);

      // Case 2: Space in between
      // retreive the target array from Talent dictionary.
      $testTarget = '白間 美瑠';
      // You can't test search function because PhpUnit doesn't accept fulltext index, so this part is compromising.
      $existings = $this->Subjects->findByName($testTarget);

      // Test 2:
      $res = $this->Subjects->findTargetFromSearchedData($testTarget, $existings);
      $this->assertSame($testTarget, $res->name);

      // There is no multiple Targets anymore. Because name now has an unique restrictions
      //// Case 3: Multiple Targets make it failure.
      //// retreive the target array from Talent dictionary.
      //$testTarget = '芦田愛菜';
      //// You can't test search function because PhpUnit doesn't accept fulltext index, so this part is compromising.
      //$existings = $this->Subjects->findByName($testTarget);
      //
      //// Test 3:
      //$res = $this->Subjects->findTargetFromSearchedData($testTarget, $existings);
      //$this->assertTrue(is_array($res));
    }


    public function testFillMissingData()
    {
      // Case 1: normal case
      // retreive the target array from Talent dictionary.
      $testTarget = '上白石萌歌';
      $filling = false;
      $retrievedDatas = TalentDictionary::dummyReadOfTalentDictionary();
      foreach($retrievedDatas as $val) {
    	if ($val['name'] != $testTarget) continue;
	$filling = $val;
	break;
      }
      // You can't test search function because PhpUnit doesn't accept fulltext index, so this part is compromising.
      $existings = $this->Subjects->findByName($testTarget);
      $existing = $this->Subjects->findTargetFromSearchedData($testTarget, $existings);

      // Test 1
      $res = $this->Subjects->fillMissingData($filling, $existing);
      $this->assertSame($res['image_path'], $filling['image_path']);
      $this->assertSame($res['description'], $filling['description']);
      $this->assertSame($res['start'], $filling['start']);
      $this->assertSame($res['start_accuracy'], $filling['start_accuracy']);

      // Case 2: no update
      // retreive the target array from Talent dictionary.
      $testTarget = '白間 美瑠';
      $filling = false;
      $retrievedDatas = TalentDictionary::dummyReadOfTalentDictionary();
      foreach($retrievedDatas as $val) {
    	if ($val['name'] != SubjectsTable::removeAllSpaces($testTarget)) continue;
	$filling = $val;
	break;
      }
      // You can't test search function because PhpUnit doesn't accept fulltext index, so this part is compromising.
      $existings = $this->Subjects->findByName($testTarget);
      $existing = $this->Subjects->findTargetFromSearchedData($testTarget, $existings);

      // Test 2
      $res = $this->Subjects->fillMissingData($filling, $existing);
      $this->assertTrue(empty($res));

      // Case 3: update start to specialize
      // retreive the target array from Talent dictionary.
      $testTarget = '朝長美桜';
      $filling = false;
      $retrievedDatas = TalentDictionary::dummyReadOfTalentDictionary();

      foreach($retrievedDatas as $val) {
    	if ($val['name'] != SubjectsTable::removeAllSpaces($testTarget)) continue;
	$filling = $val;
	break;
      }
      // You can't test search function because PhpUnit doesn't accept fulltext index, so this part is compromising.
      $existings = $this->Subjects->findByName($testTarget);
      $existing = $this->Subjects->findTargetFromSearchedData($testTarget, $existings);

      // Test 3
      $res = $this->Subjects->fillMissingData($filling, $existing);
      $this->assertSame($res['start'], $filling['start']); // has to be updated
      $this->assertSame($res['start_accuracy'], ''); // has to be updated to blank

      // Case 4: no updates if it originally have accurate start data
      // retreive the target array from Talent dictionary.
      $testTarget = '向井地美音';
      $filling = false;
      $retrievedDatas = TalentDictionary::dummyReadOfTalentDictionary();
// debug($retrievedDatas);

      foreach($retrievedDatas as $val) {
    	if ($val['name'] != SubjectsTable::removeAllSpaces($testTarget)) continue;
	$filling = $val;
	break;
      }
      // You can't test search function because PhpUnit doesn't accept fulltext index, so this part is compromising.
      $existings = $this->Subjects->findByName($testTarget);
      $existing = $this->Subjects->findTargetFromSearchedData($testTarget, $existings);

      // Test 4
      $res = $this->Subjects->fillMissingData($filling, $existing);

      $this->assertSame($res['description'], $filling['description']);
      $this->assertFalse(array_key_exists('start', $res));   // start should not be set
      $this->assertFalse(array_key_exists('start_accuracy', $res)); // start_accuracy should not be set

      if (self::$apitest) {
	// Case 5: data from Wikipedia
	$testTarget = '石田純一';
	$filling = Wikipedia::readPageForQuark($testTarget);

	// You can't test search function because PhpUnit doesn't accept fulltext index, so this part is compromising.
	$existings = $this->Subjects->findByName($testTarget);
	$existing = $this->Subjects->findTargetFromSearchedData($testTarget, $existings);

	// Test 5
	$res = $this->Subjects->fillMissingData($filling, $existing);
	$this->assertSame($res['image_path'], $filling['image_path']);
	$this->assertSame($res['description'], $filling['description']);
	$this->assertFalse(array_key_exists('start', $res));
	$this->assertFalse(array_key_exists('start_accuracy', $res));
	$this->assertSame($res['url'], $filling['url']);
      }
    }


    public function testInsertInfoFromWikipedia()
    {
      if (self::$apitest) {
	$testTarget = 'ダルビッシュ有';
	$ret = $this->Subjects->insertInfoFromWikipedia($testTarget);
	$this->assertTrue(!!$ret);
      }
    }

    public function testUpdateInfoFromWikipedia()
    {
      if (self::$apitest) {
        // Case1: no data will be updated, because all fields in db are already filled
	$testTarget = '白間 美瑠';
	// You can't test search function because PhpUnit doesn't accept fulltext index, so this part is compromising.
	$existings = $this->Subjects->findByName($testTarget);
	$existing = $this->Subjects->findTargetFromSearchedData($testTarget, $existings);

	$ret = $this->Subjects->updateInfoFromWikipedia($existing);
	$this->assertFalse($ret);


        // Case1: no data will be updated, because all fields in db are already filled
	$testTarget = '徳川家康';
	// You can't test search function because PhpUnit doesn't accept fulltext index, so this part is compromising.
	$existings = $this->Subjects->findByName($testTarget);
	$existing = $this->Subjects->findTargetFromSearchedData($testTarget, $existings);

	$ret = $this->Subjects->updateInfoFromWikipedia($existing);
	$this->assertTrue(!!$ret);
      }
    }

    public function testGetOneWithSearch()
    {
      $testTarget = '上白石萌歌';
      $current = $this->Subjects->findByName($testTarget)->first();
      $data = $this->Subjects->getOneWithSearch($testTarget);
      $this->assertSame($data->id, $current->id);
      $this->assertSame($data->description, $current->description);
    }

    public function testForceGetQuark()
    {
      // get record existing in db. in this case, it doesn't access to outsider's data
      $testTarget = '上白石萌歌';
      $current = $this->Subjects->findByName($testTarget)->first();
      $data = $this->Subjects->forceGetQuark($testTarget);
      $this->assertSame($data->id, $current->id);
      $this->assertSame($data->description, $current->description);

      if (self::$apitest) {
	// get record from wikipedia
	$testTarget = '武井咲';
	$data = $this->Subjects->forceGetQuark($testTarget);
	$this->assertSame($data->name, $testTarget);
	$this->assertSame($data->start->format('Y-m-d\TH:i:s+00:00'), '1993-12-25T00:00:00+00:00');

	// no data exists in neither wikipedia nor db, so create one
	$testTarget = 'hohgehg';
	$data = $this->Subjects->forceGetQuark($testTarget);
	$this->assertSame($data->name, $testTarget);
      }
    }

    public function testSaveNewArray()
    {
      if (self::$apitest) {
	// retreive the target array from Talent dictionary.
	$testTarget = '上白石萌歌';
	$filling = false;
	$retrievedDatas = TalentDictionary::dummyReadOfTalentDictionary();
	foreach($retrievedDatas as $val) {
	  if ($val['name'] != $testTarget) continue;
	  $filling = $val;
	  break;
	}
	$res = $this->Subjects->saveNewArray($filling);
	$this->assertSame($res->name, $testTarget);
      }
    }

    public function testFindAndSaveRelatives()
    {
      if (self::$apitest) {
	$res = $this->Subjects->findAndSaveRelatives(3);
	$this->assertTrue($res);

	$test = $this->Subjects->find()->all();
	foreach ($test as $val) {
	  debug($val->toArray());
	}

	// RelationsTableのRulesのせいで保存できないのでテストできない。
	//$Relations = TableRegistry::get('Relations');
	//$test = $Relations->find()->all();
	//foreach ($test as $val) {
	//	debug($val->toArray());
	//}
      }
    }

    public function testRetrieveAndSaveMovie()
    {
      if (self::$apitest) {
        $title = '白鯨との闘い';
	$res = $this->Subjects->retrieveAndSaveMovie($title);
	$this->assertTrue($res);

	$Relations = TableRegistry::get('Relations');
	$test = $Relations->find()->all();
	$flag = 0;
	foreach ($test as $val) {
	  if (strcmp($val->relation, 'の脚本を手がけた') == 0) {
	    $flag++;
	    $this->assertSame($this->Subjects->findById($val->passive_id)->first()->name, $title);
	    $this->assertSame($this->Subjects->findById($val->active_id)->first()->name, 'チャールズ・リーヴィット');
	  }
	  if (strcmp($val->relation, 'に出演した') == 0) {
	    $this->assertSame($this->Subjects->findById($val->passive_id)->first()->name, $title);
	    $actor = $this->Subjects->findById($val->active_id)->first()->name;
	    if (strcmp($actor, 'ベン・ウィショー') == 0) {
	      $flag++;
	    } elseif (strcmp($actor, 'ブレンダン・グリーソン') == 0) {
	      $flag++;
	    } elseif (strcmp($actor, 'トム・ホランド') == 0) {
	      $flag++;
	    }
	  }
	  if (strcmp($val->relation, 'の監督') == 0) {
	    $flag++;
	    $this->assertSame($this->Subjects->findById($val->passive_id)->first()->name, $title);
	    $this->assertSame($this->Subjects->findById($val->active_id)->first()->name, 'ロン・ハワード');
	  }
	  if (strcmp($val->relation, 'の原作者') == 0) {
	    $flag++;
	    $this->assertSame($this->Subjects->findById($val->passive_id)->first()->name, $title);
	    $this->assertSame($this->Subjects->findById($val->active_id)->first()->name, 'ナサニエル・フィルブリック');
	  }
	}
	$this->assertSame($flag, 6);
      }
    }
}
