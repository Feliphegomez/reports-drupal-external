<?PHP include('config/conexion.php'); ?>
<?php
	if(!isset($_GET['userid']) || $_GET['userid'] == '' || $_GET['userid'] == ' '){ exit("No 'id' de usuario."); };
	if(!isset($_GET['username']) || $_GET['username'] == '' || $_GET['username'] == ' '){ exit("No 'username' de usuario."); };
	
	$add_sql = '';
	if(isset($_GET['nodefilter']) && $_GET['nodefilter'] !== '' && $_GET['nodefilter'] !== ' '){ $add_sql .= " AND timestamp >= '{$_GET['nodefilter']}'"; };
	
	$sql_user = "SELECT * from ".DB_PREFIX."users WHERE uid IN ('{$_GET['userid']}') LIMIT 1";
	$infoUser = object_check(selectSQL($sql_user));
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
					<?php echo $infoUser[0]->name; ?>
					<?php echo $infoUser[0]->mail; ?>
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
							
							$sql = "Select H.*, N.title, N.`type` From (SELECT h.nid, h.timestamp FROM ".DB_PREFIX."history As h WHERE h.uid IN ('{$_GET['userid']}')) as H INNER JOIN ".DB_PREFIX."node as N Where N.nid = H.nid order by H.timestamp DESC";							
							$select = object_check(selectSQL($sql));
						?>
						<table class="table table-responsive">
							<thead>
								<tr>
									<th>#</th>
									<th>Nodo</th>
									<th>Titulo</th>
									<th>Ultima Visita</th>
								</tr>
							</thead>
							<tbody>
								<?php $i=0; foreach($select As $node){ $i++; ?>
								<tr class="">
									<td><?php echo $i; ?></td>
									<td><?php echo $node->nid; ?></td>
									<td><?php echo $node->title; ?></td>
									<?php
										$fecha = new DateTime();
										$fecha->setTimestamp($node->timestamp);
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