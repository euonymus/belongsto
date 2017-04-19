<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BaryonsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BaryonsTable Test Case
 */
class BaryonsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BaryonsTable
     */
    public $Baryons;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.baryons',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Baryons') ? [] : ['className' => 'App\Model\Table\BaryonsTable'];
        $this->Baryons = TableRegistry::get('Baryons', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Baryons);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
