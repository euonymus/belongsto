<? if ($this->Page->isSubject()): ?>
    <li><?= $this->Html->link(__('Add relation'), ['controller' => 'relations', 'action' => 'add', $subject->id]) ?></li>
    <li><?= $this->Html->link(__('Edit Quark'), ['controller' => 'Subjects', 'action' => 'edit', $subject->id]) ?></li>
    <li><?= $this->Form->postLink(
                                 __('Delete'),
                                 ['action' => 'delete', $subject->id],
                                 ['confirm' => __('Are you sure you want to delete # {0}?', $subject->id)]
            )
        ?></li>
<? endif; ?>
