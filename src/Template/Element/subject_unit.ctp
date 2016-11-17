<?
 if (isset($subject_name)) {
   $type = 1;
   $name = $subject_name;
 } elseif (isset($object_name)) {
   $type = 2;
   $name = $object_name;
 }
?>
<div class="card subject-card">
  <?= $this->SubjectTool->imageLink($relation_object, ['width' => '100%', 'height' => '120px', 'class' => 'card-img-top']) ?>
  <div class="card-block">
    <h4 class="card-title">
        <?= $this->SubjectTool->buildRelationText($relation_object, $name, $relation_text, $type) ?>
    </h4>
<? /*
    <?= $this->Html->link('Edit relation', ['controller' => 'relations', 'action' => 'edit', $relation_id],
			     ['class' => 'btn btn-primary']); ?>
*/ ?>

  </div>
</div>