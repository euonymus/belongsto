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
