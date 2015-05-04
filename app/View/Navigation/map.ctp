<div ng-controller="CurrentLocationController" id="mapa"></div>

<div ng-controller="CreateTripController">
	<nav class="map_options_wrapper">
		<div class="plus_options">
			<a id="new_location" ng-click="addMapClickEvent()" class="plus_option">
				Novo local
				<?php echo $this->Html->image('icons/marker_icon.svg', array('fullBase' => true, 'alt' => 'Novo local')); ?>
			</a>
			<a id="new_trip" class="plus_option" ng-click="showForm = !showForm">
				Nova viagem
				<?php echo $this->Html->image('icons/trip.svg', array('fullBase' => true, 'alt' => 'Nova viagem')); ?>
			</a>
		</div>
		<a class="plus_map" title="Inicie sua interação com o mapa">+</a>
	</nav>

	<?php
		echo $this->Html->link(
			$this->Html->image('icons/back.svg', array('fullBase' => true, 'alt' => 'Novo local')) . ' Voltar para o painel',
			array('controller' => 'users', 'action' => 'myaccount'),
			array('full_base' => true, 'class' => 'voltar_painel', 'escape' => false)
		);
	?>

	<div ng-show="showForm" id="map_overlay"></div>

	<div class="form_viagem" ng-show="showForm">
		<form ng-submit="processForm()">
			<h2>Nova viagem</h2>

			<div class="inputs_wrapper">
				<input type="text" name="name" placeholder="Título" ng-model="formData.name">
				<input type="text" name="date" placeholder="Data" mask="99/99/9999" ng-model="formData.date">
			</div>

			<div class="default_error_message {{ message_type }}" ng-show="message">{{ message }}</div>

			<div class="form_buttons_wrapper clearfix">
				<a class="cancel_form_submition" ng-click="showForm = !showForm" >Cancelar</a>
				<button type="submit" class="save_form_submition">Gravar</button>
			</div>
		</form>
	</div>
</div>