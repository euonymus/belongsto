<? if ($this->Page->isSubject()): ?>
    <li><?= $this->Html->link(__('Edit Subject'), ['controller' => 'Subjects', 'action' => 'edit', $subject->id]) ?></li>
    <li><?= $this->Form->postLink(
                                 __('Delete'),
                                 ['action' => 'delete', $subject->id],
                                 ['confirm' => __('Are you sure you want to delete # {0}?', $subject->id)]
            )
        ?></li>
<? endif; ?>
