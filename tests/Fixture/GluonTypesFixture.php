<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * GluonTypesFixture
 *
 */
class GluonTypesFixture extends TestFixture
{
    public $import = ['table' => 'gluon_types'];

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'name' => 'nationality',
            'caption' => 'nationality',
            'caption_ja' => '国籍',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 2,
            'name' => 'wifeOf',
            'caption' => 'wife of',
            'caption_ja' => 'の妻',
            'created' => NULL,
            'modified' => NULL
        ],
    ];
}
