<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * QuarkProperty Entity
 *
 * @property int $id
 * @property string $name
 * @property string $caption
 * @property string $caption_ja
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\QpropertyGtype[] $qproperty_gtypes
 * @property \App\Model\Entity\QpropertyType[] $qproperty_types
 * @property \App\Model\Entity\QtypeProperty[] $qtype_properties
 */
class QuarkProperty extends Entity
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

    public function targetGluons($subject, $qproperty_gtypes)
    {
      $candidates = [];
      foreach ($qproperty_gtypes as $qproperty_gtype) {
	$candidates += $qproperty_gtype->arrForProp($this->id);
      }
      $ret = [];
      foreach ($subject->passives as $relation) {
	if ($relation->filterForGluonType($candidates, Subject::SIDES_FORWARD)) {
	  $ret[] = ['relation' => $relation, 'sides' => Subject::SIDES_FORWARD];
	}
      }
      foreach ($subject->actives as $relation) {
	if ($relation->filterForGluonType($candidates, Subject::SIDES_BACKWARD)) {
	  $ret[] = ['relation' => $relation, 'sides' => Subject::SIDES_BACKWARD];
	}
      }
      return $ret;
    }
}
