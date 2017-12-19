<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Categorylink Entity
 *
 * @property int $cl_from
 * @property string $cl_to
 * @property string $cl_sortkey
 * @property \Cake\I18n\Time $cl_timestamp
 * @property string $cl_sortkey_prefix
 * @property string $cl_collation
 * @property string $cl_type
 * @property int $status
 */
class Categorylink extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'cl_from' => false,
        'cl_to' => false
    ];
}
