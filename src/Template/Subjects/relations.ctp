<div class="row">

  <div class="col-md-3">
    <h1><?= h($subject->name) ?></h1>

    <? if (!empty($subject->image_path)): $image_path = $subject->image_path; ?>
       <?= $this->Html->link($this->Html->image($image_path, ['width' => '100px', 'height' => '100px']),
			     ['controller' => 'subjects', 'action' => 'relations', $subject->id],
			     ['escape' => false]) ?>
    <? endif; ?>

    <p><?= h($subject->description) ?></p>
    <p><?= $this->Html->link(__('Add relation'), ['controller' => 'relations', 'action' => 'add', $subject->id]) ?></p>
  </div>

  <div class="col-md-9">
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
