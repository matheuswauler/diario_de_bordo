var map;
var initialLocation;
var browserSupportFlag;

$(function(){

	setTimeout(hide_messages, 3000);

	if(document.getElementById("mapa")){
		current_location();
		initialize_map();
	}

});

function hide_messages(){
	$('.message').css('top', '-50px');
}

function initialize_map(){
	var mapOptions = {
		zoom: 8,
		center: new google.maps.LatLng(0, 0),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}

	map = new google.maps.Map(document.getElementById("mapa"), mapOptions);
}

function current_location(){
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
			}
		});
	} else {
		browserSupportFlag = false;
	}
}

