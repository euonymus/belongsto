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
            'id'                 => '1',
            'active_id'          => '9',
            'passive_id'         => '7',
            'relation'           => 'の娘',
            'suffix'             => '',
            'start'              => '2016-11-01 06:33:07',
            'end'                => NULL,
            'start_accuracy'     => '',
            'end_accuracy'       => '',
            'is_momentary'       => 1,
            'order_level'        => 1,
            'is_exclusive'       => 0,
            'user_id'            => 2,
            'last_modified_user' => 2,
            'baryon_id'          => NULL,
            'source'             => NULL,
            'created'            => '2016-11-01 06:33:07',
            'modified'           => '2016-11-01 06:33:07'
        ],
        [
            'id'                 => '2',
            'active_id'          => '12',
            'passive_id'         => '10',
            'relation'           => 'にて北海道2区に自民党から出馬して当選した',
            'suffix'             => '',
            'start'              => '2016-11-01 06:33:07',
            'end'                => NULL,
            'start_accuracy'     => '',
            'end_accuracy'       => '',
            'is_momentary'       => 1,
            'order_level'        => 1,
            'is_exclusive'       => 0,
            'user_id'            => 2,
            'last_modified_user' => 2,
            'baryon_id'          => NULL,
            'source'             => NULL,
            'created'            => '2016-11-01 06:33:07',
            'modified'           => '2016-11-01 06:33:07'
        ],
    ];
}
