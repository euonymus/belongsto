<?
  if (!isset($isPassive)) $isPassive = false;
  if ($isPassive) {
    $type = 2;
    if (!isset($colorType)) $colorType = 2;
  } else {
    $type = 1;
    if (!isset($colorType)) $colorType = 1;
  }
  $name = $subject->name;
  $relation_object = $relation;
  $relation_text = $relation->_joinData->relation;
  $suffix = $relation->_joinData->suffix;
?>
<div class="subject-relation <? if ($colorType == 1) echo 'white'; ?>">
    <div class="subject-relation-main">
        <div class="media">
          <div class="media-left subject-image">

    <? if (is_null($relation_object->_joinData->baryon_id)): ?>
            <?= $this->SubjectTool->imageLink($relation_object) ?>
    <? else: ?>
            <?= $this->BaryonTool->imageLink($baryon->id, $relation_object) ?>
    <? endif; ?>

          </div>
          <div class="media-body">
            <h4 class="media-heading">

    <? if (is_null($relation_object->_joinData->baryon_id)): ?>
                <?= $this->SubjectTool->buildRelationText($relation_object,
						$name, $relation_text, $suffix, $type) ?>
    <? else: ?>
                <?= $this->BaryonTool->buildRelationText($baryon->id, $relation_object,
						$name, $relation_text, $suffix, $type) ?>
    <? endif; ?>


    <? if (
	   !empty($auth) && $auth->user('id') &&
	   (
	      !$relation->_joinData->is_exclusive ||
	      ($auth->user('id') == $relation->_joinData->user_id)
	   )
    ): ?>
                 <?= $this->Html->link('',
		      ['controller' => 'relations', 'action' => 'edit', $relation_object->_joinData->id],
		      ['class'=> "glyphicon glyphicon glyphicon-pencil"]) ?>
        <? if ($auth->user('id') == $relation->_joinData->user_id): ?>
                 <?= $this->Form->postLink('',
                      ['controller' => 'relations', 'action' => 'delete', $relation_object->_joinData->id],
	              ['confirm' => __('Are you sure you want to delete?'), 'class'=> "glyphicon glyphicon-remove-sign"]
                     )
                 ?>
        <? endif; ?>
    <? endif; ?>

    <? if ($this->Page->isBaryon() && is_null($relation_object->_joinData->baryon_id)): ?>
                &nbsp;<b class="glyphicon glyphicon-log-out" ></b>
    <? endif; ?>

            </h4>
            <p><?= $this->SubjectTool->period($relation_object->_joinData) ?></p>
          </div>
<? /*
          <div class="media-left subject-image">
            <?= $this->SubjectTool->imageLink($relation_object) ?>
          </div>
          <div class="media-body">
            <h3><?= $this->Html->link($relation_object->name,
				      \App\View\Helper\SubjectToolHelper::buildViewArray($relation_object->id)) ?></h3>
            <?= $relation_object->description ?>
          </div>
*/ ?>
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
      <div class="well <? if ($colorType == 2) echo 'white'; ?>">
        <h4><?
    if ($second_type == 'active') {
      $en = 'What is ' . $relation_object->name . '?';
      $ja = $relation_object->name . 'とは';
    } elseif ($second_type == 'passive') {
      $en = 'Quarks Related to ' . $relation_object->name;
      $ja = $relation_object->name . 'に関する事項';
    }
    echo $this->LangMngr->txt($en, $ja);
?></h4>
        <?= $relation_object->description ?>
        <ul class="subject-list-relation">
    <? foreach ($secRelations as $passive2): ?>


      <li>
        <? if ($second_type == 'active'): ?>


           <? if ($subject->id == $passive2->passive_id) continue; ?>
    <? if (is_null($passive2->baryon_id)): ?>
       <? if (!isset($baryon) || $baryon->is_oneway): ?>

            <?= $this->SubjectTool->imageLink($passive2->passive, ['width' => '40px', 'height' => '40px']) ?>
            <?= $this->SubjectTool->buildRelationShortText($passive2->passive, $relation->name,
						     $passive2->relation, $passive2->suffix) ?>
            <? if ($this->Page->isBaryon() && is_null($passive2->baryon_id)): ?>
                &nbsp;<b class="glyphicon glyphicon-log-out" ></b>
            <? endif; ?>
            <br><?= $this->SubjectTool->period($passive2) ?>

       <? endif; ?>
    <? else: ?>
            <?= $this->BaryonTool->imageLink($baryon->id, $passive2->passive, ['width' => '40px', 'height' => '40px']) ?>
            <?= $this->BaryonTool->buildRelationShortText($baryon->id, $passive2->passive, $relation->name,
						     $passive2->relation, $passive2->suffix) ?>
            <br><?= $this->SubjectTool->period($passive2) ?>
    <? endif; ?>

        <? elseif ($second_type == 'passive'): ?>


           <? if ($subject->id == $passive2->active_id) continue; ?>
    <? if (is_null($passive2->baryon_id)): ?>
       <? if (!isset($baryon) || $baryon->is_oneway): ?>
            <?= $this->SubjectTool->imageLink($passive2->active, ['width' => '40px', 'height' => '40px']) ?>
            <?= $this->SubjectTool->buildRelationText($passive2->active, $relation->name,
						     $passive2->relation, $passive2->suffix, 2) ?>

            <? if ($this->Page->isBaryon() && is_null($passive2->baryon_id)): ?>
                &nbsp;<b class="glyphicon glyphicon-log-out" ></b>
            <? endif; ?>
            <br><?= $this->SubjectTool->period($passive2) ?>

       <? endif; ?>
    <? else: ?>
            <?= $this->BaryonTool->imageLink($baryon->id, $passive2->active, ['width' => '40px', 'height' => '40px']) ?>
            <?= $this->BaryonTool->buildRelationText($baryon->id, $passive2->active, $relation->name,
						     $passive2->relation, $passive2->suffix, 2) ?>
            <br><?= $this->SubjectTool->period($passive2) ?>
    <? endif; ?>


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

    </div>
    <? endif; ?>
<? endif; ?>

</div>
