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


        <div>
            <p><?= $this->Html->link('Back to gluon', ['controller' => 'subjects', 'action' => 'relations', $subject->id]
			     ); ?></p>
        </div>
    </div>
  </div>

  <div class="col-md-9 subject-relation-list">

    <ul class="nav nav-pills">
      <li role="presentation"<? if ($second_type == 'active') { echo ' class="active"'; } ?>>
          <?= $this->Html->link('Active', ['controller' => 'baryons', 'action' => 'relations', $baryon->id, $subject->id, 'active']); ?>
      </li>
      <li role="presentation"<? if ($second_type == 'passive') { echo ' class="active"'; } ?>>
          <?= $this->Html->link('Passive', ['controller' => 'baryons', 'action' => 'relations', $baryon->id, $subject->id, 'passive']); ?>
      </li>
      <li role="presentation"<? if ($second_type == 'none') { echo ' class="active"'; } ?>>
          <?= $this->Html->link('None', ['controller' => 'baryons', 'action' => 'relations', $baryon->id, $subject->id, 'none']); ?>
      </li>
    </ul>

<? if ($subject->passives): ?>
    <h2><?
   $en = 'What is ' . $subject->name . '?';
   $ja = $subject->name . 'とは';
   echo $this->LangMngr->txt($en, $ja);
?></h2>
    <div class="related">
        <?= $this->element('subject_boxes', ['subject' => $subject, 'relations' => $subject->passives]) ?>
    </div>
<? endif; ?>

<? if ($subject->actives): ?>
    <h2><?
   $en = 'Quarks Related to ' . $subject->name . '?';
   $ja = $subject->name . 'に関する事項';
   echo $this->LangMngr->txt($en, $ja);
?></h2>
    <div class="related">
        <?= $this->element('subject_boxes', ['subject' => $subject, 'relations' => $subject->actives, 'isPassive' => true]) ?>
    </div>
<? endif; ?>

  </div>

</div>
