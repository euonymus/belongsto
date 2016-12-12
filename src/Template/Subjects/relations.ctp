<div class="row">
  <div class="col-md-3 card subject-main">
    <div class="subject-image">
        <?= $this->SubjectTool->imageLink($subject, ['class' => 'card-img-top']) ?>
    </div>
    <div class="card-block">
      <h1 class="card-title"><?= h($subject->name) ?></h1>
    </div>
    <p><?= h($subject->description) ?></p>

<? if (!empty($subject->url)): ?>
    <p><?= $this->Html->link('<img src="/img/url_button.png" style="width:50px;border:0px;" >', $subject->url,
			     ['target' => '_blank', 'escape' => false]); ?></p>
<? endif; ?>
    <p><?= $this->Html->link('Add relation', ['controller' => 'relations', 'action' => 'add', $subject->id],
			     ['class' => 'btn btn-primary']); ?></p>
  </div>

  <div class="col-md-9 subject-relation-list">

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
