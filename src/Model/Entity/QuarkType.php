<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * QuarkType Entity
 *
 * @property int $id
 * @property string $name
 * @property string $image_path
 * @property string $name_prop
 * @property string $start_prop
 * @property string $end_prop
 * @property int $has_gender
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\QpropertyType[] $qproperty_types
 * @property \App\Model\Entity\QtypeProperty[] $qtype_properties
 */
class QuarkType extends Entity
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
