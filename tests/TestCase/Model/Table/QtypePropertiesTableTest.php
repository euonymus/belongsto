<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\QtypePropertiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\QtypePropertiesTable Test Case
 */
class QtypePropertiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\QtypePropertiesTable
     */
    public $QtypeProperties;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.qtype_properties',
        'app.quark_types',
        'app.qproperty_types',
        'app.quark_properties',
        'app.qproperty_gtypes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('QtypeProperties') ? [] : ['className' => 'App\Model\Table\QtypePropertiesTable'];
        $this->QtypeProperties = TableRegistry::get('QtypeProperties', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->QtypeProperties);

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
