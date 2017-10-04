<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RelationsTable;
use App\Model\Table\SubjectsTable;
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
	SubjectsTable::$escapeForTest = true; // in order not to use FULL TEXT SEARCH
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
			'relative_type' => '長女',
			'source' => 'wikipedia'
		],
		[
			'main' => 'B子さん',
			'relative_type' => '娘婿',
			'source' => 'wikipedia'
		],
		[
			'main' => 'C男さん',
			'relative_type' => '祖父',
			'source' => 'wikipedia'
		],
		[
			'main' => 'D男さん',
			'relative_type' => '子供',
			'source' => 'wikipedia'
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
	'is_momentary' => true,
	'source' => 'wikipedia',
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
	'is_momentary' => true,
	'source' => 'wikipedia',
      ];
      $res = RelationsTable::constRelativeGluon($subject1, $subject2, $relatives[2]);
      $this->assertSame($res, $expected);

      // Case 3
      $expected = [
	'active_id'  => '5',
	'passive_id' => '6',
	'relation' => 'の子供',
	'start' => '1998-01-01 00:00:00',
	'start_accuracy' => 'year',
	'is_momentary' => true,
	'source' => 'wikipedia',
      ];
      $res = RelationsTable::constRelativeGluon($subject1, $subject2, $relatives[3]);
      $this->assertSame($res, $expected);
    }

    public function testSaveGluonsFromWikipedia()
    {
      if (self::$apitest) {
	$testTarget1 = '石田純一';
	// Relations->buildRules() にてActives, PassivesのルールをつけているのがFixtureが作れないので、テストではルールを無視する。
	$options = ['checkRules' => false];
	$Subjects = TableRegistry::get('Subjects');
	$subject = $Subjects->findByName($testTarget1)->first();

	SubjectsTable::$escapeForTest = true;
	$res = $this->Relations->saveGluonsFromWikipedia($subject, $options);
	$savedSubject = $Subjects->findByName('いしだ壱成')->first();
	$this->assertTrue(!!$savedSubject);

	$saved = $this->Relations->findByActiveId(7)->count();
	$this->assertSame($saved, 4);

	$saved = $this->Relations->findByPassiveId(7)->count();
	$this->assertSame($saved, 2);
      }
    }

    public function testCheckRelationExists()
    {
      $res = $this->Relations->checkRelationExists(1,2);
      $this->assertFalse($res);

      $res = $this->Relations->checkRelationExists(9,7);
      $this->assertTrue($res);
    }

    public function testSaveGluons()
    {
      $options = ['checkRules' => false];

      // error case: only two fields
      $relation = ['吉川貴盛', '第47回衆議院議員総選挙'];
      $res = $this->Relations->saveGluonByRelation($relation, $options);
      $this->assertFalse($res);

      // error case: existing gluon
      $relation = ['高村正彦', '第47回衆議院議員総選挙', 'にて北海道2区に自民党から出馬して当選した'];
      $res = $this->Relations->saveGluonByRelation($relation, $options);
      $this->assertFalse($res);

      // normal case
      $relation = ['吉川貴盛', '第47回衆議院議員総選挙', 'にて北海道2区に自民党から出馬して当選した', '2014-12-14', '2015-12-14', true];
      $res = $this->Relations->saveGluonByRelation($relation, $options);
      $this->assertSame((int)$res->active_id, 11);
      $this->assertSame((int)$res->passive_id, 10);
      $this->assertSame($res->relation, $relation[2]);
      $this->assertSame($res->start, $relation[3]);
      $this->assertSame($res->end, $relation[4]);
      $this->assertSame($res->is_momentary, $relation[5]);
    }

}
