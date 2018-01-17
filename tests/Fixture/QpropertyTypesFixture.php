<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * QpropertyTypesFixture
 *
 */
class QpropertyTypesFixture extends TestFixture
{
    public $import = ['table' => 'qproperty_types'];

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'quark_property_id' => 1,
            'quark_type_id' => 45,
            'created' => NULL,
            'modified' => NULL
        ],
    ];
}
