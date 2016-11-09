<?= $this->Form->create(NULL, ['url' => '/subjects/search', 'method' => 'get']) ?>
<fieldset>
    <?= $this->Form->input('keywords', ['label' => false, 'placeholder'=>'Search']) ?>
</fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
