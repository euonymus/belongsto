<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GluonTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GluonTypesTable Test Case
 */
class GluonTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\GluonTypesTable
     */
    public $GluonTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.gluon_types',
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
        $config = TableRegistry::exists('GluonTypes') ? [] : ['className' => 'App\Model\Table\GluonTypesTable'];
        $this->GluonTypes = TableRegistry::get('GluonTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->GluonTypes);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
      // Possible Properties
      $res = $this->GluonTypes->find()->where(['id' => 2])->contain(['QuarkProperties'])->first();
      $flg = false;
      foreach($res->quark_properties as $quark_property) {
        if (strcmp($quark_property->name, 'children') === 0) $flg = true;
      }
      $this->assertTrue($flg);
      foreach($res->quark_properties as $quark_property) {
        if (strcmp($quark_property->name, 'parent') === 0) $flg = true;
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
