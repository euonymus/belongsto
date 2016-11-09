<div class="relations form large-9 medium-8 columns content">
    <?= $this->Form->create($relation) ?>
    <fieldset>
        <legend><?= __('Edit Relation') ?></legend>
        <?php
            echo $this->Form->input('active_id', ['options' => $subjects]);
            echo $this->Form->input('passive_id');
            echo $this->Form->input('relation');
            echo $this->Form->input('start', ['empty' => true]);
            echo $this->Form->input('end', ['empty' => true]);
            echo $this->Form->input('start_accuracy');
            echo $this->Form->input('end_accuracy');
            echo $this->Form->input('is_momentary');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
