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
<div class="well subject-relation <? if ($type == 1) echo 'white'; ?>">
    <div class="panel subject-relation-main">
        <div class="media">
          <div class="media-left subject-image">
            <?= $this->SubjectTool->imageLink($relation_object) ?>
          </div>
          <div class="media-body">
            <h4 class="media-heading"><?= $this->SubjectTool->buildRelationText($relation_object,
										$name, $relation_text, $type) ?></h4>
            <?= $relation_object->description ?>
          </div>
        </div>
    </div>


<? if ($relation->relation): ?>
    <? if ($relation->relation->count() > 0): ?>
    <div class="row subject-relation-sub">
<ul class="subject-list-relation">
    <? foreach ($relation->relation as $passive2): ?>
        <? if ($subject->id == $passive2->passive_id) continue; ?>



<li>
    <? if ($second_type == 'active'): ?>
  <?= $this->SubjectTool->imageLink($passive2->passife, ['width' => '40px', 'height' => '40px']) ?>
  <?= $this->SubjectTool->buildRelationText($passive2->passife, $relation->name, $passive2->relation, 1) ?>
    <? elseif ($second_type == 'passive'): ?>
  <?= $this->SubjectTool->imageLink($passive2->active, ['width' => '40px', 'height' => '40px']) ?>
  <?= $this->SubjectTool->buildRelationText($passive2->active, $relation->name, $passive2->relation, 2) ?>
    <? endif; ?>
</li>

<? /*
        <div class="col-xs-6 col-md-4 col-lg-3 second-relation">
            <?= $this->element('subject_unit', ['subject_name' => $relation->name,
				      'relation_object' => $passive2->passife,
				      'relation_text' => $passive2->relation]) ?>
        </div>
   */ ?>
    <? endforeach; ?>
</ul>
    </div>
    <? endif; ?>
<? endif; ?>

</div>
