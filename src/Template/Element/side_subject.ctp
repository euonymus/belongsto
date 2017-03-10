<? if ($this->Page->isSubject() && isset($subject)): ?>
  <? if (!$subject->is_exclusive || ($auth->user('id') == $subject->user_id)): ?>
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Quark <span class="caret"></span></a>
      <ul class="dropdown-menu">
          <li><?= $this->Html->link(__('Edit Quark'), ['controller' => 'Subjects', 'action' => 'edit', $subject->id]) ?></li>
          <li><?= $this->Form->postLink(
                                 __('Delete'),
                                 ['action' => 'delete', $subject->id],
                                 ['confirm' => __('Are you sure you want to delete # {0}?', $subject->id)]
            )
        ?></li>
      </ul>
    </li>
 <? endif; ?>
<? endif; ?>
