var map;
var initialLocation;
var browserSupportFlag;
var geocoder;
var SITE = '/diario_de_bordo';
var markers = [];

var modulo = angular.module('diario_de_bordo', ['ngMask']);

modulo.controller('CurrentLocationController', ['$scope', '$http', '$timeout', function($scope, $http, $timeout){
	$scope.noteData = {};
	$scope.showNotes = false;

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

	$http.post(SITE + '/Locations/list_all', {})
	.success(function(data) {
		var log = [];
		angular.forEach(data, function(value, key) {

			initialLocation = new google.maps.LatLng(value.Location.latitude, value.Location.longitude);
			var marker = new google.maps.Marker({
				position: initialLocation,
				map: map
			});
			markers.push(marker);
			var info_posicao_atual = new google.maps.InfoWindow({
				content: value.Location.city + '<br />' + value.Location.state
			});
			google.maps.event.addListener(marker, 'click', function() {
				info_posicao_atual.open(map, marker);
				map.setCenter(marker.getPosition());
				$scope.showLocation(value.Location.id, markers.length - 1);
			});
		}, log);
	});

	$scope.showLocation = function($id, $marker_index){
		$scope.showNotes = true;
		$scope.marker_index = $marker_index;
		$http.post(SITE + '/Locations/show', {id: $id})
		.success(function(data) {
			$scope.location = data;
			$scope.notes = data.Note;
			if($scope.notes.length > 0){
				$scope.noteData = $scope.notes[0];
			} else {
				$scope.noteData.id = '';
				$scope.noteData.title = '';
				$scope.noteData.description = '';
				$scope.noteData.location_id = $id;
			}
		});
	}

	$scope.saveNote = function(){
		$http.post(SITE + '/Notes/create', $scope.noteData)
		.success(function(data) {
			if (data.save) {
				alert('Nota gravada com sucesso');
			} else {
				alert('Erro ao gravar nota');
			}
		});
	}

	$scope.deleteLocation = function($id, $marker_index){
		$http.post(SITE + '/Locations/delete', {id: $id})
		.success(function(data) {
			if (data) {
				markers[$marker_index].setMap(null);
				$scope.showNotes = false;
				alert('Local deletado com sucesso');
			} else {
				alert('Erro ao deletar nota');
			}
		});
	}

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
		map.setOptions({ draggableCursor: 'copy' });
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
					markers.push(marker);
					var info_posicao_atual = new google.maps.InfoWindow({
						content: data.city + '<br />' + data.state
					});
					google.maps.event.addListener(marker, 'click', function() {
						info_posicao_atual.open(map, marker);
						map.setCenter(marker.getPosition());
						$scope.showLocation(data.id, markers.length - 1);
					});

					alert("Novo local salvo com sucesso");
				} else {
					alert("Erro ao salvar o novo local");
				}
				google.maps.event.clearListeners(map, 'click');
				map.setOptions({ draggableCursor: 'url(http://maps.gstatic.com/mapfiles/openhand_8_8.cur) 8 8, default' });
			});
		});
	};
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

	$scope.findOnMap = function(){
		$('.link_container').addClass('loading');
		geocoder.geocode({
			'address': $scope.formData.search_params
		}, function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				// Centraliza mapa segundo localização
				map.setCenter(results[0].geometry.location);
			} else {
				alert("Não foi possível localizar este endereço");
			}
			$scope.showResults = false;
			$('.link_container').removeClass('loading');
		});
	};

	$scope.coordSetMap = function(latitude, longitude){
		location_coords = new google.maps.LatLng(latitude, longitude);
		map.setCenter(location_coords);
		$scope.showResults = false;
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
	geocoder = new google.maps.Geocoder();

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