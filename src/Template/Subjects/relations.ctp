<?= $this->Html->meta('canonical', $canonical, ['rel' => 'canonical', 'type' => null, 'title' => null, 'block' => true]) ?>
<div class="row">
  <div class="col-md-3 card subject-main">


<? if (!empty($subject->image_path)): ?>
    <div class="subject-image">
        <img src="<?= $this->SubjectTool->imagePath($subject->image_path) ?>" class="card-img-top">
   
<? /*
        <?= $this->SubjectTool->imageLink($subject, ['class' => 'card-img-top']) ?>
        <div class="main-image" style="background-image:url(<?= $subject->image_path ?>);"></div>
*/ ?>
    </div>
<? endif; ?>


    <div class="card-block">
      <h1 class="card-title"><?= h($subject->name) ?>
<? if (!empty($subject->url)): ?>
          <sub>
              <?= $this->Html->link('', $subject->url, ['target' => '_blank', 'class' => "glyphicon glyphicon-globe"]); ?>
          </sub>
<? endif; ?>
      </h1>
      <p><?= $this->SubjectTool->period($subject) ?></p>
      <p><?= h($subject->description) ?></p>

   <? if ($subject->last_modified_user['role'] != 'admin'): ?>
      <p>edited by <?= $subject->last_modified_user['username'] ?></p>
   <? endif; ?>

<? /* if (!empty($subject->url)): ?>
    <p><?= $this->Html->link('<img src="/img/url_button.png" style="width:50px;border:0px;" >', $subject->url,
			     ['target' => '_blank', 'escape' => false]); ?></p>
<? endif; */ ?>
<? if (!empty($subject->affiliate)): ?>
    <p><?= $this->Html->link($this->SubjectTool->buynow(), $subject->affiliate, ['target' => '_blank']); ?></p>
<? endif; ?>
    <p><?= $this->Html->link('Add relation', ['controller' => 'relations', 'action' => 'add', $subject->id],
			     ['class' => 'btn btn-primary']); ?></p>
    </div>
  </div>

  <div class="col-md-9 subject-relation-list">

    <ul class="nav nav-pills">
      <li role="presentation"<? if ($second_type == 'active') { echo ' class="active"'; } ?>>
          <?= $this->Html->link('Active', ['controller' => 'subjects', 'action' => 'relations', $subject->name, 'active']); ?>
      </li>
      <li role="presentation"<? if ($second_type == 'passive') { echo ' class="active"'; } ?>>
          <?= $this->Html->link('Passive', ['controller' => 'subjects', 'action' => 'relations', $subject->name, 'passive']); ?>
      </li>
      <li role="presentation"<? if ($second_type == 'none') { echo ' class="active"'; } ?>>
          <?= $this->Html->link('None', ['controller' => 'subjects', 'action' => 'relations', $subject->name, 'none']); ?>
      </li>
    </ul>


<?
$usedList = [];
foreach ($subject->quark_properties as $quark_property) {
  $targetGluons = $quark_property->targetGluons($subject, $qproperty_gtypes);
  $usedList = array_merge($usedList, $targetGluons);
  echo $this->element('quark_property_box', compact(['quark_property', 'targetGluons']));
}
$passives = [];
foreach($subject->passives as $passive) {
  $flg = true;
  foreach($usedList as $used) {
    if ($passive->_joinData->id == $used['relation']->_joinData->id) $flg = false;
  }
  if ($flg) $passives[] = $passive;
}
$actives = [];
foreach($subject->actives as $active) {
  $flg = true;
  foreach($usedList as $used) {
    if ($active->_joinData->id == $used['relation']->_joinData->id) $flg = false;
  }
  if ($flg) $actives[] = $active;
}
?>

<? if ($passives): ?>
    <h2><?
   $en = 'What is ' . $subject->name . '?';
   $ja = $subject->name . 'とは';
   echo $this->LangMngr->txt($en, $ja);
?></h2>
    <div class="related">
        <?= $this->element('subject_boxes', ['subject' => $subject, 'relations' => $passives]) ?>
    </div>
<? endif; ?>

<? if ($actives): ?>
    <h2><?
   $en = 'Quarks Related to ' . $subject->name;
   $ja = $subject->name . 'に関する事項';
   echo $this->LangMngr->txt($en, $ja);
?></h2>
    <div class="related">
        <?= $this->element('subject_boxes', ['subject' => $subject, 'relations' => $actives, 'isPassive' => true]) ?>
    </div>
<? endif; ?>

  </div>

</div>
