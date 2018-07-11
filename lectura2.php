<?php
	include("conexion.php");
	
	$fecha_actual_unix = strtotime(date('Y-m-d'));
	
	$nodos = selectSQL("SELECT * FROM history WHERE timestamp >= '{$fecha_actual_unix}' group by nid");
	
	/**
		PAGINACION EJEMPLO:
		
		if(!isset($_GET['pagina'])){ $_GET['pagina']=1; };
		if(!isset($_GET['limit'])){ $_GET['limit']=5; };

		$PAGE = $_GET['pagina'];
		$LIMIT = $_GET['limit'];
		$OFFSET = ($PAGE * $LIMIT ) - $LIMIT;
		$nodos = selectSQL("SELECT * FROM history WHERE timestamp >= '{$fecha_actual_unix}' group by nid LIMIT {$OFFSET},{$LIMIT}");
	*/
	
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF=8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Mostrar Datos</title>
		<link rel="stylesheet" href="css/estilo.css">
	</head>
	<body>
		<div class="contenedor">
		<h1 align="center">Visitas por Día</h1>
		<center>
			<table align="center" border="2" bordercolor="white" id="tabletocsv">
				<tr>
					<th>No.</th>
					<th>Nombre de articulo</th>
					<?php
						$i = 0;
						if(isset($nodos->data[0])){
							foreach($nodos->data as $fila) {
								$i++;
								$result_info_node = selectSQL("SELECT * FROM node WHERE nid IN ('{$fila->nid}') LIMIT 1");
								
								$node_id = "-5";
								$node_title = "Titulo no encontrado.";
								if(isset($result_info_node->data[0])){
									$node_id = $result_info_node->data[0]->nid;
									$node_title = $result_info_node->data[0]->title;
								}
								
								echo "<tr>";
										echo "<td>{$i}</td>";
										echo "<td>"
											."<a href=\"lectura-details.php?node={$node_id}&datefilter={$fecha_actual_unix}\">".$node_title."</a>"
										."</td>";
								echo "</tr>";
								
								/*
								
									*/	
							}
						}
					?>
				</tr>
			</table>
		</center>
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
	</body>
</html>