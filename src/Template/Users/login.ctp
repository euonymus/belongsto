<!-- File: src/Template/Users/login.ctp -->
<div class="logo-top">
  <h1>Login</h1>
  <p>Login to create your own gluons</p>
</div>
<div>
    <?= $this->Flash->render('auth', ['params' => ['class' => 'alert alert-danger']]) ?>
    <?= $this->Form->create(NULL, ['class' => 'search_top text-centerh']) ?>
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
            <?= $this->Form->button(__('Login'), ['class' => 'btn btn-primary']) ?>
        </div>

    <?= $this->Form->end() ?>
</div>

