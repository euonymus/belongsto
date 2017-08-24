<?php
namespace App\Test\TestCase\Vendor;

use Cake\Core\Configure;

use U\U;
use Cake\TestSuite\TestCase;
use Cake\Cache\Cache;
/**
 * App\Vendor\U Test Case
 */
class UTest extends TestCase
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
	require_once(ROOT .DS. "vendor" . DS . "euonymus" . DS . "U.php");
	$this->U = new U;
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->U);
        parent::tearDown();
    }

    public function testFilterMatch()
    {
      $this->U->tryRetrieve();

    }

}
