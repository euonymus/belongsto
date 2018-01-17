<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\QuarkPropertiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\QuarkPropertiesTable Test Case
 */
class QuarkPropertiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\QuarkPropertiesTable
     */
    public $QuarkProperties;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.quark_properties',
        'app.quark_types',
        'app.gluon_types',
        'app.qproperty_gtypes',
        'app.qproperty_types',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('QuarkProperties') ? [] : ['className' => 'App\Model\Table\QuarkPropertiesTable'];
        $this->QuarkProperties = TableRegistry::get('QuarkProperties', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->QuarkProperties);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
      // Possible Types
      $res = $this->QuarkProperties->find()->where(['id' => 1])->contain(['QuarkTypes'])->first();
      $flg = false;
      foreach($res->quark_types as $quark_type) {
	if (strcmp($quark_type->name, 'Country') === 0) $flg = true;
      }
      $this->assertTrue($flg);

      // Having GluonTypes
      $res = $this->QuarkProperties->find()->where(['id' => 2])->contain(['GluonTypes'])->first();
      $flg = false;
      foreach($res->gluon_types as $gluon_type) {
      	if (strcmp($gluon_type->name, 'wifeOf') === 0) $flg = true;
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
