<div class="panel no-border">
    <?= $this->SubjectTool->imageLink($relation_object) ?>

    <? if (isset($subject_name)): ?>
        <?= $subject_name ?>は <?= $this->SubjectTool->link($relation_object->name, $relation_object->id) ?>
    <? elseif (isset($object_name)): ?>
        <?= $this->SubjectTool->link($relation_object->name, $relation_object->id) ?> は<?= $object_name ?>
    <? endif; ?>

    <?= $relation_text ?>
</div>
