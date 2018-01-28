<div class="">
    <h2>Adding new gluon on <?= $active->name ?></h2>
</div>
<div>
    <?= $this->Form->create($relation) ?>
    <fieldset>
        <legend><?= __('Add New Gluon') ?></legend>
        <div class="form-group">
        <?
            echo $this->Form->control('gluon_type_id', ['options' => $gluon_types, 'empty'=>'選択してください']);
            echo '<br>';
            echo $this->Form->input('passive', ['type' => 'text', 'class' => 'form-control']);
            echo $this->Form->input('relation', ['class' => 'form-control']);
            echo $this->Form->input('suffix', ['class' => 'form-control']);

            // This is ugly, I know. START ======================================
            //echo $this->Form->input('start', ['empty' => true]);
            //echo $this->Form->input('end', ['empty' => true]);
        ?>
        <div class="input text">
            <label for="url">Start</label>
            <input type='date' class="form-control date" name="start"<? if (array_key_exists('start', $this->request->data)) {
		  echo ' value="' . $this->request->data['start'] . '"'; } ?>>
            <label for="url">End</label>
            <input type='date' class="form-control date" name="end"<? if (array_key_exists('end', $this->request->data)) {
	          echo ' value="' . $this->request->data['end'] . '"'; } ?>>
        </div>
        <?
            // This is ugly, I know. END ======================================

            echo $this->Form->input('start_accuracy', ['class' => 'form-control']);
            echo $this->Form->input('end_accuracy', ['class' => 'form-control']);
            echo $this->Form->input('is_momentary');

            if ($auth->user('role') == 'admin') {
	      echo $this->Form->input('is_exclusive', ['type' => 'checkbox', 'checked' => true]);
	    }
        ?>
        </div>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>

    <?= $this->Form->end() ?>
</div>
