<?php
	include("conexion.php");
	
	if(!isset($_GET['node']) || $_GET['node'] == '' || $_GET['node'] == ' '){
		exit("No existe el nodo.");
	}
	
	$add_sql = '';
	
	
	if(isset($_GET['datefilter']) && $_GET['datefilter'] !== '' && $_GET['datefilter'] !== ' '){
		$add_sql .= " AND timestamp >= '{$_GET['datefilter']}'";
	}
	
	
	$result_sql = selectSQL("SELECT * FROM history WHERE nid IN ('{$_GET['node']}') {$add_sql} ORDER BY timestamp DESC");
	
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
		<h1 align="center">Visitas por artículo</h1>
		<center>
			<table align="center" border="2" bordercolor="white" id="tabletocsv">
				<tr>
					<th>Número</th>
					<th>Nombre Usuario</th>
					<th>Fecha última visita</th>
					<?php
						$i = 0;
						if(isset($result_sql->data[0])){
							foreach($result_sql->data as $fila) {
								$i++;
								$result_user = selectSQL("SELECT * FROM users WHERE uid IN ('{$fila->uid}')");
								
								$user_id = "";
								$user_name = "";
								if(isset($result_user->data[0])){
									$user_id = $result_user->data[0]->uid;
									$user_name = $result_user->data[0]->name;
								}
								
								echo "<tr>";
										# INDEX
										echo "<td>{$i}</td>";
										
										
										echo "<td>";
											echo ($user_name);
										echo "</td>";
									
										$fecha = new DateTime();
										$fecha->setTimestamp($fila->timestamp);
									
										echo "<td>";
											echo $fecha->format('Y-m-d H:i:s');
										echo "</td>";
										
								echo "</tr>";		
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