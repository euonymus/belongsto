<div class="card">
  <?= $this->SubjectTool->imageLink($relation_object, ['width' => '100%', 'height' => '120px', 'class' => 'card-img-top']) ?>
  <div class="card-block">
    <h4 class="card-title">
    <? if (isset($subject_name)): ?>
        <?= $subject_name ?>は <?= $this->SubjectTool->link($relation_object->name, $relation_object->id) ?>
    <? elseif (isset($object_name)): ?>
        <?= $this->SubjectTool->link($relation_object->name, $relation_object->id) ?> は<?= $object_name ?>
    <? endif; ?>
    <?= $relation_text ?>
    </h4>
<? /*
    <?= $this->Html->link('Edit relation', ['controller' => 'relations', 'action' => 'edit', $relation_id],
			     ['class' => 'btn btn-primary']); ?>
*/ ?>

  </div>
</div>