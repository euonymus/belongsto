<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Subject'), ['action' => 'edit', $subject->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Subject'), ['action' => 'delete', $subject->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subject->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Subjects'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Subject'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Relations'), ['controller' => 'Relations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Relation'), ['controller' => 'Relations', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="subjects view large-9 medium-8 columns content">
    <h3><?= h($subject->name) ?></h3>
    <?= $this->Html->link(__('Add relation'), ['controller' => 'relations', 'action' => 'add', $subject->id]) ?>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($subject->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($subject->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Image Path') ?></th>
            <td><?= h($subject->image_path) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($subject->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start Accuracy') ?></th>
            <td><?= h($subject->start_accuracy) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('End Accuracy') ?></th>
            <td><?= h($subject->end_accuracy) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start') ?></th>
            <td><?= h($subject->start) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('End') ?></th>
            <td><?= h($subject->end) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($subject->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($subject->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Momentary') ?></th>
            <td><?= $subject->is_momentary ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Active Relations') ?></h4>
        <?php if (!empty($subject->actives)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('ImagePath') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Start') ?></th>
                <th scope="col"><?= __('End') ?></th>
                <th scope="col"><?= __('Start Accuracy') ?></th>
                <th scope="col"><?= __('End Accuracy') ?></th>
                <th scope="col"><?= __('Is Momentary') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($subject->actives as $relations): ?>
            <tr>
                <td><?= h($relations->id) ?></td>
                <td><?= h($relations->name) ?></td>
                <td><?= h($relations->image_path) ?></td>
                <td><?= h($relations->description) ?></td>
                <td><?= h($relations->start) ?></td>
                <td><?= h($relations->end) ?></td>
                <td><?= h($relations->start_accuracy) ?></td>
                <td><?= h($relations->end_accuracy) ?></td>
                <td><?= h($relations->is_momentary) ?></td>
                <td><?= h($relations->created) ?></td>
                <td><?= h($relations->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Relations', 'action' => 'view', $relations->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Relations', 'action' => 'edit', $relations->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Relations', 'action' => 'delete', $relations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $relations->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>

    <div class="related">
        <h4><?= __('Passive Relations') ?></h4>
        <?php if (!empty($subject->passives)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('ImagePath') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Start') ?></th>
                <th scope="col"><?= __('End') ?></th>
                <th scope="col"><?= __('Start Accuracy') ?></th>
                <th scope="col"><?= __('End Accuracy') ?></th>
                <th scope="col"><?= __('Is Momentary') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($subject->passives as $relations): ?>
            <tr>
                <td><?= h($relations->id) ?></td>
                <td><?= h($relations->name) ?></td>
                <td><?= h($relations->image_path) ?></td>
                <td><?= h($relations->description) ?></td>
                <td><?= h($relations->start) ?></td>
                <td><?= h($relations->end) ?></td>
                <td><?= h($relations->start_accuracy) ?></td>
                <td><?= h($relations->end_accuracy) ?></td>
                <td><?= h($relations->is_momentary) ?></td>
                <td><?= h($relations->created) ?></td>
                <td><?= h($relations->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Relations', 'action' => 'view', $relations->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Relations', 'action' => 'edit', $relations->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Relations', 'action' => 'delete', $relations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $relations->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
