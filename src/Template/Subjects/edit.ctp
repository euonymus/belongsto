<div>
    <?= $this->Form->create($subject) ?>
    <fieldset>
        <legend><?= __('Edit Quark') ?></legend>
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
        <? if (is_string($subject->start) || is_null($subject->start)): ?>
            <input type='date' class="form-control date" name="start"<? if (array_key_exists('start', $this->request->data)) {
		echo ' value="' . $this->request->data['start'] . '"'; } ?>>
        <? else: ?>
            <input type='date' class="form-control date" name="start" value="<?= $subject->start->format('Y-m-d') ?>">
        <? endif; ?>


            <label for="url">End</label>
        <? if (is_string($subject->end) || is_null($subject->end)): ?>
            <input type='date' class="form-control date" name="end"<? if (array_key_exists('end', $this->request->data)) {
	        echo ' value="' . $this->request->data['end'] . '"'; } ?>>
        <? else: ?>
            <input type='date' class="form-control date" name="end" value="<?= $subject->end->format('Y-m-d') ?>">
        <? endif; ?>
        </div>
        <?
            // This is ugly, I know. END  ======================================

            echo $this->Form->input('start_accuracy', ['class' => 'form-control']);
            echo $this->Form->input('end_accuracy', ['class' => 'form-control']);
            echo $this->Form->input('is_momentary');
            echo $this->Form->input('url', ['class' => 'form-control']);
            echo $this->Form->input('affiliate', ['class' => 'form-control']);
            echo '<br>';
            //echo $this->Form->input('is_person', ['type' => 'checkbox']);
            echo $this->Form->control('quark_type_id', ['options' => $quark_types]);
            echo $this->Form->input('is_private', ['type' => 'checkbox']);
        ?>
        </div>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>

    <?= $this->Form->end() ?>
</div>
