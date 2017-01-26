<div class="subject-list-box">
    <h1><?= h($title) ?></h1>

    <?= $this->Form->create() ?>
    <div>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
    </div>
    <fieldset>
<?
   $options = [];
   $options[] = ['value' => 0, 'text' => '新規追加'];
?>

   <? foreach ($subjects as $subject): ?>
   <?
      $html = $subject->name.'<p>Active Relation</p><ul>';
      foreach ($subject->actives as $active):
         $relation = json_decode($active);
         $html .= '<li>'. $relation->name .'</li>';
      endforeach;
      $html .= '</ul>';


      $html = 
    '<b>このQuarkと関連付ける</b><div class="well subject-list">
        <div class="media subject-list-main">
          <div class="media-left">'. $this->SubjectTool->imageLink($subject) .'</div>
          <div class="media-body">
            <h4 class="media-heading">'. $this->SubjectTool->link($subject->name, $subject->id) . '</h4>'.
              $subject->description .
          '</div>
        </div>';

if (!empty($subject->actives)) {
        $html .= 
        '<div class="subject-list-sub">
          <h4>secondary relations</h4>
          <ul>';
    foreach($subject->actives as $active) {
         $html .=
              '<li class="subject-list-relation">'. $this->SubjectTool->buildRelationText($active,
				  $subject->name, $active->_joinData->relation, $active->_joinData->suffix, 2) . '</li>';
    }
        $html .=
          '</ul>
        </div>';
}
        $html .= '</div>';

      $arr = ['value' => $subject->id, 'text' => $html];
      $options[] = $arr;
?>
   <?php endforeach; ?>


<?
echo $this->Form->radio('passive_id', $options, ['escape' => false]);
?>
    </fieldset>
    <?= $this->Form->end() ?>
</div>
