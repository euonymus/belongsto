<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Baryon'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="baryons index large-9 medium-8 columns content">
    <h3><?= __('Baryons') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('description') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_oneway') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_private') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($baryons as $baryon): ?>
            <tr>
                <td><?= $this->Number->format($baryon->id) ?></td>
                <td><?= h($baryon->name) ?></td>
                <td><?= h($baryon->description) ?></td>
                <td><?= h($baryon->is_oneway) ?></td>
                <td><?= h($baryon->is_private) ?></td>
                <td><?= $baryon->has('user') ? $this->Html->link($baryon->user->id, ['controller' => 'Users', 'action' => 'view', $baryon->user->id]) : '' ?></td>
                <td><?= h($baryon->created) ?></td>
                <td><?= h($baryon->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $baryon->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $baryon->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $baryon->id], ['confirm' => __('Are you sure you want to delete # {0}?', $baryon->id)]) ?>
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
