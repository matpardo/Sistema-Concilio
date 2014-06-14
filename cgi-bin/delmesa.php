<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Borrar Mesa</title>
		<!--Espacio para css -->
		
		<!--Espacio para scripts-->
	</head>
	<body>
<?php
	include_once('concilio_dbconfig.php');
	$db = DbConfig::getConnection();
	
	if($_POST){
		// Parámetros del POST para delmesa.php
		$delmesa_number = NULL;
		$delmesa_conf1 = NULL;
		$delmesa_conf2= NULL;
	
		//Verificación correctitud de mesa (delmesa_number)
		if(isset($_POST['delmesa_number']) && is_numeric($_POST['delmesa_number']) && strlen($_POST['delmesa_number']) > 0 && strlen($_POST['delmesa_number']) <= 4){
			$delmesa_number = htmlspecialchars($_POST['delmesa_number']); 
		}
		//Verificación correctitud de confirmación 1 (delmesa_conf1)
		if(isset($_POST['delmesa_conf1'])){
			$delmesa_conf1 = htmlspecialchars($_POST['delmesa_conf1']);
		}
		//Verificación correctitud de confirmación 2 (del_mesa_conf2)
		if(isset($_POST['delmesa_conf2'])){
			$delmesa_conf2 = htmlspecialchars($_POST['delmesa_conf2']);
		}
	
		//Si todo es ingresado correctamente
		if($delmesa_number != NULL && $delmesa_conf1 != NULL && $delmesa_conf2 != NULL ){
			$sql = sprintf("UPDATE mesas 
								SET estado = 0 WHERE num=%d;", $db->real_escape_string($delmesa_number));
			if(!$db->query($sql)){ //Se ejecuta la query y se verifica si fue exitosa
				echo "Table edit failed: (" . $db->errno . ") " . $db->error ."<br/>";
				return;
			}
			echo ('
		Se ha BORRADO una MESA CORRECTAMENTE.<br>
		Formulario procesado.<br>');
		}
		else{
			echo ('Se ha intentado BORRAR una MESA INCORRECTAMENTE.<br>');
		}
	}
?>
		<a href="sistema.php">Volver a Sistema</a><br><br>
	</body>
<html>