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
    ];

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
}
