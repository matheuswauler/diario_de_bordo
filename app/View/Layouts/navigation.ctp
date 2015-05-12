<?php include 'header.php'; ?>

<?php echo $this->Session->flash(); ?>

<header class="navigation_search_content" ng-controller="SearchController">
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
			<a ng-repeat="trip in trips">
				<div class="link_container">
					<strong>{{trip.Trip.name}}</strong>
					<span>{{trip.Trip.date}}</span>
				</div>
			</a>
		</nav>
	</div>
</header>

<?php echo $this->fetch('content'); ?>

<?php include 'footer.php'; ?>