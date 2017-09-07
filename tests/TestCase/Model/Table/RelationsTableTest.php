<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RelationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

use App\Utils\U;
/**
 * App\Model\Table\RelationsTable Test Case
 */
class RelationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RelationsTable
     */
    public $Relations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.relations',
        'app.subjects',
        'app.subject_searches',
        //'app.actives',
        //'app.passives',
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
        $config = TableRegistry::exists('Relations') ? [] : ['className' => 'App\Model\Table\RelationsTable'];
        $this->Relations = TableRegistry::get('Relations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Relations);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    //public function testBuildRules()
    //{
    //    $this->markTestIncomplete('Not implemented yet.');
    //}

    static $dummyRelatives = [
		[
			'main' => 'A子さん',
			'relative_type' => '長女'
		],
		[
			'main' => 'B子さん',
			'relative_type' => '娘婿'
		],
		[
			'main' => 'C男さん',
			'relative_type' => '祖父'
		],
    ];

    public function testConstRelativeGluon()
    {
      $relatives = self::$dummyRelatives;
      $Subjects = TableRegistry::get('Subjects');

      $testTarget1 = '向井地美音';
      $testTarget2 = '朝長美桜';
      $existings = $Subjects->findByName($testTarget1);
      foreach($existings as $val) {
	$subject1 = $val;
      }
      $existings = $Subjects->findByName($testTarget2);
      foreach($existings as $val) {
	$subject2 = $val;
      }

      // Case 1
      $expected = [
	'active_id'  => '5',
	'passive_id' => '6',
	'relation' => 'の長女',
	'start' => '1998-01-01 00:00:00',
	'start_accuracy' => 'year',
	'is_momentary' => true
      ];
      $res = RelationsTable::constRelativeGluon($subject1, $subject2, $relatives[0]);
      $this->assertSame($res, $expected);

      // Case 2
      $expected = [
	'active_id'  => '6',
	'passive_id' => '5',
	'relation' => 'を祖父に持つ',
	'start' => '1998-01-29 00:00:00',
	'start_accuracy' => '',
	'is_momentary' => true
      ];
      $res = RelationsTable::constRelativeGluon($subject1, $subject2, $relatives[2]);
      $this->assertSame($res, $expected);
    }

    public function testSaveGluonsFromWikipedia()
    {
      if (self::$apitest) {
	$testTarget1 = '石田純一';
	$Subjects = TableRegistry::get('Subjects');
	$subject = $Subjects->findByName($testTarget1)->first();
	$res = $this->Relations->saveGluonsFromWikipedia($subject);
	$savedSubject = $Subjects->findByName('いしだ壱成')->first();
	$this->assertTrue(!!$savedSubject);

	$saved = $this->Relations->findByActiveId(7)->count();
	$this->assertSame($saved, 4);

	$saved = $this->Relations->findByPassiveId(7)->count();
	$this->assertSame($saved, 2);
      }
    }

/*
    public function testHoge()
    {
      $arr = [
	      'active_id' => 999,
	      'passive_id' => 998,
	      'relation' => 'hoge',

	      'suffix'   => '',
	      'start'   => NULL,
	      'end'   => NULL,
	      'start_accuracy'   => '',
	      'end_accuracy'   => '',

	      'is_momentary' => true,

	      'order_level'   => 1,
	      'is_exclusive'   => false,
	      'user_id'   => 2,
	      'last_modified_user'   => 2,
	      'baryon_id'   => NULL,
	      'created'   => NULL,
	      'modified'   => NULL,

      ];
      $data = $this->Relations->formToEntity($arr);

      //$data = $this->Relations->findById(1)->first();
      //$data->name = 'pepe';

      //$res = $this->Relations->save($data,['checkRules' => false]);
      $res = $this->Relations->save($data);
      debug($res);
    }
*/

    public function testCheckRelationExists()
    {
      $res = $this->Relations->checkRelationExists(1,2);
      $this->assertFalse($res);

      $res = $this->Relations->checkRelationExists(9,7);
      $this->assertTrue($res);
    }
}
