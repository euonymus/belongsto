<div class="subjects index large-9 medium-8 columns content">
    <h3><?= __('Subjects') ?></h3>
    <?php foreach ($subjects as $subject): ?>

    <div class="small-offset-1 panel">

       <div class="left">
         <?= $this->SubjectTool->imageLink($subject) ?>
         <?= $this->SubjectTool->link($subject->name, $subject->id) ?>
       </div>
       <div class="left panel">
         Active Relations
       </div>
       <? foreach($subject->actives as $active): ?>
       <div class="left panel">
           <?= $this->SubjectTool->imageLink($active) ?>
           <?= $this->SubjectTool->link($active->name, $active->id) ?>
       </div>
       <? endforeach; ?>
       <div style="clear:both"></div>

    </div>

    <?php endforeach; ?>

</div>
