<div class="row">
  <div class="col-md-3 card subject-main">





   <div><h4>Baryon: <?= $baryon->name ?></h4></div>

<? if (!empty($subject->image_path)): ?>
    <div class="subject-image">
        <img src="<?= $this->SubjectTool->imagePath($subject->image_path) ?>" class="card-img-top">
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
 <? if ($this->request->params['controller'] == 'Baryons'):?>
    <p><?= $this->Html->link('Add relation', ['controller' => 'relations', 'action' => 'add', $subject->id, $baryon->id],
			     ['class' => 'btn btn-primary']); ?></p>
 <? else: ?>
    <p><?= $this->Html->link('Add relation', ['controller' => 'relations', 'action' => 'add', $subject->id],
			     ['class' => 'btn btn-primary']); ?></p>
 <? endif; ?>

    </div>
  </div>

  <div class="col-md-9 subject-relation-list">
    <h2><?
   $en = 'Quarks Related to ' . $subject->name;
   $ja = $subject->name . 'と関係する事柄';
   echo $this->LangMngr->txt($en, $ja);
?></h2>

    <ul class="nav nav-pills">
      <li role="presentation"<? if ($second_type == 'active') { echo ' class="active"'; } ?>>
          <?= $this->Html->link('Active', ['controller' => 'subjects', 'action' => 'relations', $subject->id, 'active']); ?>
      </li>
      <li role="presentation"<? if ($second_type == 'passive') { echo ' class="active"'; } ?>>
          <?= $this->Html->link('Passive', ['controller' => 'subjects', 'action' => 'relations', $subject->id, 'passive']); ?>
      </li>
      <li role="presentation"<? if ($second_type == 'none') { echo ' class="active"'; } ?>>
          <?= $this->Html->link('None', ['controller' => 'subjects', 'action' => 'relations', $subject->id, 'none']); ?>
      </li>
    </ul>

    <div class="related">
        <?= $this->element('subject_boxes', ['subject' => $subject, 'relations' => $subject->passives]) ?>
    </div>
    <hr>
    <div class="related">
        <?= $this->element('subject_boxes', ['subject' => $subject, 'relations' => $subject->actives, 'isPassive' => true]) ?>
    </div>
  </div>

</div>
