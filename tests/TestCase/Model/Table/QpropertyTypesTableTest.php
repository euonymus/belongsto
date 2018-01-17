<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\QpropertyTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\QpropertyTypesTable Test Case
 */
class QpropertyTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\QpropertyTypesTable
     */
    public $QpropertyTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.qproperty_types',
        'app.quark_properties',
        'app.qproperty_gtypes',
        'app.qtype_properties',
        'app.quark_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('QpropertyTypes') ? [] : ['className' => 'App\Model\Table\QpropertyTypesTable'];
        $this->QpropertyTypes = TableRegistry::get('QpropertyTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->QpropertyTypes);

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
