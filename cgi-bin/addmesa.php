<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Añadir Mesa</title>
		<!--Espacio para css -->
		
		<!--Espacio para scripts-->
	</head>
	<body>
<?php
	include_once('concilio_dbconfig.php');
	$db = DbConfig::getConnection();
	
	if($_POST){
		// Parámetros del POST para addmesa.php
		$addmesa_master = NULL;
		$addmesa_number = NULL;
		$addmesa_ubicacion = NULL;
		$addmesa_capmax = NULL;
		$addmesa_capact = NULL;
		$addmesa_juego = NULL;
		$addmesa_descripcion = NULL;
		$addmesa_dificultad = NULL;
		$addmesa_status = NULL;
		$addmesa_hora = NULL;
		$addmesa_min = NULL;
		$addmesa_dia = NULL;
		$addmesa_mes = NULL;
		$addmesa_year = NULL;
		$addmesa_info = NULL;
		$addmesa_players = NULL;
	
		//1 Verificación correctitud del master (addmesa_master)
		if(isset($_POST['addmesa_master'])){
			$addmesa_master = htmlspecialchars($_POST['addmesa_master']); 
		}
		//2 Verificación correctitud de número de mesa
		if(isset($_POST['addmesa_number']) && is_numeric($_POST['addmesa_number']) && strlen($_POST['addmesa_number']) > 0 && strlen($_POST['addmesa_number']) <= 4){
			$addmesa_number = htmlspecialchars($_POST['addmesa_number']); 
		}
		//3 Verificación correctitud de ubicación
		if(isset($_POST['addmesa_ubicacion']) && strlen($_POST['addmesa_ubicacion']) > 0 && strlen($_POST['addmesa_ubicacion']) <= 50){
			$addmesa_ubicacion = htmlspecialchars($_POST['addmesa_ubicacion']);
		}
		//4 Verificacion correctitud capacidad maxima
		if(isset($_POST['addmesa_capmax']) && is_numeric($_POST['addmesa_capmax']) && $_POST['addmesa_capmax'] >= 0 && $_POST['addmesa_capmax'] <=9999){
			$addmesa_capmax = htmlspecialchars($_POST['addmesa_capmax']);
		}
		//5 Verificacion correctitud capacidad actual
		if(isset($_POST['addmesa_capact']) && is_numeric($_POST['addmesa_capact']) && $_POST['addmesa_capact'] == 0){
			$addmesa_capact = htmlspecialchars($_POST['addmesa_capact']);
		}
		//6 Verificación correctitud de juego
		if(isset($_POST['addmesa_juego']) && strlen($_POST['addmesa_juego']) > 0 && strlen($_POST['addmesa_juego']) <= 50){
			$addmesa_juego = htmlspecialchars($_POST['addmesa_juego']);
		}
		//7 Verificación correctitud de descripción en el caso de ser enviada, si no se deja NULL
		if(isset($_POST['addmesa_descripcion']) && strlen($_POST['addmesa_descripcion']) > 0 && strlen($_POST['addmesa_descripcion']) <= 100){
			$addmesa_descripcion = htmlspecialchars($_POST['addmesa_descripcion']);
		}
		//8 Verificación correctitud de dificultad
		if(isset($_POST['addmesa_dificultad']) && is_numeric($_POST['addmesa_dificultad']) && $_POST['addmesa_dificultad'] >= 1 && $_POST['addmesa_dificultad'] <= 5){
			$addmesa_dificultad = htmlspecialchars($_POST['addmesa_dificultad']);
		}
		//9 Verificación correctitud de estado: Debe ser 1 que indica activo, 0 indica eliminado
		if(isset($_POST['addmesa_status']) && $_POST['addmesa_status'] == 1 ){
			$addmesa_status = $_POST['addmesa_status'];
		}
		//10 Verificación correctitud de hora
		if(isset($_POST['addmesa_hora']) && is_numeric($_POST['addmesa_hora']) && $_POST['addmesa_hora'] >= 0 && $_POST['addmesa_hora'] <= 23){
			$addmesa_hora = htmlspecialchars($_POST['addmesa_hora']);
		}
		//11 Verificación correctitud de min
		if(isset($_POST['addmesa_min']) && is_numeric($_POST['addmesa_min']) && $_POST['addmesa_min'] >= 0 && $_POST['addmesa_min'] <= 59){
			$addmesa_min = htmlspecialchars($_POST['addmesa_min']);
		}
		//12 Verificación correctitud de dia
		if(isset($_POST['addmesa_dia']) && is_numeric($_POST['addmesa_dia']) && $_POST['addmesa_dia'] >= 1 && $_POST['addmesa_dia'] <= 31){
			$addmesa_dia = htmlspecialchars($_POST['addmesa_dia']);
		}
		//13 Verificación correctitud de mes
		if(isset($_POST['addmesa_mes']) && is_numeric($_POST['addmesa_mes']) && $_POST['addmesa_mes'] >= 1 && $_POST['addmesa_mes'] <= 12){
			$addmesa_mes = htmlspecialchars($_POST['addmesa_mes']);
		}
		//14 Verificación correctitud de year
		if(isset($_POST['addmesa_year']) && is_numeric($_POST['addmesa_year']) && $_POST['addmesa_year'] >= 1000 && $_POST['addmesa_year'] <= 9999){
			$addmesa_year = htmlspecialchars($_POST['addmesa_year']);
		}
		//15 Verificación correctitud de información extra, en el caso de ser enviada, si no se deja NULL
		if(isset($_POST['addmesa_info']) && strlen($_POST['addmesa_info']) > 0 && strlen($_POST['addmesa_info']) <= 300){
			$addmesa_info = htmlspecialchars($_POST['addmesa_info']);
		}
		//16 Verificación correctitud de lista de jugadores, se recibe como ":", pero en la BD podrá tener un largo max de 10000
		if(isset($_POST['addmesa_players']) && $_POST['addmesa_players'] == ":"){
			$addmesa_players = htmlspecialchars($_POST['addmesa_players']);
		}
	
		//Si todo es ingresado correctamente
		if($addmesa_master != NULL && $addmesa_number != NULL && $addmesa_ubicacion != NULL && $addmesa_capmax != NULL && $addmesa_capact != NULL 
			&& $addmesa_juego != NULL && $addmesa_dificultad != NULL && $addmesa_status != NULL && $addmesa_hora != NULL && $addmesa_min != NULL 
			&& $addmesa_dia != NULL && $addmesa_mes != NULL && $addmesa_year != NULL && $addmesa_players != NULL){
			
			$sql = sprintf("INSERT INTO mesas (num, ubicacion, cupos, cupos_ocupados, juego, descripcion, dificultad, estado, h_inicio, fecha, info_extra, jugadores) 
							VALUES (%d, '%s', %d, %d, '%s', '%s', %d, %d, '%d:%d', '%s-%s-%s', '%s', '%s')", 
							$db->real_escape_string($addmesa_number), $db->real_escape_string($addmesa_ubicacion), 
							$db->real_escape_string($addmesa_capmax), $db->real_escape_string($addmesa_capact),
							$db->real_escape_string($addmesa_juego), $db->real_escape_string($addmesa_descripcion),
							$db->real_escape_string($addmesa_dificultad), $db->real_escape_string($addmesa_status),
							$db->real_escape_string($addmesa_hora), $db->real_escape_string($addmesa_min),
							$db->real_escape_string($addmesa_year), $db->real_escape_string($addmesa_mes),
							$db->real_escape_string($addmesa_dia), $db->real_escape_string($addmesa_info),
							$db->real_escape_string($addmesa_players));
			if(!$db->query($sql)){ //Se ejecuta la query y se verifica si fue exitosa
				echo "Table mesas insert failed: (" . $db->errno . ") " . $db->error ."<br/>";
				return;
			}
			$sql =sprintf("INSERT INTO partidas (rut_master, num_mesa) VALUES ('%s', %d)", 
							$db->real_escape_string($addmesa_master), $db->real_escape_string($addmesa_number));
			if(!$db->query($sql)){ //Se ejecuta la query y se verifica si fue exitosa
				echo "Table partidas insert failed: (" . $db->errno . ") " . $db->error ."<br/>";
				return;
			}
			
			echo ('
		Se ha AGREGADO una MESA CORRECTAMENTE.<br>
		Formulario procesado.<br>');		
		}
		else{
			echo ('Se ha intentado AGREGAR una MESA INCORRECTAMENTE.<br>');
		}
	}
?>
		<a href="sistema.php">Volver a Sistema</a>
	</body>
<html>