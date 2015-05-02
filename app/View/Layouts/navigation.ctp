<?php include 'header.php'; ?>

<?php echo $this->Session->flash(); ?>

<header class="navigation_search_content" ng-controller="SearchController">
	<form id="search_place" method="post" action="" ng-submit="executeQuery()">
		<input type="search" name="s" ng-keypress="executeQuery()" autocomplete="off" placeholder="Pesquise o que quiser..." />
		<input type="submit" value="" />
	</form>
</header>

<?php echo $this->fetch('content'); ?>

<?php include 'footer.php'; ?>