<?php include 'header.php'; ?>
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

<?php include 'footer.php'; ?>