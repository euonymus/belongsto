<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * QtypeProperty Entity
 *
 * @property int $id
 * @property int $quark_type_id
 * @property int $quark_property_id
 * @property bool $is_required
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\QuarkType $quark_type
 * @property \App\Model\Entity\QuarkProperty $quark_property
 */
class QtypeProperty extends Entity
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
        'id' => false
    ];
}
