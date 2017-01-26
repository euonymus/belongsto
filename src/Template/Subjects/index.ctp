<div class="subject-list-box">
    <h1><?= h($title) ?></h1>
    <? foreach ($subjects as $subject): ?>
    <div class="well subject-list">

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
        <div class="subject-relation-sub">
          <h4>secondary relations</h4>
          <ul class="subject-list-relation">
              <? foreach($subject->actives as $active): ?>
              <li>
                <?= $this->SubjectTool->imageLink($active, ['width' => '40px', 'height' => '40px']) ?>
                <?= $this->SubjectTool->buildRelationText($active, $subject->name,
							  $active->_joinData->relation, $active->_joinData->suffix, 2) ?>
              </li>
              <? endforeach; ?>
          </ul>
        </div>
        <? endif; ?>

    </div>
    <? endforeach; ?>

    <? if (!$this->Page->isSearch()): ?>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
    <? endif; ?>

</div>
