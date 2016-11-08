<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>

   <?= $this->Form->create(NULL, ['url' => '/subjects/search', 'method' => 'get']) ?>
    <fieldset>
        <?= $this->Form->input('keywords', ['label' => false, 'placeholder'=>'Search']) ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>


        <li><?= $this->Html->link(__('New Subject'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Relations'), ['controller' => 'Relations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Relation'), ['controller' => 'Relations', 'action' => 'add']) ?></li>
    </ul>
</nav>
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
