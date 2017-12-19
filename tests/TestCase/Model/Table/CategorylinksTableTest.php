<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CategorylinksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CategorylinksTable Test Case
 */
class CategorylinksTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CategorylinksTable
     */
    public $Categorylinks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.categorylinks'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Categorylinks') ? [] : ['className' => 'App\Model\Table\CategorylinksTable'];
        $this->Categorylinks = TableRegistry::get('Categorylinks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Categorylinks);

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
}
