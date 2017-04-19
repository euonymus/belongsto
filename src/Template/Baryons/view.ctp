<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Baryon'), ['action' => 'edit', $baryon->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Baryon'), ['action' => 'delete', $baryon->id], ['confirm' => __('Are you sure you want to delete # {0}?', $baryon->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Baryons'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Baryon'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="baryons view large-9 medium-8 columns content">
    <h3><?= h($baryon->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($baryon->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($baryon->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $baryon->has('user') ? $this->Html->link($baryon->user->id, ['controller' => 'Users', 'action' => 'view', $baryon->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($baryon->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($baryon->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($baryon->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Oneway') ?></th>
            <td><?= $baryon->is_oneway ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Private') ?></th>
            <td><?= $baryon->is_private ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
