<div>
    <?= $this->Form->create($subject) ?>
    <fieldset>
        <legend><?= __('Add New Quark') ?></legend>
        <div class="form-group">
        <?
            echo $this->Form->input('name', ['class' => 'form-control']);
            echo $this->Form->input('image_path', ['class' => 'form-control']);
        ?>
        </div>
        <div class="form-group">
        <h4>optional</h4>
        <?
            echo $this->Form->input('description', ['class' => 'form-control']);
            echo $this->Form->input('start', ['empty' => true]);
            echo $this->Form->input('end', ['empty' => true]);
            echo $this->Form->input('start_accuracy', ['class' => 'form-control']);
            echo $this->Form->input('end_accuracy', ['class' => 'form-control']);
            echo $this->Form->input('is_momentary');
            echo $this->Form->input('url', ['class' => 'form-control']);
            echo $this->Form->input('affiliate', ['class' => 'form-control']);
        ?>
        </div>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>

    <?= $this->Form->end() ?>
</div>
