<div class="subject-list-box">
    <h1><?= h($title) ?></h1>

    <nav class="large-3 medium-4 columns" id="actions-sidebar">
        <ul class="side-nav">
            <li><?= $this->Html->link(__('New Baryon'), ['action' => 'add']) ?></li>
        </ul>
    </nav>

    <? foreach ($baryons as $baryon): ?>
        <div class="well row">
          <div class="col-xs-3">
            <?= $this->Html->link($baryon->name, ['action' => 'view', $baryon->id]) ?>
          </div>
          <div class="col-xs-9">
            <?= h($baryon->description) ?>
          </div>
        </div>

<? /*
        <div class="media subject-list-main">
          <div class="media-left">
            <?= $this->SubjectTool->imageLink($subject) ?>
          </div>
          <div class="media-body">
            <h4 class="media-heading"><?= $this->SubjectTool->link($baryon->name, $baryon->id) ?></h4>
            <?= $baryon->description ?>
          </div>
        </div>
*/ ?>
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
