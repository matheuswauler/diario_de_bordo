<?php include 'header.php'; ?>

<?php echo $this->Session->flash(); ?>

<div id="loading_overlay">
	<div class="carregando">Carregando...</div>
</div>

<div class="map_wrapper" ng-controller="CurrentLocationController">
	<header class="navigation_search_content">
		<form id="search_place" ng-submit="executeQuery()">
			<input type="search" name="s" ng-model="formData.search_params" ng-keyup="executeQuery()" autocomplete="off" placeholder="Pesquise o que quiser..." />
			<input type="submit" value="" />
		</form>

		<div class="floater_results" ng-show="showResults">
			<nav class="search_result_set map_set">
				<a ng-click="findOnMap()">
					<div class="link_container">
						<strong>Procurar no mapa</strong>
						<span>Centrar o mapa segundo endereço: {{formData.search_params}}</span>
					</div>
				</a>
			</nav>
			<nav class="search_result_set location_set">
				<a ng-click="coordSetMap(location.Location.latitude,location.Location.longitude)" ng-repeat="location in locations">
					<div class="link_container">
						<strong>{{location.Location.city}}</strong>
						<span>{{location.Location.state}} - {{location.Location.country}}</span>
					</div>
				</a>
			</nav>
			<nav class="search_result_set trip_set">
				<ul>
					<li ng-repeat="trip in trips" class="clearfix">
						<a ng-click="tripManager(trip.Trip.id, 'add')">
							<div class="link_container">
								<strong>{{trip.Trip.name}}</strong>
								<span>{{trip.Trip.date}}</span>
							</div>
						</a>
						<b ng-click="deleteTrip(trip.Trip.id)"></b>
					</li>
				</ul>
			</nav>
		</div>
	</header>

	<?php echo $this->fetch('content'); ?>
</div>

<?php include 'footer.php'; ?>