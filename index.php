<?PHP include('config/conexion.php'); ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<?PHP include('config/init/head.php'); ?>
	</head>
	<body>
		<?PHP include('config/init/navbar.php'); ?>		
		
		<div class="container">
			<div class="blog-header">
				<h1 class="blog-title">Informes Generales</h1>
				<p class="lead blog-description">Informes desarrollados por el area de Medios Virtuales de Emtelco PBO & CX.</p>
			</div>

			<div class="row">
				<div class="col-sm-8 blog-main">
					<div class="blog-post">
						<blockquote>
							<ul class="media-list">
							  <li class="media">
								<div class="media-left">
									<a href="<?php echo $folder_patch_cliente; ?>views-day.html">
										<img height="50" class="media-object" src="<?php echo $folder_patch; ?>img/ent1.png" alt="Vistas por Día">
									</a>
								</div>
								<div class="media-body">
									<h4 class="media-heading">Vistas por Día</h4>
									<p>Si deseas visualizar las paginas que se han sido visitadas hoy.</p>
								</div>
							  </li>
							  
							  <li class="media">
								<div class="media-left">
									<a href="<?php echo $folder_patch_cliente; ?>views-nodes.html">
										<img height="50" class="media-object" src="<?php echo $folder_patch; ?>img/ent1.png" alt="Vistas por Artículos">
									</a>
								</div>
								<div class="media-body">
									<h4 class="media-heading">Vistas por Artículos</h4>
									<p>Si deseas visualizar las paginas que se han sido visitadas hoy.</p>
								</div>
							  </li>
							  
							  <li class="media">
								<div class="media-left">
									<a href="<?php echo $folder_patch_cliente; ?>ranking-nodes.html">
										<img height="50" class="media-object" src="<?php echo $folder_patch; ?>img/ent1.png" alt="Valoración por Artículos">
									</a>
								</div>
								<div class="media-body">
									<h4 class="media-heading">Valoración por Artículos</h4>
									<p>Si deseas visualizar la valoraciones de cada pagina.</p>
								</div>
							  </li>
							</ul>
						</blockquote>
					</div><!-- /.blog-post -->

					<!--
					<nav>
						<ul class="pager">
						<li><a href="#">Previous</a></li>
						<li><a href="#">Next</a></li>
						</ul>
					</nav>-->

				</div><!-- /.blog-main -->

				<div class="col-sm-3 col-sm-offset-1 blog-sidebar">
				  <div class="sidebar-module sidebar-module-inset">
					<h4>Más!</h4>
					<p>Acceso rapido a lo mas utilizado.</p>
				  </div>
				  
				  <div class="sidebar-module">
					<h4>Páginas Más Visitadas (Hoy)</h4>
					<?php $sql = "SELECT * FROM ".DB_PREFIX."node_counter AS C INNER JOIN ".DB_PREFIX."node As N WHERE C.nid = N.nid ORDER BY C.daycount DESC LIMIT 25"; ?>
					<?php #echo $sql; ?>
					<?php $select = object_check(selectSQL($sql)); ?>
					<ol class="list-unstyled">
						<?php foreach($select As $nodo){
							echo "<li><a href=\"{$folder_patch_cliente}views-details.html?node={$nodo->nid}&datefilter={$fecha_actual_unix}\">"
								."[{$nodo->daycount}] {$nodo->title}"
							."</a></li>";
						}; ?>
					</ol>
				  </div>
				  <div class="sidebar-module">
					<?php $select = object_check(selectSQL("SELECT H.uid,U.name,count(H.nid) As totalviews FROM ".DB_PREFIX."history AS H INNER JOIN ".DB_PREFIX."users As U WHERE U.uid = H.uid group by H.uid order by totalviews DESC LIMIT 25")); ?>
					<h4>Usuarios (Paginas vistas)</h4>
					<ol class="list-unstyled">
						<?php foreach($select As $nodo){
							echo "<li><a href=\"users-details.html?username={$nodo->name}&userid={$nodo->uid}\">"
								."{$nodo->name} - ( {$nodo->totalviews} )"
							."</a></li>";
						}; ?>
					</ol>
				  </div>
				</div>

			</div>
		</div>
	
		<?PHP include('config/init/footer.php'); ?>
	</body>
</html>