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
            'id'             => '1',
            'active_id'      => '9',
            'passive_id'     => '7',
            'relation'       => 'の娘',
            'start'          => '2016-11-01 06:33:07',
            'end'            => NULL,
            'start_accuracy' => '',
            'end_accuracy'   => '',
            'is_momentary'   => 1,
            'created'        => '2016-11-01 06:33:07',
            'modified'       => '2016-11-01 06:33:07'
        ],
    ];
}
