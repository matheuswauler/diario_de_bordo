<?php include 'header.php'; ?>

<?php echo $this->Session->flash(); ?>

<header class="navigation_search_content" ng-controller="SearchController">
	<form id="search_place" ng-submit="executeQuery()">
		<input type="search" name="s" ng-model="formData.search_params" ng-keyup="executeQuery()" autocomplete="off" placeholder="Pesquise o que quiser..." />
		<input type="submit" value="" />
	</form>

	<div class="floater_results" ng-show="showResults">
		<nav class="search_result_set location_set">
			<a ng-repeat="location in locations">
				<strong>{{location.Location.city}}</strong>
				<span>{{location.Location.state}} - {{location.Location.country}}</span>
			</a>
		</nav>
		<nav class="search_result_set trip_set">
			<a ng-repeat="trip in trips">
				<strong>{{trip.Trip.name}}</strong>
				<span>{{trip.Trip.date}}</span>
			</a>
		</nav>
	</div>
</header>

<?php echo $this->fetch('content'); ?>

<?php include 'footer.php'; ?>