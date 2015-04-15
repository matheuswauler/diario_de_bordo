var map;
var initialLocation;
var browserSupportFlag;

var modulo = angular.module('diario_de_bordo', []);

modulo.controller('CurrentLocationController', ['$scope', '$http', function($scope, $http){
	if(navigator.geolocation){
		browserSupportFlag = true;
		navigator.geolocation.getCurrentPosition(function(position){
			initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
			if(map){
				map.setCenter(initialLocation);
				var marker = new google.maps.Marker({
					position: initialLocation,
					map: map,
					animation: google.maps.Animation.DROP
				});
				marker.setTitle("Posição atual");
				var info_posicao_atual = new google.maps.InfoWindow({
					content: 'Você está aqui!'
				});
				info_posicao_atual.open(map, marker);

				setTimeout(function(){
					var confirmation = confirm("Você deseja gravar a sua localização atual como um novo ponto?");
					if(confirmation){
						$http.post('/diario_de_bordo/Locations/create',{
							latitude: position.coords.latitude,
							longitude: position.coords.longitude
						}).success(function(data, status, headers, config) {
							alert(data);
						});
					}
				}, 2000);
			}
		});
	} else {
		browserSupportFlag = false;
	}
}]);

$(function(){

	setTimeout(hide_messages, 3000);

	if(document.getElementById("mapa")){
		initialize_map();
	}

});

function hide_messages(){
	$('.message').css('top', '-50px');
}

function initialize_map(){
	var mapOptions = {
		zoom: 16,
		center: new google.maps.LatLng(0, 0),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}

	map = new google.maps.Map(document.getElementById("mapa"), mapOptions);
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