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
          <h4 class="media-heading"><?= $this->SubjectTool->buildRelationText($relation_object,
						$name, $relation_text, $suffix, $type) ?>
    <? if (!empty($auth) && $auth->user('id')): ?>
                 <?= $this->Html->link('',
		      ['controller' => 'relations', 'action' => 'edit', $relation_object->_joinData->id],
		      ['class'=> "glyphicon glyphicon glyphicon-pencil"]) ?>
    <? endif; ?>
          </h4>

          <p><?= $this->SubjectTool->period($relation_object->_joinData) ?></p>
          <hr>
          <div class="media-left subject-image">
            <?= $this->SubjectTool->imageLink($relation_object) ?>
          </div>
          <div class="media-body">
            <h3><?= $this->Html->link($relation_object->name,
				      \App\View\Helper\SubjectToolHelper::buildViewArray($relation_object->id)) ?></h3>
            <?= $relation_object->description ?>
          </div>
        </div>
    </div>
<? if ($relation->relation): ?>
<?
  /* $relation->relation には主題のIDと同一の関係が存在することがあるので除外する */
  $secRelations = [];
  foreach ($relation->relation as $secRelation) {
    if ($second_type == 'active') {
      if ($subject->id == $secRelation->passive_id) continue;
    } elseif ($second_type == 'passive') {
      if ($subject->id == $secRelation->active_id) continue;
    }
    $secRelations[] = $secRelation;
  }
?>
    <? if (!empty($secRelations)): ?>
    <div class="subject-relation-sub">

    <ul class="subject-list-relation">
    <? foreach ($secRelations as $passive2): ?>
      <li>
        <? if ($second_type == 'active'): ?>
           <? if ($subject->id == $passive2->passive_id) continue; ?>
           <?= $this->SubjectTool->imageLink($passive2->passive, ['width' => '40px', 'height' => '40px']) ?>
           <?= $this->SubjectTool->buildRelationShortText($passive2->passive, $relation->name,
						     $passive2->relation, $passive2->suffix) ?>
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
