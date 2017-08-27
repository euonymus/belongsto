<?php
namespace App\Test\TestCase\Vendor;

use Cake\Core\Configure;

use App\Utils\TalentDictionary;
use Cake\TestSuite\TestCase;
use Cake\Cache\Cache;
/**
 * App\Vendor\TalentDictionary Test Case
 */
class TalentDictionaryTest extends TestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
	$this->TalentDictionary = new TalentDictionary;
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TalentDictionary);
        parent::tearDown();
    }

    public function testFilterMatch()
    {
      $res = TalentDictionary::readPagesOfAllGenerations('default');
      debug($res);
    }

}
