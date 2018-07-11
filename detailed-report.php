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
				<h1 class="blog-title">Visitas de Usuarios</h1>
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
							$sql = "Select u.uid, u.name, u.mail from ".DB_PREFIX."users as u where u.uid>'0' order by u.uid ASC "; # Pdte eliminar el limite
							$users = object_check(selectSQL($sql));
						?>
						<table class="table table-responsive">
							<thead>
								<tr>
                                    <th>#</th>
                                    <th>userid</th>
                                    <th>username</th>
                                    <th>Nodo</th>
                                    <th>Titulo</th>
                                    <th>Dia</th>
                                    <th>Hora</th>
								</tr>
							</thead>
							<tbody>
                                <?php 
                                    foreach($users As $user){
                                        $sql = "Select H.*, N.title, N.`type` From (SELECT h.nid, h.timestamp FROM ".DB_PREFIX."history As h WHERE h.uid IN ('{$user->uid}')) as H INNER JOIN ".DB_PREFIX."node as N Where N.nid = H.nid order by H.nid ASC";							
                                        $select = object_check(selectSQL($sql));

                                        $user->tracker_user = object_check(selectSQL("SELECT T.nid,T.changed As T.timestamp,N.title,N.type,N.created,N.changed FROM `tracker_user` AS T INNER JOIN `node` AS N WHERE T.`uid` IN ({$user->uid}) AND N.nid = T.nid"));
                                        $user->watchdog = object_check(selectSQL("SELECT W.wid,W.type,W.message,W.variables,W.location,W.timestamp FROM `watchdog` AS W INNER JOIN `users` AS U WHERE W.`uid` IN ({$user->uid}) AND U.`uid` = W.`uid`"));

                                ?>

                                <?php $i=0; foreach($user->watchdog As $watch){ $i++; ?>
                                    <tr class="">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $user->uid; ?></td>
                                        <td><?php echo $user->name; ?></td>
                                        <td><?php echo $watch->nid; ?></td>
                                        <td><?php echo $watch->message; ?></td>
                                        <?php
                                            $fecha = new DateTime();
                                            $fecha->setTimestamp($watch->timestamp);
                                        ?>
                                        <!-- <td><?php echo $fecha->format('Y-m-d H:i:s'); ?></td> -->
                                        <td><?php echo $fecha->format('d-m-Y'); ?></td>
                                        <!-- <td><?php echo $fecha->format('H:i:s'); ?></td> -->
                                    </tr>
                                <?php } ?>

                                <?php $i=0; foreach($user->tracker_user As $track){ $i++; ?>
                                    <tr class="">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $user->uid; ?></td>
                                        <td><?php echo $user->name; ?></td>
                                        <td><?php echo $track->nid; ?></td>
                                        <td><?php echo $track->title; ?></td>
                                        <?php
                                            $fecha = new DateTime();
                                            $fecha->setTimestamp($track->timestamp);
                                        ?>
                                        <!-- <td><?php echo $fecha->format('Y-m-d H:i:s'); ?></td> -->
                                        <td><?php echo $fecha->format('d-m-Y'); ?></td>
                                        <td><?php echo $fecha->format('H:i:s'); ?></td>
                                    </tr>
                                <?php } ?>

                                <?php $i=0; foreach($select As $node){ $i++; ?>
                                    <tr class="">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $user->uid; ?></td>
                                        <td><?php echo $user->name; ?></td>
                                        <td><?php echo $node->nid; ?></td>
                                        <td><?php echo $node->title; ?></td>
                                        <?php
                                            $fecha = new DateTime();
                                            $fecha->setTimestamp($node->timestamp);
                                        ?>
                                        <!-- <td><?php echo $fecha->format('Y-m-d H:i:s'); ?></td> -->
                                        <td><?php echo $fecha->format('d-m-Y'); ?></td>
                                        <td><?php echo $fecha->format('H:i:s'); ?></td>
                                    </tr>
                                <?php } ?>
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
					</nav>
					-->
				</div>
			</div>
		</div>
		<?php include('config/init/footer.php'); ?>
	</body>
</html>