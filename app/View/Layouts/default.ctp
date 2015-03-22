<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		Diário de Bordo
	</title>
	<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('default');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<header id="header">
			<?php echo $this->Html->image('logo_white.svg', array('fullBase' => true, 'alt' => 'Diário de bordo', 'width' => '170')); ?>
		</header>

		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>

		<footer id="footer">
			
		</footer>
	</div>
</body>
</html>
