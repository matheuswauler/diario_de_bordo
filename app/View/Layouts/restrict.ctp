<?php include 'header.php'; ?>
	<header id="restrict_header">
		<div class="content">
			<?php
				echo $this->Html->link(
					$this->Html->image('symbol.svg', array('fullBase' => true, 'alt' => 'Diário de bordo', 'width' => '25')),
					array('controller' => 'users', 'action' => 'myaccount'), array('full_base' => true, 'class' => 'logo_wrapper', 'escape' => false)
				);
			?>
			Olá, <?php echo $current_user['User']['name']; ?>!

			<?php echo $this->Html->link('Sair', array('controller' => 'users', 'action' => 'logout'), array('full_base' => true, 'class' => 'logout_link')); ?>
		</div>
	</header>

	<div id="main_content">
		<?php echo $this->Session->flash(); ?>

		<?php echo $this->fetch('content'); ?>
	</div>

<?php include 'footer.php'; ?>