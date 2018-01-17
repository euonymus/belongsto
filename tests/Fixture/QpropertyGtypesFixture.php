<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * QpropertyGtypesFixture
 *
 */
class QpropertyGtypesFixture extends TestFixture
{
    public $import = ['table' => 'qproperty_gtypes'];

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'quark_property_id' => 1,
            'gluon_type_id' => 1,
            'is_passive' => 1,
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 2,
            'quark_property_id' => 2,
            'gluon_type_id' => 2,
            'is_passive' => 1,
            'created' => NULL,
            'modified' => NULL
        ],
    ];
}
