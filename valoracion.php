<?php
	include("conexion.php");
	
	$fecha_actual_unix = strtotime(date('Y-m-d'));
	$listas = selectSQL("select * from votingapi_vote v join node d on d.nid = v.entity_id order by entity_id;");

	
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
		<h1 align="center">Informe Valoración de Articulos</h1>
		<center>
		<table align="center" border="2" bordercolor="white">
			<tr style="color:white;">
				<th>Número de articulo</th>
				<th>Nombre de articulo</th>
				<th>Porcentaje</th>
				<?php
					foreach($listas->data As $lista){
						echo "<tr>";
							echo "<td>";
								echo $lista->entity_id;
							echo "</td>";
							echo "<td>";
								echo $lista->title;
							echo "</td>";
							echo "<td>";
								echo $lista->value;
							echo "</td>";
						echo "</tr>";
					}
				?>
			
			</tr>
		
		</table>
		<center>
		</div>
	</body>
</html>