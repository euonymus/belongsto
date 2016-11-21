<div class="row">
  <div class="col-md-3 card subject-main">
    <?= $this->SubjectTool->imageLink($subject, ['width' => '100%', 'height' => '120px', 'class' => 'card-img-top']) ?>
    <div class="card-block">
      <h1 class="card-title"><?= h($subject->name) ?></h1>
    </div>
    <p><?= h($subject->description) ?></p>
    <p><?= $this->Html->link('Add relation', ['controller' => 'relations', 'action' => 'add', $subject->id],
			     ['class' => 'btn btn-primary']); ?></p>
  </div>

  <div class="col-md-9 subject-relation-list">
    <div class="related">
        <h4><?= __('Active Relations') ?></h4>
        <?= $this->element('subject_boxes', ['subject' => $subject, 'relations' => $subject->passives]) ?>
    </div>

    <div class="related">
        <h4><?= __('Passive Relations') ?></h4>
        <?= $this->element('subject_boxes', ['subject' => $subject, 'relations' => $subject->actives, 'isPassive' => true]) ?>
    </div>
  </div>

</div>
