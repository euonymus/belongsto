<div class="subjects form large-9 medium-8 columns content">
    <?= $this->Form->create($subject) ?>
    <fieldset>
        <legend><?= __('Add Subject') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('image_path');
            echo $this->Form->input('description');
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
