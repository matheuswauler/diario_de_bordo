<section class="home_login">
	<div class="content">
		<div class="login_box">
			<span class="user_logo"></span>
			<?php
				echo $this->Form->create(array('url' => $this->Html->url(array('controller' => 'Users','action' => 'login'), true)));

				echo $this->Form->input('User.username', array('label' => false, 'placeholder' => 'Nome de usuário'));
				echo $this->Form->input('User.senha', array('label' => false, 'placeholder' => 'Senha', 'type' => 'password'));

				echo $this->Form->end('OK');

				echo $this->Html->link(
					'Não é cadastrado? Crie uma conta aqui.',
					array('controller' => 'users', 'action' => 'signup'),
					array('full_base' => true, 'class' => 'signup_link')
				);
			?>
		</div>
	</div>
</section>

<section class="explanation_sec blue_bg">
	<div class="content clearfix">
		<h1>
			Reúna todos os seus pontos em um só lugar
		</h1>

		<div class="icon_placewrapper">
			<?php echo $this->Html->image('icons/place_marker.svg', array('fullBase' => true, 'alt' => 'Diário de bordo')); ?>
		</div>

		<div class="text_format">
			<p>
				Com o Diário de Bordo, você organiza e gerencia seus pontos de localizacão geográfica como achar necessário, podendo adicionar notas para lembrar do que deve ser feito em cada lugar. Assim nada fica de fora, e você não vai mais esquecer do que precisa fazer quando for para París novamente.
			</p>
		</div>
	</div>
</section>

<section class="explanation_sec right_image green_bg">
	<div class="content clearfix">
		<h1>
			Sem limites para suas viagens
		</h1>

		<div class="icon_placewrapper">
			<?php echo $this->Html->image('icons/world_map.svg', array('fullBase' => true, 'alt' => 'Diário de bordo')); ?>
		</div>

		<div class="text_format">
			<p>
				O Diário de Bordo é válido para o mundo inteiro!
			</p>
			<p>
				Faça aquela sua viagem para a Europa que está sendo planejada há anos. Aproveite e deixe todo o seu roteiro de viagem que a gente cuida dele pra você, sem complicação, super rápido. Não gaste espaço da sua mala carregando guias e GPS pra lá e pra cá, leve apenas o seu celular ou notebook e tenha acesso a tudo isso e muito mais!
			</p>
		</div>
	</div>
</section>

<section class="explanation_sec yellow_bg">
	<div class="content clearfix">
		<h1>
			Aprendendo a se virar no exterior
		</h1>

		<div class="icon_placewrapper">
			<?php echo $this->Html->image('icons/road.svg', array('fullBase' => true, 'alt' => 'Diário de bordo')); ?>
		</div>

		<div class="text_format">
			<p>
				Não sabe como sair do seu hotel e chegar até o Central Park? Isso é simples, aqui você adiciona qualquer ponto de localização que quiser e traça rotas para cada lugar, super simples. Agora você não tem mais disculpa para não levar sua namorada passear...
			</p>
		</div>
	</div>
</section>