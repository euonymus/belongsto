<?
  if (!isset($isPassive)) $isPassive = false;
  if ($isPassive) {
    $type = 2;
  } else {
    $type = 1;
  }
?>
<?php if (!empty($relations)): ?>
<div class="well subject-relation <? if ($type == 1) echo 'white'; ?>">
<?php foreach ($relations as $key => $relation): ?>
    <? if($key != 0) echo '<hr>'; ?>

<? if (!isset($isPassive)) $isPassive = false; ?>
<?= $this->element('subject_box', compact(['subject', 'relation', 'isPassive'])) ?>

<?php endforeach; ?>
</div>
<?php endif; ?>
