<?PHP include('config/conexion.php'); ?>
<?php
	if(!isset($_GET['node']) || $_GET['node'] == '' || $_GET['node'] == ' '){ exit("No existe el nodo."); };
	
	$add_sql = '';
	if(isset($_GET['datefilter']) && $_GET['datefilter'] !== '' && $_GET['datefilter'] !== ' '){ $add_sql .= " AND timestamp >= '{$_GET['datefilter']}'"; };
	$infoNodo = object_check(selectSQL("SELECT * from ".DB_PREFIX."node WHERE nid IN ('{$_GET['node']}') LIMIT 1"));
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<?PHP include('config/init/head.php'); ?>
	</head>
	<body>
		<?PHP include('config/init/navbar.php'); ?>		
		
		<div class="container">
			<div class="blog-header">
				<h1 class="">
					<a href="javascript:window.history.back();">Regresar</a>
					<b class="blog-subtitle">Estas Viendo: </b>
					<?php echo $infoNodo[0]->title; ?>
				</h1>
				<p class="lead blog-description">Informes desarrollados por el area de Medios Virtuales de Emtelco PBO & CX.
					<hr>
					<div class="btn-group">
						<button class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Exportar Tabla</button>
						<ul class="dropdown-menu " role="menu">
							<li><a href="#" onclick="$('.table').tableExport({type:'sql'});"> SQL</a></li>
							<li class="divider"></li>
							<li><a href="#" onclick="$('.table').tableExport({type:'csv',escape:'false'});"> CSV</a></li>
							<li><a href="#" onclick="$('.table').tableExport({type:'txt',escape:'false'});"> TXT</a></li>
							<li class="divider"></li>
							<li><a href="#" onclick="$('.table').tableExport({type:'excel',escape:'false'});"> XLS</a></li>
							<li><a href="#" onclick="$('.table').tableExport({type:'excel',escape:'true'});"> XLS (simbolos)</a></li>
							<li><a href="#" onclick="$('.table').tableExport({type:'doc',escape:'false'});"> Word</a></li>
							<!-- 
								<li class="divider"></li>
								<li><a target="download" onclick="javascript:$('.table').tableExport({type:'pdf',pdfFontSize:'7',escape:'false'});" onclick=""> <img src="icons/pdf.png" width="24px"> PDF</a></li>
							-->
						</ul>
					</div>
				</p>
			</div>


			<div class="row">
				<div class="col-sm-12">
					<div class="blog-post">
						<?php
							$sql = "SELECT H.*, U.name FROM ".DB_PREFIX."history As H INNER JOIN ".DB_PREFIX."users As U WHERE H.nid IN ('{$_GET['node']}') AND U.uid = H.uid {$add_sql} ORDER BY timestamp DESC";
							
							$select = object_check(selectSQL($sql));
						?>
						<table class="table table-responsive">
							<thead>
								<tr>
									<th>#</th>
									<th>Usuario</th>
									<th>Fecha</th>
								</tr>
							</thead>
							<tbody>
								<?php $i=0; foreach($select As $user){ $i++; ?>
								<tr class="">
									<td><?php echo $i; ?></td>
									<td><?php echo $user->name; ?></td>
									<?php
										$fecha = new DateTime();
										$fecha->setTimestamp($user->timestamp);
									?>
									<!-- <td><?php echo $fecha->format('Y-m-d H:i:s'); ?></td> -->
									<td><?php echo $fecha->format('d-m-Y'); ?></td>
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