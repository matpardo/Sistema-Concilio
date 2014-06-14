<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Borrar Jugador</title>
		<!--Espacio para css -->
		
		<!--Espacio para scripts-->
	</head>
	<body>
<?php
	include_once('concilio_dbconfig.php');
	$db = DbConfig::getConnection();

	if($_POST){
		// Parámetros del POST para delplayer.php
		$delplayer_mesa = NULL;
		$delplayer_player = NULL;
		$delplayer_conf1 = NULL;
		$delplayer_conf2= NULL;
	
		//Verificación correctitud de mesa (delplayer_mesa)
		if(isset($_POST['delplayer_mesa']) && is_numeric($_POST['delplayer_mesa']) && strlen($_POST['delplayer_mesa']) > 0 && strlen($_POST['delplayer_mesa']) < 5){
			$delplayer_mesa = htmlspecialchars($_POST['delplayer_mesa']); 
		}
		//Verificación correctitud del jugador (delplayer_player)
		if(isset($_POST['delplayer_player']) && strlen($_POST['delplayer_player']) > 0 && strlen($_POST['delplayer_player']) < 21){
			$delplayer_player = htmlspecialchars($_POST['delplayer_player']);
		}
		//Verificación correctitud de confirmación 1 (delplayer_conf1)
		if(isset($_POST['delplayer_conf1'])){
			$delplayer_conf1 = htmlspecialchars($_POST['delplayer_conf1']);
		}
		//Verificación correctitud de confirmación 2 (delplayer_conf2)
		if(isset($_POST['delplayer_conf2'])){
			$delplayer_conf2 = htmlspecialchars($_POST['delplayer_conf2']);
		}
	
		//Si todo es ingresado correctamente
		if($delplayer_mesa != NULL && $delplayer_player != NULL && $delplayer_conf1 != NULL && $delplayer_conf2 != NULL ){
			
			$sql = sprintf(
							"SELECT num, cupos, cupos_ocupados, jugadores, juego, dificultad, descripcion, ubicacion, h_inicio, nick 
							FROM mesas, masters, partidas
							WHERE mesas.estado = 1 AND num = num_mesa AND rut = rut_master");
						$result = $db->query($sql);
						while ($row = $result->fetch_assoc() ){
							echo ("swag1");
							if($row['num'] == $delplayer_mesa){
								echo ("swag2");
								$pos = strpos($row['jugadores'], $delplayer_player);
								echo ($row['jugadores']);
								if (!($pos === false) ){
									echo ("swag3");
									$lista = str_replace(":".$delplayer_player.":", ":", $row['jugadores']);
									echo ($lista);
									$sql = sprintf("UPDATE mesas 
									SET jugadores = '%s', cupos_ocupados = cupos_ocupados - 1 WHERE num=%d;", 
									$db->real_escape_string($lista), $db->real_escape_string($delplayer_mesa));
									
									if(!$db->query($sql)){ //Se ejecuta la query y se verifica si fue exitosa
											echo "Table edit failed: (" . $db->errno . ") " . $db->error ."<br/>";
											return;
									}
								}
							}
						}
						


			
			
			echo ('
		Se ha BORRADO un JUGADOR CORRECTAMENTE.<br>
		Formulario procesado.<br>');
		}
		else{
			echo ('Se ha intentado BORRAR un JUGADOR INCORRECTAMENTE<br>');
		}
	}
?>

		<a href="sistema.php">Volver a Sistema</a>
	</body>
<html>