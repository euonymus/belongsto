<div class="jumbotron">
  <h1>gluons</h1>
  <p>'gluons' is a database of relations among anything in the universe. Start searching from the form.</p>
</div>
<div>
    <?= $this->Form->create(NULL, ['url' => '/subjects/search', 'method' => 'get', 'class' => 'search_top text-center']) ?>

        <div class="form-group center-block" style="max-width:500px;">
            <?= $this->Form->input('keywords', ['label' => false, 'class' => 'form-control']) ?>
        </div>
        <?= $this->Form->button(__('Gluons Search'), ['class' => 'btn btn-primary']) ?>

    <?= $this->Form->end() ?>
</div>
