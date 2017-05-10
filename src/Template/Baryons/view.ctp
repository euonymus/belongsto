<div class="row">
  <div class="col-md-3 card subject-main">
    <div class="card-block">
      <h1 class="card-title"><?= h($baryon->name) ?></h1>
      <p><?= h($baryon->description) ?></p>
      <p>One way: <?= $baryon->is_oneway ? __('Yes') : __('No'); ?></p>
      <p>Private: <?= $baryon->is_private ? __('Yes') : __('No'); ?></p>
      <p>Created: <?= $baryon->created; ?></p>
      <p>Modified: <?= $baryon->modified; ?></p>
      <p><?= $this->Html->link('Edit', ['controller' => 'baryons', 'action' => 'edit', $baryon->id],
                                       ['class' => 'btn btn-primary']); ?></p>
      <p><?= $this->Html->link('back to list', ['action' => 'index']) ?></p>
    </div>
  </div>

  <div class="col-md-9 subject-relation-list">
    <h2><?
   $en = 'Gluons in ' . $baryon->name;
   $ja = $baryon->name . 'に付随するgluonの一覧';
   echo $this->LangMngr->txt($en, $ja);
?></h2>

    <div class="related">


<?php if (!empty($relations)): ?>
<div class="well subject-relation white">
<?php foreach ($relations as $key => $relation): ?>
    <? if($key != 0) echo '<hr>'; ?>


<div class="subject-relation">
    <div class="subject-relation-main">


        <div class="media">
          <div class="media-left subject-image">
             <?= $this->Html->link($this->Html->image($this->SubjectTool->imagePath($relation->active->image_path), ['width' => '100px', 'height' => '100px']), ['controller' => 'baryons', 'action' => 'relations', $baryon->id, $relation->active->id], ['escape' => false]) ?>
          </div>

          <div class="media-body">

<? /* TODO: Treat English sentence order */ ?>
            <h4 class="media-heading">
              <?= $this->Html->link($relation->active->name, ['controller' => 'baryons', 'action' => 'relations', $baryon->id, $relation->active->id]) ?> は 
            </h4>
            <h4 class="media-heading">
              <?= $this->Html->link($relation->passive->name, ['controller' => 'baryons', 'action' => 'relations', $baryon->id, $relation->passive->id]) ?> <?= $relation->relation ?>

    <? if (
	   !empty($auth) && $auth->user('id') &&
	   (
	      !$relation->is_exclusive ||
	      ($auth->user('id') == $relation->user_id)
	   )
    ): ?>
                 <?= $this->Html->link('',
		      ['controller' => 'relations', 'action' => 'edit', $relation->id],
		      ['class'=> "glyphicon glyphicon glyphicon-pencil"]) ?>
        <? if ($auth->user('id') == $relation->user_id): ?>
                 <?= $this->Form->postLink('',
                      ['controller' => 'relations', 'action' => 'delete', $relation->id],
	              ['confirm' => __('Are you sure you want to delete?'), 'class'=> "glyphicon glyphicon-remove-sign"]
                     )
                 ?>
        <? endif; ?>
    <? endif; ?>

            </h4>
            <p><?= $this->SubjectTool->period($relation) ?></p>
          </div>

          <div class="media-left subject-image">
             <?= $this->Html->link($this->Html->image($this->SubjectTool->imagePath($relation->passive->image_path), ['width' => '100px', 'height' => '100px']), ['controller' => 'baryons', 'action' => 'relations', $baryon->id, $relation->passive->id], ['escape' => false]) ?>
          </div>


        </div>
    </div>

</div>

<?php endforeach; ?>
</div>
<?php endif; ?>


    </div>

  </div>

</div>
