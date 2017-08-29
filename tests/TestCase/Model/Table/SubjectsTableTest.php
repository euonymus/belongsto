<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SubjectsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

use App\Utils\U;
use App\Utils\TalentDictionary;
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
        'app.relations'
    ];

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
      $retrieved = false;
      $retrievedDatas = TalentDictionary::dummyReadOfTalentDictionary();
      foreach($retrievedDatas as $val) {
    	if ($val['name'] != $testTarget) continue;
	$retrieved = $val;
	break;
      }
      // You can't test search function because PhpUnit doesn't accept fulltext index, so this part is compromising.
      $existings = $this->Subjects->findByName($testTarget);

      // Test 1: 
      $res = $this->Subjects->findTargetFromSearchedData($retrieved, $existings);
      $this->assertSame($testTarget, $res->name);

      // Case 2: Space in between
      // retreive the target array from Talent dictionary.
      $testTarget = '白間 美瑠';
      $retrieved = false;
      $retrievedDatas = TalentDictionary::dummyReadOfTalentDictionary();
      foreach($retrievedDatas as $val) {
    	if ($val['name'] != SubjectsTable::removeAllSpaces($testTarget)) continue;
	$retrieved = $val;
	break;
      }

      // You can't test search function because PhpUnit doesn't accept fulltext index, so this part is compromising.
      $existings = $this->Subjects->findByName($testTarget);

      // Test 2:
      $res = $this->Subjects->findTargetFromSearchedData($retrieved, $existings);
      $this->assertSame($testTarget, $res->name);


      // Case 3: Multiple Targets make it failure.
      // retreive the target array from Talent dictionary.
      $testTarget = '芦田愛菜';
      $retrieved = false;
      $retrievedDatas = TalentDictionary::dummyReadOfTalentDictionary();
      foreach($retrievedDatas as $val) {
    	if ($val['name'] != SubjectsTable::removeAllSpaces($testTarget)) continue;
	$retrieved = $val;
	break;
      }

      // You can't test search function because PhpUnit doesn't accept fulltext index, so this part is compromising.
      $existings = $this->Subjects->findByName($testTarget);

      // Test 3:
      $res = $this->Subjects->findTargetFromSearchedData($retrieved, $existings);
      $this->assertFalse($res);
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
      $existing = $this->Subjects->findTargetFromSearchedData($filling, $existings);

      // Test 1
      $res = $this->Subjects->fillMissingData($filling, $existing);
      $this->assertSame($res->image_path, $filling['image_path']);
      $this->assertSame($res->description, $filling['description']);
      $this->assertSame($res->start, $filling['start']);
      $this->assertSame($res->start_accuracy, $filling['start_accuracy']);

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
      $existing = $this->Subjects->findTargetFromSearchedData($filling, $existings);

      // Test 1
      $res = $this->Subjects->fillMissingData($filling, $existing);
      $this->assertSame($res->image_path, $existing->image_path);
      $this->assertSame($res->description, $existing->description);
      $this->assertSame($res->start, $existing->start);
      $this->assertSame($res->start_accuracy, $existing->start_accuracy);

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
      $existing = $this->Subjects->findTargetFromSearchedData($filling, $existings);

      // Test 3
      $res = $this->Subjects->fillMissingData($filling, $existing);
      $this->assertSame($res->image_path, $existing->image_path);
      $this->assertSame($res->description, $existing->description);
      $this->assertSame($res->start, $filling['start']); // has to be updated
      $this->assertSame($res->start_accuracy, ''); // has to be updated to blank

      // Case 4: no updates if it originally have accurate start data
      // retreive the target array from Talent dictionary.
      $testTarget = '向井地美音';
      $filling = false;
      $retrievedDatas = TalentDictionary::dummyReadOfTalentDictionary();
      debug($retrievedDatas);

      foreach($retrievedDatas as $val) {
    	if ($val['name'] != SubjectsTable::removeAllSpaces($testTarget)) continue;
	$filling = $val;
	break;
      }
      // You can't test search function because PhpUnit doesn't accept fulltext index, so this part is compromising.
      $existings = $this->Subjects->findByName($testTarget);
      $existing = $this->Subjects->findTargetFromSearchedData($filling, $existings);

      // Test 4
      $res = $this->Subjects->fillMissingData($filling, $existing);
      $this->assertSame($res->image_path, $existing->image_path);
      $this->assertSame($res->description, $existing->description);
      $this->assertSame($res->start, $existing->start); // no change
      $this->assertSame($res->start_accuracy, ''); // no change
    }
}
