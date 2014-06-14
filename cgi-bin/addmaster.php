<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Añadir Master</title>
		<!--Espacio para css -->
		
		<!--Espacio para scripts-->
	</head>
	<body>
<?php
	include_once('concilio_dbconfig.php');
	$db = DbConfig::getConnection();
	
	if($_POST){
		// Parámetros del POST para addmaster.php
		$addmaster_rut = NULL;
		$addmaster_name = NULL;
		$addmaster_nick = NULL;
		$addmaster_status = NULL;
		$rut_pattern= '/(^([1-9]{1})+([0-9]{7})+(K|[0-9])$)|((^([0])+([1-9])([0-9]{6})+(K|[0-9])$))/';
	
		//Verificación correctitud del rut (addmaster_rut)
		if(isset($_POST['addmaster_rut']) && preg_match($rut_pattern, $_POST['addmaster_rut'])){
			$addmaster_rut = htmlspecialchars($_POST['addmaster_rut']); 
		}
		//Verificación correctitud del nombre (addmaster_name)
		if(isset($_POST['addmaster_name']) && strlen($_POST['addmaster_name']) > 0 && strlen($_POST['addmaster_name']) <= 50){
			$addmaster_name = htmlspecialchars($_POST['addmaster_name']);
		}
		//Verificación correctitud del nick (addmaster_nick)
		if(isset($_POST['addmaster_nick']) && strlen($_POST['addmaster_nick']) > 0 && strlen($_POST['addmaster_nick']) <= 50){
			$addmaster_nick = htmlspecialchars($_POST['addmaster_nick']);
		}
		//Cómo puede ser que nick o name sean NULL (pero solo uno de ellos)
		if(isset($_POST['addmaster_name']) || isset($_POST['addmaster_nick'])){
			if($addmaster_name == NULL){
				$addmaster_name = $addmaster_nick;
			}
			else if($addmaster_nick == NULL){
				$addmaster_nick = $addmaster_name;
			}
		}
		//Verificación correctitud de estado: Debe ser 1 que indica activo, 0 indica eliminado
		if(isset($_POST['addmaster_status']) && $_POST['addmaster_status'] == 1 ){
			$addmaster_status = $_POST['addmaster_status'];
		}
	
		//Si todo es ingresado correctamente
		if($addmaster_rut != NULL && $addmaster_name != NULL && $addmaster_nick != NULL && $addmaster_status != NULL){
			$sql = sprintf("INSERT INTO masters (rut, nombre, nick, estado) VALUES ('%s', '%s', '%s', %d)", $db->real_escape_string($addmaster_rut), $db->real_escape_string($addmaster_name), $db->real_escape_string($addmaster_nick), $db->real_escape_string($addmaster_status));
			if(!$db->query($sql)){ //Se ejecuta la query y se verifica si fue exitosa
				echo "Table insert failed: (" . $db->errno . ") " . $db->error ."<br/>";
				return;
			}
			echo ('
		Se ha AGREGADO un MASTER CORRECTAMENTE.<br>
		Formulario procesado.<br>');
		}
		else{
			echo ('Se ha intentado AGREGAR un MASTER INCORRECTAMENTE.<br>');
		}
	}
?>
		<a href="sistema.php">Volver a Sistema</a>
	</body>
<html>