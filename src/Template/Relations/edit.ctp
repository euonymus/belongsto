<div class="">
    <h2>Editing gluon</h2>
</div>
<div>
    <?= $this->Form->create($relation) ?>
    <fieldset>
        <legend><?= __('Edit Gluon') ?></legend>
        <div class="form-group">

   <? if ($lang_now == $lang_eng): ?>
        <h3>Relation between "<?= $relation->active->name ?>" and "<?= $relation->passive->name ?>" ...</h3>
        <hr>
   <?
            echo $this->Form->control('gluon_type_id', ['options' => $gluon_types, 'empty'=>'Select One']);
   ?>
        <?= $relation->active->name ?>
        <?= $this->Form->input('relation', ['class' => 'form-control', 'label' => false]) ?>
        <?= $relation->passive->name ?>
   <? else: ?>
        <h3>"<?= $relation->active->name ?>" と "<?= $relation->passive->name ?>" の関係</h3>
        <hr>
   <?
            echo $this->Form->control('gluon_type_id', ['options' => $gluon_types, 'empty'=>'選択してください']);
   ?>
        <?= $relation->active->name . ' は ' . $relation->passive->name . ' ...' ?>
        <?= $this->Form->input('relation', ['class' => 'form-control', 'label' => false]) ?>
   <? endif; ?>
        <?
            echo $this->Form->input('suffix', ['class' => 'form-control', 'label' => false]);

            // This is ugly, I know. START ======================================
            //echo $this->Form->input('start', ['empty' => true]);
            //echo $this->Form->input('end', ['empty' => true]);
        ?>
        <hr>
        <div class="input text">
            <label for="url">Start</label>
        <? if (is_string($relation->start) || is_null($relation->start)): ?>
            <input type='date' class="form-control date" name="start"<? if (array_key_exists('start', $this->request->data)) {
		echo ' value="' . $this->request->data['start'] . '"'; } ?>>
        <? else: ?>
            <input type='date' class="form-control date" name="start" value="<?= $relation->start->format('Y-m-d') ?>">
        <? endif; ?>


            <label for="url">End</label>
        <? if (is_string($relation->end) || is_null($relation->end)): ?>
            <input type='date' class="form-control date" name="end"<? if (array_key_exists('end', $this->request->data)) {
	        echo ' value="' . $this->request->data['end'] . '"'; } ?>>
        <? else: ?>
            <input type='date' class="form-control date" name="end" value="<?= $relation->end->format('Y-m-d') ?>">
        <? endif; ?>
        </div>
        <?
            // This is ugly, I know. END ======================================

            echo $this->Form->input('start_accuracy', ['class' => 'form-control']);
            echo $this->Form->input('end_accuracy', ['class' => 'form-control']);
            echo $this->Form->input('is_momentary');

        ?>
        </div>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>

    <?= $this->Form->end() ?>
</div>
