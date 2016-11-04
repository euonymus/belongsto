<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Subject'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Relations'), ['controller' => 'Relations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Relation'), ['controller' => 'Relations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="subjects index large-9 medium-8 columns content">
    <h3><?= __('Subjects') ?></h3>


    <?= $this->Form->create() ?>
<?
   $options = [];
?>
   <? foreach ($subjects as $subject): ?>
   <?
      $html = $subject->name.'<p>Active Relation</p><ul>';
      foreach ($subject->actives as $active):
         $relation = json_decode($active);
         $html .= '<li>'. $relation->name .'</li>';
      endforeach;
      $html .= '</ul>';

      $arr = ['value' => $subject->id, 'text' => $html];
      $options[] = $arr;
   ?>
   <?php endforeach; ?>
<?
   $options[] = ['value' => 0, 'text' => '新規追加'];
   echo $this->Form->radio('passive_id', $options, ['escape' => false]);
?>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
