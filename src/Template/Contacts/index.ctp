<h1>contact us</h1>
<div class="jumbotron contact-us">
    <img src="/img/logo.gif">
    <p>Leverage your knowledge by seeking relations among things, people, ETC. If you’d like to know more about how we can help you, put down anything here.</p>

<?= $this->Form->create($contact, ['class' => 'search_top']) ?>

    <div class="form-group center-block input-container-top">
        <?= $this->Form->input('name', ['class' => 'form-control']) ?>
        <?= $this->Form->input('organization', ['class' => 'form-control']) ?>
        <?= $this->Form->input('department', ['class' => 'form-control']) ?>
        <?= $this->Form->input('email', ['class' => 'form-control']) ?>
        <br>
        <?= $this->Form->select('topic', 
                                  ['About Service' => 'About Service',
				   'Business relationship' => 'Business relationship',
				   'Media coverage' => 'Media coverage',
				   'Other' => 'Other'
				   ],
                                ['empty' => '(Select one topic)']
        ) ?>

        <?= $this->Form->input('body', ['class' => 'form-control']) ?>

    </div>
    <?= $this->Form->button(__('Contact us'), ['class' => 'btn btn-primary']) ?>

<?= $this->Form->end() ?>

</div>

<p>'gluons' is a database of relations among anything in the universe.</p>
