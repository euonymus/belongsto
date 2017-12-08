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
						    '気になる人、物、会社の隠れた関係を見つけよう') ?></p>
    <?= $this->Form->create(NULL, ['url' => '/subjects/search', 'method' => 'get', 'class' => 'search_top text-center']) ?>

        <? $placeholder = $this->LangMngr->txt('Type people, organization, product and so on',
					       '人名、組織名、商品名、ブランド名などで検索') ?>
        <div class="form-group center-block input-container-top">
            <?= $this->Form->input('keywords', ['label' => false,
						'placeholder' => $placeholder,
						'class' => 'form-control']) ?>
        </div>
        <?= $this->Form->button(__('Gluons Search'), ['class' => 'btn btn-primary']) ?>

    <?= $this->Form->end() ?>

    <div class="top-pickup-links center-block">
        <div class="row">

   <? foreach($pickups as $pickup): ?>
            <div class="col-md-3">
                <div class="pickup-link">
                    <?= $this->Html->link($this->Html->image($pickup->image_path, ['alt' => $pickup->name]),
					  ['controller' => 'subjects', 'action' => 'relations', $pickup->name, $pickup->type],
					  ['escape' => false]) ?>
                </div>
            </div>
   <? endforeach; ?>

        </div>
    </div>

</div>
