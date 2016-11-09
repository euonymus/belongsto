<div class="subjects index large-9 medium-8 columns content">
    <h3><?= __('Subjects') ?></h3>
    <?= $this->Html->link(__('New Subject'), ['controller' => 'subjects', 'action' => 'add']) ?>





    <?php foreach ($subjects as $subject): ?>
    <div class="small-offset-1 panel">
    <? if (!empty($subject->image_path)): $image_path = $subject->image_path; ?>
    <? else: $image_path = '/img/no_image.jpg'; ?>
    <? endif; ?>
       <?= $this->Html->link($this->Html->image($image_path, ['width' => '100px', 'height' => '100px']),
			     ['controller' => 'subjects', 'action' => 'relations', $subject->id],
			     ['escape' => false]) ?>
       <?= $this->Html->link($subject->name, ['controller' => 'subjects', 'action' => 'relations', $subject->id]) ?>
    </div>

    <? endforeach; ?>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
