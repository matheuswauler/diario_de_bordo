<?php include 'header.php'; ?>

<?php echo $this->Session->flash(); ?>

<header class="navigation_search_content">
	<form id="search_place" method="post" action="">
		<input type="search" name="s" placeholder="Pesquise o que quiser..." />
		<input type="submit" value="" />
	</form>
</header>

<?php echo $this->fetch('content'); ?>

<?php include 'footer.php'; ?>