<?php
	$current_user = $this->Session->read('current_user');
?>

<div class="imagem_fundo">
	<div class="content">
		<h1>Perfil</h1>
	</div>
</div>

<div class="content">
	<ol class="steps clearfix">
		<li class="active"><abbr>1</abbr> Cadastro</li>
		<li class="active"><abbr>2</abbr> Perfil</li>
		<li><abbr>3</abbr> Questionário</li>
	</ol>

	<p class="page_descr">
		Adicione uma imagem para o seu perfil.
	</p>

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

			echo $this->Form->create(array('action' => 'perfil', 'class' => '', 'type' => 'file'));

			echo $this->Form->file('imagem_perfil');

			echo $this->Form->end('Upload');

			echo $this->Html->link('Prosseguir sem adicionar imagem', '/surveys/index');
		?>
	</div>
</div>