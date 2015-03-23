<div class="content clearfix">
	<div class="left_content">
		<h1 class="default_blue_title">Faça o seu cadastro</h1>
		<p>E  tenha acesso a tudo o que o Diário de Bordo pode lhe oferecer. <strong>É rapidinho!</strong></p>

		<ul class="signup_motives">
			<li>
				<span class="motive_icon">
					<?php echo $this->Html->image('icons/phone.svg', array('fullBase' => true)); ?>
				</span>
				<p>Você também pode acessar o Diário de Bordo do seu Smartphone! Isso mesmo, o design do webapp é todo trabalhado para que ele funcione perfeitamente em seu celular.</p>
			</li>
			<li>
				<span class="motive_icon">
					<?php echo $this->Html->image('icons/directions.svg', array('fullBase' => true)); ?>
				</span>
				<p>Todos os seus locais em apenas um único lugar. Aqui você reúne todo o seu roteiro de viagem e não precisa mais ficar carregando guias e manuais.</p>
			</li>
			<li>
				<span class="motive_icon">
					<?php echo $this->Html->image('icons/compass.svg', array('fullBase' => true)); ?>
				</span>
				<p>Não se perca mais em lugar algum, e não estamos falando de bússulas! Você pode calcular rotas a partir de sua localização atual até qualquer ponto marcado no mapa. Aí é só seguir em frente!</p>
			</li>
		</ul>
	</div>

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