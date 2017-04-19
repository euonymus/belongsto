<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Baryon'), ['action' => 'edit', $baryon->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Baryon'), ['action' => 'delete', $baryon->id], ['confirm' => __('Are you sure you want to delete # {0}?', $baryon->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Baryons'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Baryon'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="baryons view large-9 medium-8 columns content">
    <h3><?= h($baryon->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($baryon->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($baryon->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $baryon->has('user') ? $this->Html->link($baryon->user->id, ['controller' => 'Users', 'action' => 'view', $baryon->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($baryon->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($baryon->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($baryon->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Oneway') ?></th>
            <td><?= $baryon->is_oneway ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Private') ?></th>
            <td><?= $baryon->is_private ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>



<div class="row">
  <div class="col-md-3 card subject-main">


<? if (!empty($subject->image_path)): ?>
    <div class="subject-image">
        <img src="<?= $this->SubjectTool->imagePath($subject->image_path) ?>" class="card-img-top">
   
<? /*
        <?= $this->SubjectTool->imageLink($subject, ['class' => 'card-img-top']) ?>
        <div class="main-image" style="background-image:url(<?= $subject->image_path ?>);"></div>
*/ ?>
    </div>
<? endif; ?>


    <div class="card-block">
      <h1 class="card-title"><?= h($subject->name) ?>
<? if (!empty($subject->url)): ?>
          <sub>
              <?= $this->Html->link('', $subject->url, ['target' => '_blank', 'class' => "glyphicon glyphicon-globe"]); ?>
          </sub>
<? endif; ?>
      </h1>
      <p><?= $this->SubjectTool->period($subject) ?></p>
      <p><?= h($subject->description) ?></p>

   <? if ($subject->last_modified_user['role'] != 'admin'): ?>
      <p>edited by <?= $subject->last_modified_user['username'] ?></p>
   <? endif; ?>

<? /* if (!empty($subject->url)): ?>
    <p><?= $this->Html->link('<img src="/img/url_button.png" style="width:50px;border:0px;" >', $subject->url,
			     ['target' => '_blank', 'escape' => false]); ?></p>
<? endif; */ ?>
<? if (!empty($subject->affiliate)): ?>
    <p><?= $this->Html->link($this->SubjectTool->buynow(), $subject->affiliate, ['target' => '_blank']); ?></p>
<? endif; ?>
    <p><?= $this->Html->link('Add relation', ['controller' => 'relations', 'action' => 'add', $subject->id],
			     ['class' => 'btn btn-primary']); ?></p>
    </div>
  </div>

  <div class="col-md-9 subject-relation-list">
    <h2><?
   $en = 'Quarks Related to ' . $subject->name;
   $ja = $subject->name . 'と関係する事柄';
   echo $this->LangMngr->txt($en, $ja);
?></h2>

    <ul class="nav nav-pills">
      <li role="presentation"<? if ($second_type == 'active') { echo ' class="active"'; } ?>>
          <?= $this->Html->link('Active', ['controller' => 'subjects', 'action' => 'relations', $subject->id, 'active']); ?>
      </li>
      <li role="presentation"<? if ($second_type == 'passive') { echo ' class="active"'; } ?>>
          <?= $this->Html->link('Passive', ['controller' => 'subjects', 'action' => 'relations', $subject->id, 'passive']); ?>
      </li>
      <li role="presentation"<? if ($second_type == 'none') { echo ' class="active"'; } ?>>
          <?= $this->Html->link('None', ['controller' => 'subjects', 'action' => 'relations', $subject->id, 'none']); ?>
      </li>
    </ul>

    <div class="related">
        <?= $this->element('subject_boxes', ['subject' => $subject, 'relations' => $subject->passives]) ?>
    </div>
    <hr>
    <div class="related">
        <?= $this->element('subject_boxes', ['subject' => $subject, 'relations' => $subject->actives, 'isPassive' => true]) ?>
    </div>
  </div>

</div>
