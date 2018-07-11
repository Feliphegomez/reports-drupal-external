<?php
error_reporting(E_ALL);
setlocale(LC_TIME, "es_CO");

$folder_principal = dirname(__FILE__).'/../';
$folder_patch = '/_apps/informes/drupal/';
$fecha_actual_unix = strtotime(date('Y-m-d'));

define("DB_HOST","10.1.1.108"); /** SERVIDOR PARA CONEXION A LA BD **/
define("DB_USER","informes_drupal"); /** USUARIO PARA CONEXION A LA BD **/
define("DB_PASS","informes_drupal9520*"); /** CONTRASEÑA PARA CONEXION A LA BD **/
/*
	|-------- CLIENTES EN EL SISTEMA --------|
	comfama
	belcorp
	colpen
	cvu
	emvariaepm
	fepep
	formacion
	gexito
	losolivos
	mabe
	movilexito
	tuya
	tuya1
*/

# Definir bases de datos.
if(!isset($_GET['database_name']) || $_GET['database_name'] == '' || $_GET['database_name'] == ' '){
	
	echo "No hay cliente seleccionado. <br><br><br>";
	echo "|-------- CLIENTES EN EL SISTEMA --------|<br><br>";
	echo "<a href='{$folder_patch}comfama/'>comfama</a><br>";
	echo "<a href='{$folder_patch}belcorp/'>belcorp</a><br>";
	echo "<a href='{$folder_patch}colpen/'>colpen</a><br>";
	echo "<a href='{$folder_patch}cvu/'>cvu</a><br>";
	echo "<a href='{$folder_patch}emvariaepm/'>emvariaepm</a><br>";
	echo "<a href='{$folder_patch}fepep/'>fepep</a><br>";
	echo "<a href='{$folder_patch}formacion/'>formacion</a><br>";
	echo "<a href='{$folder_patch}gexito/'>gexito</a><br>";
	echo "<a href='{$folder_patch}losolivos/'>losolivos</a><br>";
	echo "<a href='{$folder_patch}mabe/'>mabe</a><br>";
	echo "<a href='{$folder_patch}movilexito/'>movilexito</a><br>";
	echo "<a href='{$folder_patch}tuya/'>tuya</a><br>";
	echo "<a href='{$folder_patch}tuya1/'>tuya1</a><br>";
	echo "<a href='{$folder_patch}b2b/'>b2b</a><br>";
	
	exit();
}
else{
	$_GET['database_name'] = strtolower($_GET['database_name']);
	define("DB_DATABASE",'dp_'.$_GET['database_name']);
	# Configurar los prefijos de la Base de Datos
	/* ------ SIN PREFIJO ------ */
	if(
		$_GET['database_name'] == 'comfama'
		|| $_GET['database_name'] == 'belcorp'
		|| $_GET['database_name'] == 'colpen'
		|| $_GET['database_name'] == 'cvu'
		|| $_GET['database_name'] == 'emvariaepm'
		|| $_GET['database_name'] == 'fepep'
		|| $_GET['database_name'] == 'formacion'
		|| $_GET['database_name'] == 'losolivos'
		|| $_GET['database_name'] == 'mabe'
		|| $_GET['database_name'] == 'movilexito'
		|| $_GET['database_name'] == 'tuya1'
		|| $_GET['database_name'] == 'b2b'
	){ define("DB_PREFIX",""); }
	
	/* ------ CON PREFIJO dpt_ ------ */
	else if(
		$_GET['database_name'] == 'tuya'
	){ define("DB_PREFIX","dpt_"); }
	
	/* ------ CON PREFIJO gruex_ ------ */
	else if(
		$_GET['database_name'] == 'gexito'
	){ define("DB_PREFIX","gruex_"); }
	
	/* ------ NO MOVER ------ */
	else{ exit("Cliente no identificado."); }
	
};

$folder_patch_cliente = "/_apps/informes/drupal/{$_GET['database_name']}/";

## Consulta SQL SELECT
function selectSQL($sql,$mode="obj"){
	if(!isset($mode)){ $mode="obj"; };
	$rawdata = new stdClass();
	$rawdata->error = true;
	$rawdata->data = array();
	$rawdata->sql = $sql;
	$rawdata->total = 0;	
	
	try {
		$conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DATABASE.";charset=utf8", DB_USER, DB_PASS);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $conn->prepare($sql); 
		$stmt->execute();
		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		
		if($mode == "obj"){ $result = $stmt->fetchAll(PDO::FETCH_OBJ); }
		else if($mode == "assoc"){ $result = $stmt->fetchAll(PDO::FETCH_ASSOC); };
		
		$rawdata->error = false;
		$rawdata->data = $result;
		$rawdata->total = count($result);
	}
	catch(PDOException $e) { $rawdata->data = $e->getMessage(); }
	$conn = null;	
	return $rawdata;
};

function object_check($datas){
	if(isset($datas->total) && $datas->total >= 1){
		return $datas->data;
	}else{
		return array();
	};
};

#echo json_encode($_GET);