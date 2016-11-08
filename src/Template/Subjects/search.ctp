<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Subject'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Relations'), ['controller' => 'Relations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Relation'), ['controller' => 'Relations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="subjects index large-9 medium-8 columns content">
    <h3><?= __('Subjects') ?></h3>
    <?php foreach ($subjects as $subject): ?>

    <div class="small-offset-1 panel">
    <? if (!empty($subject->image_path)): $image_path = $subject->image_path; ?>
    <? else: $image_path = '/img/no_image.jpg'; ?>
    <? endif; ?>

       <div class="left">
           <?= $this->Html->link($this->Html->image($image_path, ['width' => '100px', 'height' => '100px']),
			     ['controller' => 'subjects', 'action' => 'relations', $subject->id],
			     ['escape' => false]) ?>
           <?= $this->Html->link($subject->name, ['controller' => 'subjects', 'action' => 'relations', $subject->id]) ?>
       </div>
       <div class="left panel">
         Active Relations
       </div>
       <? foreach($subject->actives as $active): ?>
       <div class="left panel">
           <?= $this->Html->link($active->name, ['controller' => 'subjects', 'action' => 'relations', $active->id]) ?>
       </div>
       <? endforeach; ?>
       <div style="clear:both"></div>


    </div>

    <?php endforeach; ?>



    <table cellpadding="0" cellspacing="0">
        <tbody>
            <?php foreach ($subjects as $subject): ?>
            <tr>
                <td><?= h($subject->id) ?></td>
                <td><?= h($subject->name) ?></td>
                <td><?= h($subject->image_path) ?></td>
                <td><?= h($subject->description) ?></td>
                <td><?= h($subject->start) ?></td>
                <td><?= h($subject->end) ?></td>
                <td><?= h($subject->start_accuracy) ?></td>
                <td><?= h($subject->end_accuracy) ?></td>
                <td><?= h($subject->is_momentary) ?></td>
                <td><?= h($subject->created) ?></td>
                <td><?= h($subject->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $subject->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $subject->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $subject->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subject->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
