<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\QpropertyGtypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\QpropertyGtypesTable Test Case
 */
class QpropertyGtypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\QpropertyGtypesTable
     */
    public $QpropertyGtypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.qproperty_gtypes',
        'app.quark_properties',
        'app.qproperty_types',
        'app.quark_types',
        'app.qtype_properties',
        'app.gluon_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('QpropertyGtypes') ? [] : ['className' => 'App\Model\Table\QpropertyGtypesTable'];
        $this->QpropertyGtypes = TableRegistry::get('QpropertyGtypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->QpropertyGtypes);

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
