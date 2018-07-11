<?php
	include("conexion.php");
	
	$lista = null;
	try {
		$mbd = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DATABASE, DB_USER, DB_PASS);
		$lista = $mbd->query("select * from node n join node_counter c on n.nid = c.nid order by vid;");
		
		$mbd = null;
	} catch (PDOException $e) {
		print "¡Error!: " . $e->getMessage() . "<br/>";
		die();
		exit();
	}
	

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
					<th>Id node</th>
					<th>Nombre de articulo</th>
					<th>Visitas</th>
					<?php
						foreach($lista as $fila) {							
							echo "<tr>";
								
									echo "<td>";
										echo $fila['nid'];
									echo "</td>";
									echo "<td>";
										echo "<a href=\"lectura-details.php?node={$fila['nid']}\">";
											echo $fila['title'];
										echo "</a>";
									echo "</td>";
									echo "<td>";
										echo $fila['totalcount'];
									echo "</td>";
									
							echo "</tr>";
							
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