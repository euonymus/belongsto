<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SubjectsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

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
      $retrievedDatas = TalentDictionary::readPagesOfAllGenerations('default');
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
      $retrievedDatas = TalentDictionary::readPagesOfAllGenerations('default');
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
      $retrievedDatas = TalentDictionary::readPagesOfAllGenerations('default');
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
      // retreive the target array from Talent dictionary.
      $testTarget = '上白石萌歌';
      $filling = false;
      $retrievedDatas = TalentDictionary::readPagesOfAllGenerations('default');
      foreach($retrievedDatas as $val) {
    	if ($val['name'] != $testTarget) continue;
	$filling = $val;
	break;
      }
      // You can't test search function because PhpUnit doesn't accept fulltext index, so this part is compromising.
      $existings = $this->Subjects->findByName($testTarget);
      $existing = $this->Subjects->findTargetFromSearchedData($filling, $existings);


      $res = $this->Subjects->fillMissingData($filling, $existing);
      debug($res);


    }
}
