<? if (!$this->Page->isTop() && !$this->Page->isSignup()): ?>
      <?= $this->Form->create(NULL, ['url' => '/subjects/search', 'method' => 'get',
				     'class' => 'navbar-form navbar-left', 'role'=>'search']) ?>
        <div class="input-group">
          <?= $this->Form->input('keywords', ['templates' => ['inputContainer' => '{{content}}'], 'label' => false,
					      'placeholder'=>'Search', 'class' => 'form-control']) ?>
          <span class="input-group-btn">
            <?= $this->Form->button(__('Go'), ['class' => 'btn btn-default']) ?>
          </span>
        </div>
      <?= $this->Form->end() ?>
<? endif; ?>