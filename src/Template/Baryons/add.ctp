<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Baryons'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="baryons form large-9 medium-8 columns content">
    <?= $this->Form->create($baryon) ?>
    <fieldset>
        <legend><?= __('Add Baryon') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('description');
            echo $this->Form->input('is_oneway');
            echo $this->Form->input('is_private');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
