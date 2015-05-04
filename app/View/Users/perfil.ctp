<div class="content">

	<h2 class="perfil_title">Alterar minhas informações</h2>

	<?php
		echo $this->Form->create(array('action' => 'update', 'class' => 'update_form'));

		echo '<fieldset>';
			echo '<legend>Dados pessoais</legend>';
			echo $this->Form->input('name', array('value' => $current_user['User']['name'], 'label' => false, 'placeholder' => 'Nome completo'));
			echo $this->Form->input('country', array('value' => $current_user['User']['country'], 'label' => false, 'placeholder' => 'País de origem'));
		echo '</fieldset>';

		echo '<fieldset>';
			echo '<legend>Dados de acesso</legend>';
			echo $this->Form->input('username', array('value' => $current_user['User']['username'], 'readonly' => 'readonly', 'label' => false, 'placeholder' => 'Nome de usuário'));
			echo $this->Form->input('email', array('value' => $current_user['User']['email'], 'label' => false, 'placeholder' => 'E-mail'));
			echo $this->Form->input('password', array('value'=>'', 'label' => false, 'placeholder' => 'Senha'));
			echo $this->Form->input('password_confirm', array('value'=>'', 'type'=>'password', 'label' => false, 'placeholder' => 'Confirmação de senha'));
		echo '</fieldset>';
		
		echo $this->Form->end('ALTERAR DADOS');

	?>

	<h2 class="perfil_title">Excluir minha conta</h2>
	<p>
		Clicando no botão abaixo você excluirá permanentemente sua conta e todas as informações associadas a ela. Tenha certeza antes de clicá-lo
	</p>
	<div class="excluir_wrapper">
		<?php
			echo $this->Html->link(
				'Excluir minha conta',
				array('controller' => 'Users', 'action' => 'delete'),
				array(
					'confirm' => 'Você tem certeza que quer excluir sua conta?',
					'full_base' => true,
					'class' => 'excluir_conta'
				)
			);
		?>
	</div>

</div>