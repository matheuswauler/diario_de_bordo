<div class="imagem_fundo">
	<div class="content">
		<h1>Cadastro</h1>
	</div>
</div>

<div class="content">
	<ol class="steps clearfix">
		<li class="active"><abbr>1</abbr> Cadastro</li>
		<li><abbr>2</abbr> Perfil</li>
		<li><abbr>3</abbr> Questionário</li>
	</ol>

	<p class="page_descr">
		Em poucos passos você estará pronto para conhecer novas pessoas com o mesmo perfil que você.
	</p>

	<?php

		echo $this->Form->create(array('action' => 'register', 'class' => 'registration_form'));

		echo $this->Form->input('name', array('label' => '', 'placeholder' => 'Nome*'));

		echo $this->Form->input('email', array('label' => '', 'placeholder' => 'E-mail*', 'div' => 'input right'));

		echo $this->Form->input('birthday', array('label' => 'Data de Nascimento* ', 'dateFormat' => 'DMY', 'minYear' => date('Y') - 120, 'maxYear' => date('Y') - 18));

		echo $this->Form->input('sex', array('label' => '', 'options' => array('0' => 'Sexo*', 'M' => 'Masculino', 'F' => 'Feminino'), 'div' => 'input right'));

		echo $this->Form->input('facebook', array('label' => '', 'placeholder' => 'Link do Facebook'));

		echo $this->Form->input('twitter', array('label' => '', 'placeholder' => 'Link do Twitter', 'div' => 'input right') );

		echo $this->Form->input('web_site', array('label' => '', 'placeholder' => 'Site'));

		echo $this->Form->input('username', array('label' => '', 'placeholder' => 'Nome de Usuário*', 'div' => 'input right'));
		
		echo $this->Form->input('password', array('value'=>'', 'label' => '', 'placeholder' => 'Senha*'));

		echo $this->Form->input('password_confirm', array('value'=>'', 'type'=>'password', 'label' => '', 'placeholder' => 'Confirmar Senha*', 'div' => 'input right'));
		
		echo $this->Form->end('Registrar');

	?>
</div>