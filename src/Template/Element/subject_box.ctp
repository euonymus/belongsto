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
  $suffix = $relation->_joinData->suffix;
?>
<div class="well subject-relation <? if ($type == 1) echo 'white'; ?>">
    <div class="subject-relation-main">
        <div class="media">
          <div class="media-left subject-image">
            <?= $this->SubjectTool->imageLink($relation_object) ?>
          </div>
          <div class="media-body">
            <h4 class="media-heading"><?= $this->SubjectTool->buildRelationText($relation_object,
										$name, $relation_text, $suffix, $type) ?></h4>
            <p><?= $this->SubjectTool->period($relation_object->_joinData) ?></p>
            <?= $relation_object->description ?>
          </div>
        </div>
    </div>

<? if ($relation->relation): ?>
    <? /* $relation->relation->count() は常に1つ以上存在する。(subject-relation パートと同じ関係があるため) */ ?>
    <? if ($relation->relation->count() > 1): ?>
    <div class="subject-relation-sub">
    <h4><?= $relation_object->name ?></h4>

    <ul class="subject-list-relation">
    <? foreach ($relation->relation as $passive2): ?>
      <li>
        <? if ($second_type == 'active'): ?>
           <? if ($subject->id == $passive2->passive_id) continue; ?>
           <?= $this->SubjectTool->imageLink($passive2->passive, ['width' => '40px', 'height' => '40px']) ?>
           <?= $this->SubjectTool->buildRelationText($passive2->passive, $relation->name,
						     $passive2->relation, $passive2->suffix, 1) ?>
        <? elseif ($second_type == 'passive'): ?>
           <? if ($subject->id == $passive2->active_id) continue; ?>
           <?= $this->SubjectTool->imageLink($passive2->active, ['width' => '40px', 'height' => '40px']) ?>
           <?= $this->SubjectTool->buildRelationText($passive2->active, $relation->name,
						     $passive2->relation, $passive2->suffix, 2) ?>
        <? endif; ?>
      </li>

<? /*
        <div class="col-xs-6 col-md-4 col-lg-3 second-relation">
            <?= $this->element('subject_unit', ['subject_name' => $relation->name,
				      'relation_object' => $passive2->passive,
				      'relation_text' => $passive2->relation]) ?>
        </div>
   */ ?>
    <? endforeach; ?>
    </ul>

    </div>
    <? endif; ?>
<? endif; ?>

</div>
