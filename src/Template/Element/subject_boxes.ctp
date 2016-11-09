<?php if (!empty($relations)): ?>
<?php foreach ($relations as $relation): ?>

<? if (!isset($isPassive)) $isPassive = false; ?>
<?= $this->element('subject_box', compact(['subject', 'relation', 'isPassive'])) ?>

<?php endforeach; ?>
<?php endif; ?>
