<div class="content">
	<h1 class="default_blue_title">Minha conta</h1>
	<p>Nesta página você tem acesso a tudo o que o Diário de bordo tem a oferecer. <strong>Aproveite!</strong></p>

	<nav class="minha_conta_links clearfix">
		<a href="<?php echo $this->Html->url(array("controller" => "Navigation", "action" => "map")); ?>" class="meu_mapa">
			<div class="menu_description">
				<h2>Meu mapa</h2>
				<p>
					Gerencie todos os seus pontos através deste link.
				</p>
			</div>
		</a>

		<!-- <a href="/" class="navegar">
			<div class="menu_description">
				<h2>Navegar</h2>
				<p>
					Gerencie todos os seus pontos através deste link.
				</p>
			</div>
		</a> -->

		<a href="<?php echo $this->Html->url(array("controller" => "Users", "action" => "perfil")); ?>" class="meu_cadastro">
			<div class="menu_description">
				<h2>Meu cadastro</h2>
				<p>
					Gerencie todos os seus pontos através deste link.
				</p>
			</div>
		</a>
	</nav>
</div>