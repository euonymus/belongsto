<?
  if (!isset($isPassive)) $isPassive = false;
  if ($isPassive) {
    $type = 2;
  } else {
    $type = 1;
  }
  $name = $subject->name;
  $relation_object = $relation;
  $relation_text = $relation->_joinData->relation;
?>
<div class="well subject-relation">

    <div class="panel subject-relation-main">
      <h3>
        <?= $this->SubjectTool->imageLink($relation_object) ?>
        <?= $this->SubjectTool->buildRelationText($relation_object, $name, $relation_text, $type) ?>
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
