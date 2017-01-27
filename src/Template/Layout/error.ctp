<?
$gluonsDescription = 'gluons: All the connections among everything in the universe';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">
    <?= $this->Html->meta('icon') ?>

    <title>
        <?= $this->fetch('title') ?>
    </title>

    <!-- Bootstrap -->
    <?= $this->Html->css('bootstrap.min.css') ?>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <?= $this->Html->css('ie10-viewport-bug-workaround.css') ?>
    <?= $this->Html->css('sticky-footer.css') ?>
    <?= $this->Html->css('local.css') ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <?= $this->element('google_analytics') ?>
    <?= $this->element('header') ?>
    <?= $this->Flash->render() ?>

    <div class="container">
        <?= $this->fetch('content') ?>
    </div>

    <footer class="footer">
      <div class="container">
        <?= $this->element('footer') ?>
      </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/js/jquery.min.js"><\/script>')</script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <?= $this->Html->script('bootstrap.min.js') ?>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <?= $this->Html->script('ie10-viewport-bug-workaround.js') ?>

    <?= $this->fetch('scriptBottom') ?>
  </body>
</html>
