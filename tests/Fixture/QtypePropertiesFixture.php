<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * QtypePropertiesFixture
 *
 */
class QtypePropertiesFixture extends TestFixture
{
    public $import = ['table' => 'qtype_properties'];

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'quark_type_id' => 2,
            'quark_property_id' => 1,
            'is_required' => 0,
            'created' => NULL,
            'modified' => NULL
        ],
    ];
}
