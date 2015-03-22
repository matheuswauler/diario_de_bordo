<div class="padding_box">
	<h1 class="perfil_dark_title">Alterar dados da conta</h1>

	<?php

		echo $this->Form->create(array('action' => 'minha_conta', 'class' => 'minha_conta_form'));

		echo $this->Form->input('name', array('value' => $current_user['User']['name'], 'label' => 'Nome: ',));

		echo $this->Form->input('email', array('label' => 'E-mail: ', 'value' => $current_user['User']['email'], 'div' => 'input right'));

		echo $this->Form->input('birthday', array('value' => $current_user['User']['birthday'], 'label' => 'Data de Nascimento: ', 'dateFormat' => 'DMY', 'minYear' => date('Y') - 120, 'maxYear' => date('Y') - 18));

		echo $this->Form->input('sex', array('label' => 'Sexo: ', 'options' => array('0' => 'Sexo', 'M' => 'Masculino', 'F' => 'Feminino'), 'div' => 'input right'));

		echo $this->Form->input('facebook', array('label' => 'Facebook: ', 'value' => $current_user['User']['facebook']));

		echo $this->Form->input('twitter', array('label' => 'Twitter: ', 'value' => $current_user['User']['twitter']) );

		echo $this->Form->input('web_site', array('label' => 'Site: ', 'value' => $current_user['User']['web_site']));

		echo $this->Form->input('username', array('label' => 'Nome de Usuário', 'value' => $current_user['User']['username']));

		echo $this->Form->input('password', array('value'=>'', 'label' => 'Senha'));

		echo $this->Form->input('password_confirm', array('value'=>'', 'type'=>'password', 'label' => 'Confirmar Senha'));
		
		echo $this->Form->end('Salvar');

	?>
</div>