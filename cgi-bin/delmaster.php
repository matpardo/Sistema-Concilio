<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Borrar Master</title>
		<!--Espacio para css -->
		
		<!--Espacio para scripts-->
	</head>
	<body>
<?php
	include_once('concilio_dbconfig.php');
	$db = DbConfig::getConnection();
	
	if($_POST){
		// Parámetros del POST para delmaster.php
		$delmaster_rut = NULL;
		$delmaster_conf1 = NULL;
		$delmaster_conf2= NULL;
		$rut_pattern= '/(^([1-9]{1})+([0-9]{7})+(K|[0-9])$)|((^([0])+([1-9])([0-9]{6})+(K|[0-9])$))/';
	
		//Verificación correctitud de rut (delmaster_rut)
		if(isset($_POST['delmaster_rut']) && preg_match($rut_pattern, $_POST['delmaster_rut'])){
			$delmaster_rut = htmlspecialchars($_POST['delmaster_rut']); 
		}
		//Verificación correctitud de confirmación 1 (delplayer_conf1)
		if(isset($_POST['delmaster_conf1'])){
			$delmaster_conf1 = htmlspecialchars($_POST['delmaster_conf1']);
		}
		//Verificación correctitud de confirmación 2 (delplayer_conf2)
		if(isset($_POST['delmaster_conf2'])){
			$delmaster_conf2 = htmlspecialchars($_POST['delmaster_conf2']);
		}
	
		//Si todo es ingresado correctamente
		if($delmaster_rut != NULL && $delmaster_conf1 != NULL && $delmaster_conf2 != NULL ){
			$sql = sprintf("UPDATE masters 
								SET estado = 0 WHERE rut='%s';", $db->real_escape_string($delmaster_rut));
			if(!$db->query($sql)){ //Se ejecuta la query y se verifica si fue exitosa
				echo "Table edit failed: (" . $db->errno . ") " . $db->error ."<br/>";
				return;
			}
			echo ('
		Se ha BORRADO un MASTER CORRECTAMENTE.<br>
		Formulario procesado.<br>');
		}
		else{
			echo ('Se ha intentado BORRAR un MASTER INCORRECTAMENTE.');
		}
	}
?>
		<a href="sistema.php">Volver a Sistema</a>
	</body>
<html>