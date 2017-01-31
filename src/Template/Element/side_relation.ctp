<? if ($this->Page->isRelation()): ?>
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gluon <span class="caret"></span></a>
      <ul class="dropdown-menu">
         <li><?= $this->Html->link(__('Edit Gluon'), ['controller' => 'Relations', 'action' => 'edit', $relation->id]) ?></li>
         <li><?= $this->Form->postLink(
				  __('Delete Gluon'),
				  ['action' => 'delete', $relation->id],
				  ['confirm' => __('Are you sure you want to delete # {0}?', $relation->id)])
       ?></li>
      </ul>
    </li>
<? endif; ?>
