<div>
    <?= $this->Form->create($subject) ?>
    <fieldset>
        <legend><?= __('Edit Quark') ?></legend>
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

            // This is ugly, I know. START ======================================
            //echo $this->Form->input('start', ['empty' => true]);
            //echo $this->Form->input('end', ['empty' => true]);
        ?>
        <div class="input text">
        <? if (is_string($subject->start) || is_null($subject->start)): ?>
            <label for="url">Start</label>
            <input type='date' class="form-control date" name="start"<? if (array_key_exists('start', $this->request->data)) {
		echo ' value="' . $this->request->data['start'] . '"'; } ?>>
            <label for="url">End</label>
            <input type='date' class="form-control date" name="end"<? if (array_key_exists('end', $this->request->data)) {
	        echo ' value="' . $this->request->data['end'] . '"'; } ?>>
        <? else: ?>
            <label for="url">Start</label>
            <input type='date' class="form-control date" name="start" value="<?= $subject->start->format('Y-m-d') ?>">
            <label for="url">End</label>
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
        ?>
        </div>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>

    <?= $this->Form->end() ?>
</div>
