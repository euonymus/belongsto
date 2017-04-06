<div class="logo-top">
  <img src="/img/logo.gif">
</div>
<? /*
<div class="jumbotron">
  <h1>gluons</h1>
  <p>'gluons' is a database of relations among anything in the universe. Start searching from the form.</p>
</div>
*/ ?>
<div class="home">
    <p class="text-center"><?= $this->LangMngr->txt('Search hidden relations on your favorite things, people, company...',
						    '気になる人、物、会社などの隠れた関係を見つけよう') ?></p>
    <?= $this->Form->create(NULL, ['url' => '/subjects/search', 'method' => 'get', 'class' => 'search_top text-center']) ?>

        <div class="form-group center-block input-container-top">
            <?= $this->Form->input('keywords', ['label' => false, 'class' => 'form-control']) ?>
        </div>
        <?= $this->Form->button(__('Gluons Search'), ['class' => 'btn btn-primary']) ?>

    <?= $this->Form->end() ?>
</div>
