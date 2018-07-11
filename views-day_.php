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
				<h1 class="blog-title">Visitas de hoy</h1>
				<p class="lead blog-description">Informes desarrollados por el area de Medios Virtuales de Emtelco PBO & CX.</p>
			</div>
		<script type="text/javascript">
			function crearCSV(){
				var tablehtml = document.getElementById("tabletocsv").innerHTML;
				
				var datos = tablehtml.replace(/<thead>/g,'')
									.replace(/<\/thead>/g,'')
									.replace(/<tbody>/g,'')
									.replace(/<\/tbody>/g,'')
									.replace(/<tr>/g,'')
									.replace(/<\/tr>/g,'\r\n')
									.replace(/<th>/g,'')
									.replace(/<\/th>/g,';')
									.replace(/<td>/g,'')
									.replace(/<\/td>/g,';')
									.replace(/\t/g,'')
									.replace(/\n/g,'');
									
				var link = document.createElement("a");
				link.download = "Lectura.csv";
				link.href = "data:application/csv,"+ escape(datos);
				link.click();
								
			}	
		</script>
		<button onClick="crearCSV()"> Exporte </button>
			<div class="row">
				<div class="col-sm-12">
					<div class="blog-post">
						<?php
							$sql = "select H.nid, H.timestamp, N.title, C.totalcount, C.daycount "
							." from ".DB_PREFIX."history As H INNER JOIN ".DB_PREFIX."node AS N INNER JOIN ".DB_PREFIX."node_counter As C "
							." where H.nid = N.nid AND C.nid = H.nid AND H.timestamp >= '{$fecha_actual_unix}' group by H.nid "
							." ORDER BY C.daycount DESC";
							
							$select = object_check(selectSQL($sql));
							
						?>
						<table class="table table-responsive" id="tabletocsv">
							<thead>
								<tr>
									<th>ID</th>
									<th>Nodo</th>
									<th>Titulo</th>
									<th>Visitas del día</th>
									<th>Visitas Totales</th>
								</tr>
							</thead>
							<tbody>
								<?php $i=0; foreach($select As $nodo){ $i++; ?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $nodo->nid; ?></td>
									<td>
										<a href="<?php echo $folder_patch_cliente; ?>views-details.html?node=<?php echo $nodo->nid."&datefilter={$fecha_actual_unix}"; ?>">
											<?php echo $nodo->title; ?>
										</a>
									</td>
									<td><?php echo $nodo->daycount; ?></td>
									<td><?php echo $nodo->totalcount; ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>

					<!--
					<nav>
						<ul class="pager">
						<li><a href="#">Previous</a></li>
						<li><a href="#">Next</a></li>
						</ul>
					</nav>-->

				</div><!-- /.blog-main -->

			</div>
		</div>
	
		<?PHP include('config/init/footer.php'); ?>
	</body>
</html>