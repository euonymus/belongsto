<? if ($this->Page->isRelation()): ?>
    <li><?= $this->Form->postLink(
				  __('Delete Relation'),
				  ['action' => 'delete', $relation->id],
				  ['confirm' => __('Are you sure you want to delete # {0}?', $relation->id)])
       ?></li>
<? endif; ?>
