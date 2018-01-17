<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\QuarkTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\QuarkTypesTable Test Case
 */
class QuarkTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\QuarkTypesTable
     */
    public $QuarkTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.quark_types',
        'app.quark_properties',
        'app.qtype_properties',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('QuarkTypes') ? [] : ['className' => 'App\Model\Table\QuarkTypesTable'];
        $this->QuarkTypes = TableRegistry::get('QuarkTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->QuarkTypes);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
      $res = $this->QuarkTypes->find()->where(['id' => 2])->contain(['QuarkProperties'])->first();
      $flg = false;
      foreach($res->quark_properties as $quark_property) {
	if (strcmp($quark_property->name, 'nationality') === 0) $flg = true;
      }
      $this->assertTrue($flg);

    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
      //$this->markTestIncomplete('Not implemented yet.');
    }

}
