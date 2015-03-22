<div class="padding_box">
	<h1 class="perfil_dark_title">Alterar imagem do perfil</h1>

	<div class="imagem_wrapper">
		<?php
			if(empty($current_user['User']['imagem_perfil'])){
				echo '<img src="../app/webroot/img/default_perfil.png' .'" />';
			} else {
				echo '<img src="../app/webroot/img/perfil/' . $current_user['User']['imagem_perfil'] .'" />';
			}
		?>
	</div>

	<div class="upload_form">
		<?php

			echo $this->Form->create(array('action' => 'alterar_perfil', 'class' => 'upload_imagem', 'type' => 'file'));

			echo $this->Form->file('imagem_perfil');

			echo $this->Form->end('Upload');
		?>
	</div>
</div>