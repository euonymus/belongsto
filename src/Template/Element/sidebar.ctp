<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>


        <?= $this->element('side_search') ?>

        <li><?= $this->Html->link(__('New Subject'), ['controller' => 'Subjects', 'action' => 'add']) ?></li>

        <?= $this->element('side_subject') ?>

        <?= $this->element('side_relation') ?>
    </ul>
</nav>
