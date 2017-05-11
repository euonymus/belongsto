<? if ($auth->user('id')): ?>
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Baryon<span class="caret"></span></a>
      <ul class="dropdown-menu">
          <li><?= $this->Html->link(__('My Baryons'), ['controller' => 'Baryons', 'action' => 'index']) ?></li>

<? if ($this->Page->isSubject() && isset($subject)): ?>
          <li><?= $this->Html->link(__('Go to Baryon'), ['controller' => 'Baryons', 'action' => 'quark', $subject->id]) ?></li>
<? endif; ?>

      </ul>
    </li>
<? endif; ?>
