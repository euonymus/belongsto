<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Relation'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Subjects'), ['controller' => 'Subjects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Subject'), ['controller' => 'Subjects', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="relations index large-9 medium-8 columns content">
    <h3><?= __('Relations') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('subject_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('object_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('relation') ?></th>
                <th scope="col"><?= $this->Paginator->sort('start') ?></th>
                <th scope="col"><?= $this->Paginator->sort('end') ?></th>
                <th scope="col"><?= $this->Paginator->sort('start_accuracy') ?></th>
                <th scope="col"><?= $this->Paginator->sort('end_accuracy') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_momentary') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($relations as $relation): ?>
            <tr>
                <td><?= h($relation->id) ?></td>
                <td><?= $relation->has('subject') ? $this->Html->link($relation->subject->name, ['controller' => 'Subjects', 'action' => 'view', $relation->subject->id]) : '' ?></td>
                <td><?= $relation->has('object') ? $this->Html->link($relation->object->name, ['controller' => 'Subjects', 'action' => 'view', $relation->subject->id]) : '' ?></td>
                <td><?= h($relation->relation) ?></td>
                <td><?= h($relation->start) ?></td>
                <td><?= h($relation->end) ?></td>
                <td><?= h($relation->start_accuracy) ?></td>
                <td><?= h($relation->end_accuracy) ?></td>
                <td><?= h($relation->is_momentary) ?></td>
                <td><?= h($relation->created) ?></td>
                <td><?= h($relation->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $relation->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $relation->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $relation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $relation->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
