<div class="relations form large-9 medium-8 columns content">
    <?= $this->Form->create($relation) ?>
    <fieldset>
        <legend><?= __('Edit Relation') ?></legend>
        <?php
            echo $this->Form->input('active_id', ['options' => $subjects]);
            echo $this->Form->input('passive_id');
            echo $this->Form->input('relation');

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

            echo $this->Form->input('start_accuracy');
            echo $this->Form->input('end_accuracy');
            echo $this->Form->input('is_momentary');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
