<div class="">
    <h2>Adding new gluon on <?= $active->name ?></h2>
</div>
<div>
    <?= $this->Form->create($relation) ?>
    <fieldset>
        <legend><?= __('Add New Gluon') ?></legend>
        <div class="form-group">
        <?
            echo $this->Form->input('passive', ['type' => 'text', 'class' => 'form-control']);
            echo $this->Form->input('relation', ['class' => 'form-control']);
            echo $this->Form->input('start', ['empty' => true]);
            echo $this->Form->input('end', ['empty' => true]);
            echo $this->Form->input('start_accuracy', ['class' => 'form-control']);
            echo $this->Form->input('end_accuracy', ['class' => 'form-control']);
            echo $this->Form->input('is_momentary');

        ?>
        </div>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>

    <?= $this->Form->end() ?>
</div>
