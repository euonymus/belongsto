<div class="well subject-relation">

<?
   if (!isset($isPassive)) $isPassive = false;
   if ($isPassive) {
     $unit_key = 'object_name';
   } else {
     $unit_key = 'subject_name';
   }
?>
<?
  ${$unit_key} = $subject->name;
  $relation_object = $relation;
  $relation_text = $relation->_joinData->relation;
?>
    <div class="panel subject-relation-main">
      <h3>
        <?= $this->SubjectTool->imageLink($relation_object) ?>

        <? if (isset($subject_name)): ?>
          <?= $subject_name ?>は <?= $this->SubjectTool->link($relation_object->name, $relation_object->id) ?>
        <? elseif (isset($object_name)): ?>
          <?= $this->SubjectTool->link($relation_object->name, $relation_object->id) ?> は<?= $object_name ?>
        <? endif; ?>

        <?= $relation_text ?>
      </h3>
    </div>


    <div class="row subject-relation-sub">
    <?php foreach ($relation->relation as $passive2): ?>
        <? if ($subject->id == $passive2->active_id) continue; ?>
        <div class="col-xs-3 second-relation">
            <?= $this->element('subject_unit', ['object_name' => $relation->name,
				      'relation_object' => $passive2->active,
				      'relation_text' => $passive2->relation]) ?>
        </div>
    <?php endforeach; ?>
    </div>


</div>
