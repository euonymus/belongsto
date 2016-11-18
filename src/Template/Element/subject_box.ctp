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
        <div class="media">
          <div class="media-left">
            <?= $this->SubjectTool->imageLink($relation_object) ?>
          </div>
          <div class="media-body">
            <h4 class="media-heading"><?= $this->SubjectTool->buildRelationText($relation_object,
										$name, $relation_text, $type) ?></h4>
            <?= $relation_object->description ?>
          </div>
        </div>
    </div>

    <? if ($relation->relation->count() > 0): ?>
    <div class="row subject-relation-sub">
    <? foreach ($relation->relation as $passive2): ?>
        <? if ($subject->id == $passive2->active_id) continue; ?>
        <div class="col-xs-6 col-md-4 col-lg-3 second-relation">
            <?= $this->element('subject_unit', ['object_name' => $relation->name,
				      'relation_object' => $passive2->active,
				      'relation_text' => $passive2->relation]) ?>
        </div>
    <? endforeach; ?>
    </div>
    <? endif; ?>

</div>
