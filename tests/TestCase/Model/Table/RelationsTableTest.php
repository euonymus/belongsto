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
			'main' => '田中眞紀子',
			'relative_type' => '長女'
		],
		[
			'main' => '田中直紀',
			'relative_type' => '娘婿'
		]
    ];

    public function testBuildRelativeGluon()
    {
      $relatives = self::$dummyRelatives;
      $this->Relations->buildRelativeGluon($relatives[0]);
    }
}
