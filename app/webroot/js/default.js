var map;
var initialLocation;
var browserSupportFlag;
var SITE = '/diario_de_bordo';

var modulo = angular.module('diario_de_bordo', ['ngMask']);

modulo.controller('CurrentLocationController', ['$scope', '$http', function($scope, $http){
	if(navigator.geolocation){
		browserSupportFlag = true; // Flag que valida o suporte a geolocalização no navegador
		navigator.geolocation.getCurrentPosition(function(position){
			initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude); // Cria coordenadas google com as coordenadas atuais
			if(map){ // Verifica se o map está iniciado
				map.setCenter(initialLocation); // Seta o centro do mapa com a localização atual
				var marker = new google.maps.Marker({
					position: initialLocation,
					map: map,
					animation: google.maps.Animation.DROP
				}); // Adiciona um marcador na posição atual
				marker.setTitle("Posição atual");
				var info_posicao_atual = new google.maps.InfoWindow({
					content: 'Você está aqui!'
				}); // Adiciona um inforbox com a posição atual
				info_posicao_atual.open(map, marker);

				$http.post(SITE + '/Locations/show',{
					latitude: position.coords.latitude,
					longitude: position.coords.longitude
				}).success(function(data, status, headers, config){
					if(data.length == 0){
						setTimeout(function(){
							var confirmation = confirm("Você deseja gravar a sua localização atual como um novo ponto?");
							if(confirmation){
								// Pesquisa sobre informações como Cidade, estado, país
								var more_info = googleGeocoding(position.coords.latitude + ',' + position.coords.longitude);

								$http.post(SITE + '/Locations/create',{
									latitude: position.coords.latitude,
									longitude: position.coords.longitude,
									city: more_info.locality,
									state: more_info.state,
									country: more_info.country
								}).success(function(data, status, headers, config) {
									// Salvo com sucesso
								});
							}
						}, 2000);
					}
				});
			} else {
				browserSupportFlag = false;
			}
		});
	}
}]);

modulo.controller('SearchController', ['$scope', '$http', function($scope, $http){
	$scope.formData = {};

	$scope.executeQuery = function(){
		if($scope.formData.search_params == ''){
			$scope.showResults = false;
			return;
		}
		
		$http.post(SITE + '/Trips/list_all', $scope.formData)
		.success(function(data) {
			$scope.trips = data;
			$scope.showResults = true;
		});

		$http.post(SITE + '/Locations/list_all', $scope.formData)
		.success(function(data) {
			$scope.locations = data;
			$scope.showResults = true;
		});
	};
}]);

// Grava as Viagens
modulo.controller('CreateTripController', ['$scope', '$http', '$timeout', function($scope, $http, $timeout){
	$scope.formData = {};
	$scope.showForm;

	$scope.processForm = function() {
		$http.post(SITE + '/Trips/create', $scope.formData)
		.success(function(data) {
			if (data.save) {
				$scope.message = data.message;
				$scope.message_type = "green_message";
				$timeout(function(){
					$scope.showForm = false;
				}, 2000);
			} else {
				$scope.message = data.message;
				$scope.message_type = "red_message";
				// Deu ruim
			}
		});
	};

	$scope.addMapClickEvent = function(){
		google.maps.event.addListener(map, 'click', function(event) {
			var marker = new google.maps.Marker({
				position: event.latLng,
				map: map
			});
			// Pesquisa sobre informações como Cidade, estado, país
			var more_info = googleGeocoding(event.latLng.lat() + ',' + event.latLng.lng());

			$http.post(SITE + '/Locations/create',{
				latitude: event.latLng.lat(),
				longitude: event.latLng.lng(),
				city: more_info.locality,
				state: more_info.state,
				country: more_info.country
			}).success(function(data, status, headers, config) {
				if(data.save){
					alert("Novo local salvo com sucesso");
				} else {
					alert("Erro ao salvar o novo local");
				}
				google.maps.event.clearListeners(map, 'click');
			});
		});
	};
}]);

$(function(){

	setTimeout(hide_messages, 3000);

	if(document.getElementById("mapa")){
		initialize_map();
		plus_control();
	}
});

function hide_messages(){
	$('.message').css('top', '-50px');
}

function plus_control(){
	$('.plus_map').click(function(){
		$('.map_options_wrapper').toggleClass('show_opts');
	});
}

function initialize_map(){
	var mapOptions = {
		zoom: 16,
		center: new google.maps.LatLng(0, 0),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}

	map = new google.maps.Map(document.getElementById("mapa"), mapOptions);
}

function googleGeocoding(endereco, reversa){
	var endereco_formatado = removerAcentos(endereco.replace(' ', '+'));
	var url = 'http://maps.googleapis.com/maps/api/geocode/json';
	if(reversa){
		obj_data = {sensor: false, latlng: endereco_formatado}
	} else {
		obj_data = {sensor: false, address: endereco_formatado}
	}
	var obj_resultado;

	$.ajax({
		url: url,
		method: 'GET',
		async: false,
		data: obj_data,
		success: function(data, status, xhr){
			obj_resultado = getGeocodingRelevantInfo(data);
		}
	});

	return obj_resultado;
}

function getGeocodingRelevantInfo(item){
	var arrAddress = item.results[0].address_components;
	var itemRoute='';
	var itemLocality='';
	var itemCountry='';
	var itemCEP='';
	var itemSnumber='';
	var itemState=''

	// iterate through address_component array
	$.each(arrAddress, function (i, address_component) {
		if (address_component.types[0] == "route"){
			itemRoute = address_component.long_name;
		}

		if (address_component.types[0] == "locality"){
			itemLocality = address_component.long_name;
		}

		if (address_component.types[0] == "administrative_area_level_1"){
			itemState = address_component.long_name;
		}

		if (address_component.types[0] == "country"){ 
			itemCountry = address_component.long_name;
		}

		if (address_component.types[0] == "postal_code"){ 
			itemCEP = address_component.long_name;
		}

		if (address_component.types[0] == "street_number"){ 
			itemSnumber = address_component.long_name;
		}
	});
	return {
		route: itemRoute,
		locality: itemLocality,
		country: itemCountry,
		pc: itemCEP,
		snumber: itemSnumber,
		state: itemState
	};
}


/*
function display_confirmation_dialog(title, text){
	var titulo = $('<h2/>',{
		class: 'title_dialog',
		text: title + '<span class="colose_dialog">x</span>'
	});

	var sim = $('<span/>',{
		class: 'dialog_yes',
		name: 'sim'
		text: 'Sim'
	});
	var nao = $('<span/>',{
		class: 'dialog_no',
		name: 'nao'
		text: 'Não'
	});
	var options = $('<div/>',{
		class: 'dialog_options',
		text: sim + nao
	});

	$('<div/>',{
		class: 'confirmation_dialog',
		text: titulo + text + options
	}).appendTo('body');

	$('.dialog_yes, ').
}*/