<div class="content">
	<div class="margin_content clearfix">
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

		<div class="right_content signup_wrapper">
			<div class="login_box">
				<span class="user_logo"></span>
				<?php

					echo $this->Form->create(array('action' => 'signup', 'class' => ''));

					echo '<fieldset>';
						echo '<legend>Dados pessoais</legend>';
						echo $this->Form->input('name', array('label' => false, 'placeholder' => 'Nome completo'));
						echo $this->Form->input('country', array('label' => false, 'placeholder' => 'País de origem'));
					echo '</fieldset>';

					echo '<fieldset>';
						echo '<legend>Dados de acesso</legend>';
						echo $this->Form->input('username', array('label' => false, 'placeholder' => 'Nome de usuário'));
						echo $this->Form->input('email', array('label' => false, 'placeholder' => 'E-mail'));
						echo $this->Form->input('password', array('value'=>'', 'label' => false, 'placeholder' => 'Senha'));
						echo $this->Form->input('password_confirm', array('value'=>'', 'type'=>'password', 'label' => false, 'placeholder' => 'Confirmação de senha'));
					echo '</fieldset>';
					
					echo $this->Form->end('CRIAR CONTA');

				?>
			</div>
		</div>
	</div>
</div>