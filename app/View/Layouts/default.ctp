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
		echo $this->Html->css('default-479');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<header id="header">
		<div class="content">
			<?php
				echo $this->Html->link(
					$this->Html->image('logo_white.svg', array('fullBase' => true, 'alt' => 'Diário de bordo', 'width' => '180')),
					'/', array('full_base' => true, 'class' => 'logo_wrapper', 'escape' => false)
				);
			?>
		</div>
	</header>

	<div id="main_content">
		<?php echo $this->Session->flash(); ?>

		<?php echo $this->fetch('content'); ?>
	</div>

	<footer id="footer">
		<div class="content">
			Matheus William Auler - 2015
		</div>
	</footer>
</body>
</html>