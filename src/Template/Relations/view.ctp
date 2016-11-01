<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Relation'), ['action' => 'edit', $relation->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Relation'), ['action' => 'delete', $relation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $relation->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Relations'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Relation'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Subjects'), ['controller' => 'Subjects', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Subject'), ['controller' => 'Subjects', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="relations view large-9 medium-8 columns content">
    <h3><?= h($relation->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($relation->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Subject') ?></th>
            <td><?= $relation->has('subject') ? $this->Html->link($relation->subject->name, ['controller' => 'Subjects', 'action' => 'view', $relation->subject->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Object Id') ?></th>
            <td><?= h($relation->object_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Relation') ?></th>
            <td><?= h($relation->relation) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start Accuracy') ?></th>
            <td><?= h($relation->start_accuracy) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('End Accuracy') ?></th>
            <td><?= h($relation->end_accuracy) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start') ?></th>
            <td><?= h($relation->start) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('End') ?></th>
            <td><?= h($relation->end) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($relation->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($relation->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Momentary') ?></th>
            <td><?= $relation->is_momentary ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
