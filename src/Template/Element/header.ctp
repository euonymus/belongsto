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

<? if (!$this->Page->isTop()): ?>
      <?= $this->Form->create(NULL, ['url' => '/subjects/search', 'method' => 'get',
				     'class' => 'navbar-form navbar-left', 'role'=>'search']) ?>
        <div class="input-group">
          <?= $this->Form->input('keywords', ['templates' => ['inputContainer' => '{{content}}'], 'label' => false,
					      'placeholder'=>'Search', 'class' => 'form-control']) ?>
          <span class="input-group-btn">
            <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-default']) ?>
          </span>
        </div>
      <?= $this->Form->end() ?>
<? endif; ?>

    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#contact">Contact</a></li>
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
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="../navbar/">Default</a></li>
        <li class="active"><a href="./">Static top <span class="sr-only">(current)</span></a></li>
        <li><a href="../navbar-fixed-top/">Fixed top</a></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>