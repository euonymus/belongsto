<div>
    <?= $this->Form->create($subject) ?>
    <fieldset>
        <legend><?= __('Add New Quark') ?></legend>
        <div class="form-group">
        <?
            echo $this->Form->input('name', ['class' => 'form-control']);
            echo $this->Form->input('image_path', ['class' => 'form-control']);
            echo $this->Form->control('auto_fill', ['type' => 'checkbox', 'checked' => true]);
        ?>
        </div>
        <div class="form-group">
        <h4>optional</h4>
        <?
            echo $this->Form->input('description', ['class' => 'form-control']);

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
            echo $this->Form->input('url', ['class' => 'form-control']);
            echo $this->Form->input('affiliate', ['class' => 'form-control']);
            echo '<br>';
            //echo $this->Form->input('is_person');
            echo $this->Form->control('quark_type_id', ['options' => $quark_types]);
            $checked = $auth->user('default_saving_privacy')?  true : false;
            echo $this->Form->input('is_private', ['type' => 'checkbox', 'checked' => $checked]);

            if ($auth->user('role') == 'admin') {
	      echo $this->Form->input('is_exclusive', ['type' => 'checkbox', 'checked' => true]);
	    }
        ?>
        </div>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>

    <?= $this->Form->end() ?>
</div>
