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
      <?= $this->Html->link(__('gluons'), ['controller' => 'Pages', 'action' => 'display'], ['class'=>'navbar-brand']) ?>
      <?= $this->element('side_search') ?>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li><?= $this->Html->link(__('List'), ['controller' => 'subjects', 'action' => 'index']) ?></li>
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
        <li><?= $this->Html->link(__('New Subject'), ['controller' => 'subjects', 'action' => 'add']) ?></li>
        <?= $this->element('side_subject') ?>
        <?= $this->element('side_relation') ?>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>