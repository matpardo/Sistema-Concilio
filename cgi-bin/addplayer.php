<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Añadir Jugador</title>
		<!--Espacio para css -->
		
		<!--Espacio para scripts-->
	</head>
	<body>
<?php
	include_once('concilio_dbconfig.php');
	$db = DbConfig::getConnection();

	if($_POST){
		// Parámetros del POST para addplayer.php
		$addplayer_mesa = NULL;
		$addplayer_player = NULL;
	
		//Verificación correctitud de mesa (addplayer_mesa)
		if(isset($_POST['addplayer_mesa']) && is_numeric($_POST['addplayer_mesa']) && strlen($_POST['addplayer_mesa']) > 0 && strlen($_POST['addplayer_mesa']) <= 4){
			$addplayer_mesa = htmlspecialchars($_POST['addplayer_mesa']); 
		}
		//Verificación correctitud del jugador (addplayer_player)
		if(isset($_POST['addplayer_player']) && strlen($_POST['addplayer_player']) > 0 && strlen($_POST['addplayer_player']) <= 20){
			$addplayer_player = htmlspecialchars($_POST['addplayer_player']);
		}
		//Si todo es ingresado correctamente
		if($addplayer_mesa != NULL && $addplayer_player != NULL){

			$sql = sprintf("UPDATE mesas SET jugadores = CONCAT(jugadores,'%s:'), cupos_ocupados = cupos_ocupados+1 WHERE num=%d AND (cupos = 0 OR cupos_ocupados < cupos);", $db->real_escape_string($addplayer_player), $db->real_escape_string($addplayer_mesa));

			if(!$db->query($sql)){ //Se ejecuta la query y se verifica si fue exitosa
				echo "Table insert failed: (" . $db->errno . ") " . $db->error ."<br/>";
				return;
			}
			echo ('
		Se ha AGREGADO un JUGADOR CORRECTAMENTE.<br>
		Recuerde verificar si la mesa no estaba llena antes de agregar, si no el nuevo jugador no es agregado.<br>
		Formulario procesado.<br>');
		}
		else{
			echo ('Se ha intentado AGREGAR un JUGADOR INCORRECTAMENTE');
		}
	}
?>
		<a href="sistema.php">Volver a Sistema</a>
	</body>
<html>