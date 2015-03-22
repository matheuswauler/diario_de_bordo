<section class="home_video_container">
	<div class="login_box">
		<h1>Entrar</h1>
		<?php
			echo $this->Form->create(array('url' => $this->Html->url(array('controller' => 'Users','action' => 'login'), true)));

			echo $this->Form->input('User.username', array('label' => 'Nome de usuário'));
			echo $this->Form->input('User.senha', array('label' => 'Senha', 'type' => 'password'));

			echo $this->Form->end('OK');
		?>
	</div>
</section>