<div class="subjects view large-9 medium-8 columns content">
    <h3><?= h($subject->name) ?></h3>

    <? if (!empty($subject->image_path)): $image_path = $subject->image_path; ?>
       <?= $this->Html->link($this->Html->image($image_path, ['width' => '100px', 'height' => '100px']),
			     ['controller' => 'subjects', 'action' => 'relations', $subject->id],
			     ['escape' => false]) ?>
    <? endif; ?>

    <p><?= h($subject->description) ?></p>
    <p><?= $this->Html->link(__('Add relation'), ['controller' => 'relations', 'action' => 'add', $subject->id]) ?></p>



    <div class="related">
        <h4><?= __('Active Relations') ?></h4>
        <?php if (!empty($subject->passives)): ?>


<?php foreach ($subject->passives as $relations): ?>
    <div class="panel">

    <? if (!empty($relations->image_path)): $image_path = $relations->image_path; ?>
    <? else: $image_path = '/img/no_image.jpg'; ?>
    <? endif; ?>
    <div class="panel no-border">
        <?= $this->Html->link($this->Html->image($image_path, ['width' => '100px', 'height' => '100px']),
			     ['controller' => 'subjects', 'action' => 'relations', $relations->id],
			     ['escape' => false]) ?>

        <?= $subject->name ?>は
             <?= $this->Html->link($relations->name, ['controller' => 'subjects', 'action' => 'relations', $relations->id]) ?>
             <?= $relations->_joinData->relation ?>
    </div>


<?php foreach ($relations->relation as $passive2): ?>
   <? if ($subject->id == $passive2->active_id) continue; ?>

    <div class="panel left">
    <? if (!empty($passive2->active->image_path)): $image_path = $passive2->active->image_path; ?>
    <? else: $image_path = '/img/no_image.jpg'; ?>
    <? endif; ?>
   <?= $this->Html->link($this->Html->image($image_path, ['width' => '100px', 'height' => '100px']),
			     ['controller' => 'subjects', 'action' => 'relations', $passive2->active->id],
			     ['escape' => false]) ?>

   <?= $this->Html->link($passive2->active->name, ['controller' => 'subjects', 'action' => 'relations', $passive2->active->id]) ?>
   は<?= $relations->name ?> <?= $passive2->relation ?>

   </div>
<?php endforeach; ?>
   <div style="clear:both"></div>
   </div>
<?php endforeach; ?>

        <?php endif; ?>
    </div>


    <div class="related">
        <h4><?= __('Passive Relations') ?></h4>
        <?php if (!empty($subject->actives)): ?>

<?php foreach ($subject->actives as $relations): ?>

<div><?= $relations->name ?>は<?= $subject->name ?><?= $relations->_joinData->relation ?></div>
<?php foreach ($relations->relation as $active2): ?>
   <?= $active2->active->name ?>は<?= $relations->name ?> <?= $active2->relation ?>
<?php endforeach; ?>
<br>
<br>
<?php endforeach; ?>

        <?php endif; ?>
    </div>



</div>
