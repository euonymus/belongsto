<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>


        <?= $this->element('side_search') ?>


        <li><?= $this->Html->link(__('New Subject'), ['controller' => 'Subjects', 'action' => 'add']) ?></li>


<?
   if (($this->request->params['controller'] == 'Subjects') && 
       (($this->request->params['action'] == 'relations') || ($this->request->params['action'] == 'edit'))):
?>
        <li><?= $this->Html->link(__('Edit Subject'), ['controller' => 'Subjects', 'action' => 'edit', $subject->id]) ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $subject->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $subject->id)]
            )
        ?></li>
<? endif; ?>





    </ul>
</nav>
