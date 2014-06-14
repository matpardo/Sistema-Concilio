<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Editar Pizarra</title>
		<!--Espacio para css -->
		
		<!--Espacio para scripts-->
	</head>
	<body>
<?php
	include_once('concilio_dbconfig.php');
	$db = DbConfig::getConnection();
	
	if($_POST){
		// Parámetros del POST para addmaster.php
		$editboard_text = NULL;
		
		//Verificación correctitud del mensaje (editboard_text)
		if(isset($_POST['editboard_text'])){
			$editboard_text = htmlspecialchars($_POST['editboard_text']); 
		}
	
		//Si todo es ingresado correctamente
		if($editboard_text != NULL){
			$sql = sprintf("INSERT INTO mensajes (value) VALUES ('%s')", $db->real_escape_string($editboard_text));
			if(!$db->query($sql)){ //Se ejecuta la query y se verifica si fue exitosa
				echo "Table insert failed: (" . $db->errno . ") " . $db->error ."<br/>";
				return;
			}
			echo ('Se ha intentado EDITAR la PIZARRA CORRECTAMENTE.<br>
			Formulario procesado.<br>');
		}
		else{
			echo ('Se ha intentado EDITAR la PIZARRA INCORRECTAMENTE.<br>');
		}
	}
?>
		<a href="sistema.php">Volver a Sistema</a>
	</body>
<html>