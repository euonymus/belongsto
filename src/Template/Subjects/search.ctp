<div class="subject-list-box">
    <h1><?= h($title) ?></h1>
    <? foreach ($subjects as $subject): ?>
    <div class="panel subject-list">

        <div class="media subject-list-main">
          <div class="media-left">
            <?= $this->SubjectTool->imageLink($subject) ?>
          </div>
          <div class="media-body">
            <h4 class="media-heading"><?= $this->SubjectTool->link($subject->name, $subject->id) ?></h4>
            <?= $subject->description ?>
          </div>
        </div>

        <? if (!empty($subject->actives)): ?>
        <div class="subject-list-sub">
          <h4>secondary relations</h4>
          <ul>
              <? foreach($subject->actives as $active): ?>
              <li class="subject-list-relation"><?= $this->SubjectTool->buildRelationText($active,
						    $subject->name, $active->_joinData->relation, 2) ?></li>
              <? endforeach; ?>
          </ul>
        </div>
        <? endif; ?>

    </div>
    <? endforeach; ?>
</div>
