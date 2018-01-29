<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * QpropertyGtype Entity
 *
 * @property int $id
 * @property int $quark_property_id
 * @property int $gluon_type_id
 * @property bool $is_passive
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\QuarkProperty $quark_property
 * @property \App\Model\Entity\GluonType $gluon_type
 */
class QpropertyGtype extends Entity
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

    public function arrForProp($quark_property_id)
    {
      if ($quark_property_id != $this->quark_property_id) return [];
      return [$this->gluon_type_id => $this->sides];
    }
}
