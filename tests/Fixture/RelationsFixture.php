<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RelationsFixture
 *
 */
class RelationsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'string', 'length' => 36, 'null' => false, 'default' => '', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'active_id' => ['type' => 'string', 'length' => 36, 'null' => false, 'default' => '', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'passive_id' => ['type' => 'string', 'length' => 36, 'null' => false, 'default' => '', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'relation' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => '', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'start' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'end' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'start_accuracy' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'year, month, day, hour, min, secのどれか', 'precision' => null, 'fixed' => null],
        'end_accuracy' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'year, month, day, hour, min, secのどれか', 'precision' => null, 'fixed' => null],
        'is_momentary' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => 'start, endが期間ではなく瞬間を表す場合。', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'active_id' => ['type' => 'unique', 'columns' => ['active_id', 'passive_id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

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
