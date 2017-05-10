<!-- Static navbar -->
<nav class="navbar navbar-default navbar-static-top">
  <div class="container">

    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
<? /*
      <?= $this->Html->link(__('gluons'), ['controller' => 'Pages', 'action' => 'display'], ['class'=>'navbar-brand']) ?>
*/ ?>
      <?= $this->Html->link(__('<img src="/img/logo.gif">'), ['controller' => null, 'action' => 'index'], ['class'=>'navbar-brand', 'escape' => false]) ?>
      <?= $this->element('side_search') ?>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li><?= $this->Html->link($this->LangMngr->txt('List', '一覧'),['controller' => 'subjects', 'action' => 'index']) ?></li>
<? /*
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li class="dropdown-header">Nav header</li>
            <li><a href="#">Separated link</a></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li>
*/ ?>
      </ul>
      <ul class="nav navbar-nav navbar-right">

   <? if (!empty($auth) && $auth->user('id')): ?>

        <li><?= $this->Html->link(__('New Quark'), ['controller' => 'subjects', 'action' => 'add']) ?></li>
        <?= $this->element('side_subject') ?>
        <?= $this->element('head_baryon') ?>
        <?= $this->element('side_relation') ?>

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $auth->user('username') ?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><?= $this->Html->link(__('Edit User'), ['controller' => 'users', 'action' => 'edit', $auth->user('id')]) ?></li>
            <li role="separator" class="divider"></li>
            <li class="dropdown-header">Privacy Modes</li>

       <? if ($auth->user('role') == 'admin'): ?>
            <li><?= $this->Html->link(__('Admin'), ['controller' => 'users', 'action' => 'privacy', 4]) ?></li>
       <? endif; ?>

            <li><?= $this->Html->link(__('Public'), ['controller' => 'users', 'action' => 'privacy', 1]) ?></li>
            <li><?= $this->Html->link(__('Private'), ['controller' => 'users', 'action' => 'privacy', 2]) ?></li>
            <li><?= $this->Html->link(__('All'), ['controller' => 'users', 'action' => 'privacy', 3]) ?></li>
            <li role="separator" class="divider"></li>
            <li><?= $this->Html->link(__('Logout'), ['controller' => 'users', 'action' => 'logout']) ?></li>
          </ul>
        </li>

   <? else: ?>

        <li><?= $this->Html->link(__('Login'), ['controller' => 'users', 'action' => 'login']) ?></li>
        <li><?= $this->Html->link(__('Signup'), ['controller' => 'users', 'action' => 'add']) ?></li>

   <? endif; ?>

      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>