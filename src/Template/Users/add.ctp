<div class="logo-top">
  <h1>Sign up</h1>
</div>
<div>
    <?= $this->Form->create($user, ['class' => 'search_top text-centerh']) ?>
        <div class="form-group center-block input-container-signup">
            <?= $this->Form->input('username', ['class' => 'form-control']) ?>
            <?= $this->Form->input('password', ['class' => 'form-control']) ?>
<? /*
            <?= $this->Form->input('role', [
					    'options' => ['admin' => 'Admin', 'author' => 'Author'],
					    'class' => 'form-control'
                ]) ?>
*/ ?>
            <br>
            <?= $this->Form->button(__('Sign up'), ['class' => 'btn btn-primary']) ?>
        </div>

    <?= $this->Form->end() ?>
</div>
