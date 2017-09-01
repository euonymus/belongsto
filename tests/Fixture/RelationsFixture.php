<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RelationsFixture
 *
 */
class RelationsFixture extends TestFixture
{
    public $import = ['table' => 'relations'];

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 'd5277032-3ee7-441b-86d1-c1caca39f027',
            'active_id' => 'Lorem ipsum dolor sit amet',
            'passive_id' => 'Lorem ipsum dolor sit amet',
            'relation' => 'Lorem ipsum dolor sit amet',
            'start' => '2016-11-01 06:33:07',
            'end' => '2016-11-01 06:33:07',
            'start_accuracy' => 'Lorem ip',
            'end_accuracy' => 'Lorem ip',
            'is_momentary' => 1,
            'created' => '2016-11-01 06:33:07',
            'modified' => '2016-11-01 06:33:07'
        ],
    ];
}
