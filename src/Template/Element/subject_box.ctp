<div class="well">

<?
   if (!isset($isPassive)) $isPassive = false;
   if ($isPassive) {
     $unit_key = 'object_name';
   } else {
     $unit_key = 'subject_name';
   }
?>
    <?= $this->element('subject_unit', [$unit_key => $subject->name,
                                       'relation_object' => $relation,
                                       'relation_text' => $relation->_joinData->relation]) ?>

    <div class="row">
    <?php foreach ($relation->relation as $passive2): ?>
        <? if ($subject->id == $passive2->active_id) continue; ?>
        <div class="col-xs-2">
            <?= $this->element('subject_unit', ['object_name' => $relation->name,
				      'relation_object' => $passive2->active,
				      'relation_text' => $passive2->relation]) ?>
        </div>
    <?php endforeach; ?>
    </div>


</div>
