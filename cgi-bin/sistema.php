<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Sistema Concilio</title>
		<!--Espacio para css -->
	</head>
	<body>
		<h1>Sistema Concilio</h1>
	<?php
	include_once('concilio_dbconfig.php');
	$db = DbConfig::getConnection();
	
	if($_GET){
		$buscar_input = NULL;
		$buscar_type = NULL;
		if(isset($_GET['buscar_input']) && isset($_GET['buscar_type']) && is_numeric($_GET['buscar_type']) && strlen($_GET['buscar_input']) > 0 && strlen($_GET['buscar_input']) <= 60){
			$buscar_input = $_GET['buscar_input'];
			$buscar_type = $_GET['buscar_type'];
			switch($buscar_type){
				case 1:
					if(is_numeric($buscar_input) && $buscar_input > 0 && $buscar_input <= 9999){
						$buscar_input = htmlspecialchars($buscar_input);
						echo ("El Input para buscar mesa es correcto");
						$sql = sprintf(
							"SELECT num, cupos, cupos_ocupados, jugadores, juego, dificultad, descripcion, ubicacion, h_inicio, nick, info_extra 
							FROM mesas, masters, partidas
							WHERE mesas.estado = 1 AND num = %d AND num = num_mesa AND rut = rut_master",
							$db->real_escape_string($buscar_input) );
						$result = $db->query($sql);
						$row = $result->fetch_assoc();
						//arreglar
						echo "<pre>";
						print_r($row);
						echo "</pre>";
								
					}
					break;
				case 2:
					if(strlen($buscar_input)== 9){
						$buscar_input = htmlspecialchars($buscar_input);
						echo ("El Input para buscar master por rut es correcto. REVISAR VALIDACION RUT");
						$sql = sprintf(
							"SELECT rut, nombre, nick
							FROM masters
							WHERE estado = 1 AND rut = '%s'",
							$db->real_escape_string($buscar_input)
							);
						$result = $db->query($sql);
						$row = $result->fetch_assoc();
						echo "<pre>";
						print_r($row);
						echo "</pre>";

						$sql = sprintf(
							"SELECT num, cupos, cupos_ocupados, jugadores, juego, dificultad, descripcion, ubicacion, h_inicio, info_extra
							FROM mesas, partidas
							WHERE mesas.estado = 1 AND num = num_mesa AND rut_master = '%s'",
							$db->real_escape_string($row['rut']) 
							);
						$result = $db->query($sql);
						while ($row = $result->fetch_assoc() ){
						echo "<pre>";
						print_r($row);
						echo "</pre>";
						}

					}
					break;
				case 3:
					if(strlen($buscar_input) <= 50){
						$buscar_input = htmlspecialchars($buscar_input);
						echo ("El Input para buscar master por nombre/nick es correcto");
						$sql = sprintf(
							"SELECT rut, nombre, nick
							FROM masters
							WHERE estado = 1 AND nick = '%s'",
							$db->real_escape_string($buscar_input)
							);
						$result = $db->query($sql);
						$row = $result->fetch_assoc();
						echo "<pre>";
						print_r($row);
						echo "</pre>";

						$sql = sprintf(
							"SELECT num, cupos, cupos_ocupados, jugadores, juego, dificultad, descripcion, ubicacion, h_inicio
							FROM mesas, partidas
							WHERE mesas.estado = 1 AND num = num_mesa AND rut_master = '%s'",
							$db->real_escape_string($row['rut']) 
							);
						$result = $db->query($sql);
						while ($row = $result->fetch_assoc() ){
						echo "<pre>";
						print_r($row);
						echo "</pre>";
						}

					}
					break;
				case 4:
					if(strlen($buscar_input) <= 20){
						$buscar_input = htmlspecialchars($buscar_input);
						echo ("El Input para buscar ID de jugador es correcto");
						$sql = sprintf(
							"SELECT num, cupos, cupos_ocupados, jugadores, juego, dificultad, descripcion, ubicacion, h_inicio, nick 
							FROM mesas, masters, partidas
							WHERE mesas.estado = 1 AND num = num_mesa AND rut = rut_master");
						$result = $db->query($sql);
						while ($row = $result->fetch_assoc() ){
							$pos = strpos($row['jugadores'], $buscar_input);
							if (!($pos === false) ){
								echo "<pre>";
								print_r($row);
								echo "</pre>";
								}
						}

					}
					break;
				default:
					echo ("Ha ingresado incorrectamente el tipo de búsqueda");
			}
		}
	}
	?>

		
		<!--Espacio para scripts-->
		<script type="text/javascript">
		/********************************************************************
		* FUNCIONES sobre MENU PRINCIPAL
		********************************************************************/
			//Sección de aparición y desaparición MENU PRINCIPAL
				function crear_fprincipal(){
					var dv = document.getElementById("main_menu");
					dv.setAttribute("style","display:;");
				}
				function esconder_fprincipal(){
					var dv = document.getElementById("main_menu");
					dv.setAttribute("style","display:none;");
				}
		/********************************************************************
		* FUNCIONES sobre FORMULARIO PIZARRA
		********************************************************************/
			//Sección de aparición y desaparición FORMULARIO PIZARRA
				function crear_feditboard(){
					var dv = document.getElementById("div_feditboard");
					dv.setAttribute("style","display:;");
					esconder_fprincipal();
				}
				function cancelar_feditboard(){
					var dv = document.getElementById("div_feditboard");
					dv.setAttribute("style","display:none;");
					crear_fprincipal();
				}
			//Sección validaciones internas FEDITBOARD
				function valida_editboard_text(){
					var v = document.getElementById("editboard_text").value;
					if(v.length>90){
						alert("Ha sobrepasado el límite del mensaje para pizarra");
						return false;
					}
					return true;
				}
			//Sección de validación FORMULARIO FEDITBOARD
				function valida_feditboard(){
					var v1 = valida_editboard_text();
			
					if(v1){
						alert("Los datos para editar pizarra son correctos");
						return true;
					}
					alert("Verifique los datos y reintente");
					return false;
				}
				function valida_fdelmaster(){
					var v1 = valida_delmaster_rut();
					var v2 = valida_delmaster_conf();
			
					if(v1 && v2){
						alert("Los datos para borrar master son correctos");
						return true;
					}
					alert("Verifique los datos y reintente");
					return false;
				}
		/********************************************************************
		* FUNCIONES sobre FORMULARIO MESA
		********************************************************************/
			//Sección de aparición y desaparición FORMULARIO MESA
				function crear_faddmesa(){
					var dv = document.getElementById("div_faddmesa");
					dv.setAttribute("style","display:;");
					esconder_fprincipal();
				}
				function cancelar_faddmesa(){
					var dv = document.getElementById("div_faddmesa");
					dv.setAttribute("style","display:none;");
					crear_fprincipal();
				}
				function crear_fdelmesa(){
					var dv = document.getElementById("div_fdelmesa");
					dv.setAttribute("style","display:;");
					esconder_fprincipal();
				}
				function cancelar_fdelmesa(){
					var dv = document.getElementById("div_fdelmesa");
					dv.setAttribute("style","display:none;");
					crear_fprincipal();
				}
			//Sección validaciones internas FADDMESA
				function valida_addmesa_master(){
					var v = document.getElementById("addmesa_master").value;
					if(v==="null"){
						alert("Debe seleccionar un master");
						return false;
					}
					return true;
				}
				function valida_addmesa_number(){
					var v = document.getElementById("addmesa_number").value;
					var ER = /^[0-9]{1,4}$/;
					if(v.match(ER))
						return true;
					else{
						if(v.length==0)
							alert("Debe ingresar nº de mesa");
						else
							alert("Ingrese nº de mesa correcto (hasta 4 digitos)");
						return false;
					}
				}
				function valida_addmesa_ubicacion(){
					var v = document.getElementById("addmesa_ubicacion").value;
					if(v.length==0){
						alert("Debe ingresar una Ubicaci\u00F3n");
						return false;
					}
					if(v.length>50){
						alert("La Ubicaci\u00F3n excede el límite de 50 chars");
						return false;
					}
					return true;
				}
				function valida_addmesa_capmax(){
					var v = document.getElementById("addmesa_capmax").value;
					var ER = /^[0-9]{1,4}$/;
					if(v.match(ER))
						return true;
					else{
						alert("Debe ingresar nº correcto para Capacidad M\u00E1xima de la mesa");
					}
				}
				function valida_addmesa_juego(){
					var v = document.getElementById("addmesa_juego").value;
					if(v.length==0){
						alert("Debe ingresar nombre del juego");
						return false;
					}
					if(v.length>50){
						alert("El nombre de juego no debe exceder los 50 chars");
						return false;
					}
					return true;
				}
				function valida_addmesa_descripcion(){
					var v = document.getElementById("addmesa_descripcion");
					if(v.length>100){
						alert("La descripci\u00F3n del juego no debe exceder los 100 chars");
						return false;
					}
					return true;
				}
				function valida_addmesa_dificultad(){
					var v = document.getElementById("addmesa_dificultad").value;
					if(v==="null"){
						alert("Debe seleccionar una dificultad");
						return false;
					}
					return true;
				}
				function valida_addmesa_hora(){
					var v = document.getElementById("addmesa_hora").value;
					if((v<0) || (v>23)){
						alert("Hora incorrecta, debe ser entre 0 y 23");
						return false;
					}
					return true;
				}
				function valida_addmesa_min(){
					var v = document.getElementById("addmesa_min").value;
					if((v<0) || (v>59)){
						alert("Minuto incorrecto, debe ser entre 0 y 59");
						return false;
					}
					return true;
				}
				function valida_addmesa_dia(){
					var v = document.getElementById("addmesa_dia").value;
					if((v<1) || (v>31)){
						alert("D\u00EDa incorrecto, debe ser entre 1 y 31");
						return false;
					}
					return true;
				}
				function valida_addmesa_mes(){
					var v = document.getElementById("addmesa_mes").value;
					if((v<1) || (v>12)){
						alert("Mes incorrecto, debe ser entre 1 y 12");
						return false;
					}
					return true;
				}
				function valida_addmesa_year(){
					var v = document.getElementById("addmesa_year").value;
					if((v<1000) || (v>9999)){
						alert("A\u00F1o incorrecto, debe ser entre 1000 y 9999");
						return false;
					}
					return true;
				}
				function valida_addmesa_info(){
					var v = document.getElementById("addmesa_info").value;
					if(v.length>300){
						alert("La info adicional no puede exceder los 300 chars");
						return false;
					}
					return true;
				}
			//Sección validaciones internas FDELMESA
				function valida_delmesa_number(){
					var v = document.getElementById("delmesa_number").value;
					var ER = /^[0-9]{1,4}$/;
					if(v.match(ER))
						return true;
					else{
						if(v.length==0)
							alert("Debe ingresar nº de mesa");
						else
							alert("Ingrese nº de mesa correcto (hasta 4 d\u00EDgitos)");
						return false;
					}
				}
				function valida_delmesa_conf(){
					var v1 = document.getElementById("delmesa_conf1");
					var v2 = document.getElementById("delmesa_conf2");
					if(v1.checked && v2.checked)
						return true;
					else{
						alert("Debe marcar ambas confirmaciones");
						return false;
					}
				}
			//Sección de validación FORMULARIO MESA
				function valida_faddmesa(){
					var v1 = valida_addmesa_master();
					var v2 = valida_addmesa_number();
					var v3 = valida_addmesa_ubicacion();
					var v4 = valida_addmesa_capmax();
					var v5 = valida_addmesa_juego();
					var v6 = valida_addmesa_descripcion();
					var v7 = valida_addmesa_dificultad();
					var v8 = valida_addmesa_hora();
					var v9 = valida_addmesa_min();
					var v10 = valida_addmesa_dia();
					var v11 = valida_addmesa_mes();
					var v12 = valida_addmesa_year();
					var v13 = valida_addmesa_info();
			
					if(v1 && v2 && v3 && v4 && v5 && v6 && v7 && v8 && v9 && v10 && v11 && v12 && v13){
						alert("Los datos para agregar mesa son correctos");
						return true;
					}
					alert("Verifique los datos y reintente");
					return false;
				}
				function valida_fdelmesa(){
					var v1 = valida_delmesa_number();
					var v2 = valida_delmesa_conf();
			
					if(v1 && v2){
						alert("Los datos para borrar mesa son correctos");
						return true;
					}
					alert("Verifique los datos y reintente");
					return false;
				}
		/********************************************************************
		* FUNCIONES sobre FORMULARIO MASTER
		********************************************************************/
			//Sección de aparición y desaparición FORMULARIO MASTER
				function crear_faddmaster(){
					var dv = document.getElementById("div_faddmaster");
					dv.setAttribute("style","display:;");
					esconder_fprincipal();
				}
				function cancelar_faddmaster(){
					var dv = document.getElementById("div_faddmaster");
					dv.setAttribute("style","display:none;");
					crear_fprincipal();
				}
				function crear_fdelmaster(){
					var dv = document.getElementById("div_fdelmaster");
					dv.setAttribute("style","display:;");
					esconder_fprincipal();
				}
				function cancelar_fdelmaster(){
					var dv = document.getElementById("div_fdelmaster");
					dv.setAttribute("style","display:none;");
					crear_fprincipal();
				}
			//Sección validaciones internas FADDMASTER
				function valida_addmaster_rut(){
					var v = document.getElementById("addmaster_rut").value;
					var ER = /(^([1-9]{1})+([0-9]{7})+(K|[0-9])$)|((^([0])+([1-9])([0-9]{6})+(K|[0-9])$))/;
			
					if(v.match(ER))
						return true;
					else{
						if(v.length==0)
							alert("Debe ingresar RUT del master");
						else
							alert("Debe Ingresar RUT sin puntos ni guiones");
						return false;
					}		
				}
				function valida_addmaster_nombre(){
					var v1 = document.getElementById("addmaster_name").value;
					var v2 = document.getElementById("addmaster_nick").value;
					if((v1.length==0) && (v2.length==0)){
						alert("Debe ingresar nombre de master o nick de master");
						return false;
					}
					if(v1.length>50){
						alert("El nombre de master no debe exceder los 50 chars");
						return false;
					}
					if(v2.length>50){
						alert("El nick de master no debe exceder los 50 chars");
						return false;
					}
					return true;
				}
			//Sección validaciones internas FDELMASTER
				function valida_delmaster_rut(){
					var v = document.getElementById("delmaster_rut").value;
					var ER = /(^([1-9]{1})+([0-9]{7})+(K|[0-9])$)|((^([0])+([1-9])([0-9]{6})+(K|[0-9])$))/;
					if(v.match(ER))
						return true;
					else{
						if(v.length==0)
							alert("Debe ingresar RUT de master a eliminar");
						else
							alert("Ingrese RUT correcto sin puntos ni guiones (ej: 12345678K o 01234567K)");
						return false;
					}
				}
				function valida_delmaster_conf(){
					var v1 = document.getElementById("delmaster_conf1");
					var v2 = document.getElementById("delmaster_conf2");
					if(v1.checked && v2.checked)
						return true;
					else{
						alert("Debe marcar ambas confirmaciones");
						return false;
					}
				}
			//Sección de validación FORMULARIO MASTER
				function valida_faddmaster(){
					var v1 = valida_addmaster_rut();
					var v2 = valida_addmaster_nombre();
			
					if(v1 && v2){
						alert("Los datos para agregar master son correctos");
						return true;
					}
					alert("Verifique los datos y reintente");
					return false;
				}
				function valida_fdelmaster(){
					var v1 = valida_delmaster_rut();
					var v2 = valida_delmaster_conf();
			
					if(v1 && v2){
						alert("Los datos para borrar master son correctos");
						return true;
					}
					alert("Verifique los datos y reintente");
					return false;
				}
		/********************************************************************
		* FUNCIONES sobre FORMULARIO JUGADOR
		********************************************************************/
			//Sección de aparición y desaparición FORMULARIO JUGADOR
				function crear_faddplayer(){
					var dv = document.getElementById("div_faddplayer");
					dv.setAttribute("style","display:;");
					esconder_fprincipal();
				}
				function cancelar_faddplayer(){
					var dv = document.getElementById("div_faddplayer");
					dv.setAttribute("style","display:none;");
					crear_fprincipal();
				}
				function crear_fdelplayer(){
					var dv = document.getElementById("div_fdelplayer");
					dv.setAttribute("style","display:;");
					esconder_fprincipal();
				}
				function cancelar_fdelplayer(){
					var dv = document.getElementById("div_fdelplayer");
					dv.setAttribute("style","display:none;");
					crear_fprincipal();
				}
			//Sección validaciones internas FADDPLAYER
				function valida_addplayer_mesa(){
					var v = document.getElementById("addplayer_mesa").value;
					var ER = /^[0-9]{1,4}$/;
					if(v.match(ER))
						return true;
					else{
						if(v.length==0)
							alert("Debe ingresar nº de mesa");
						else
							alert("Ingrese nº de mesa correcto (hasta 4 d\u00EDgitos)");
						return false;
					}
				}
				function valida_addplayer_player(){
					var v = document.getElementById("addplayer_player").value;
					if(v.length==0){
						alert("Debe ingresar identificador del jugador.");
						return false;
					}
					if(v.length>20){
						alert("El identificador de jugador no puede exceder los 20 chars");
						return false;
					}
					return true;
				}
			//Sección validaciones internas FDELPLAYER
				function valida_delplayer_mesa(){
					var v = document.getElementById("delplayer_mesa").value;
					var ER = /^[0-9]{1,4}$/;
					if(v.match(ER))
						return true;
					else{
						if(v.length==0)
							alert("Debe ingresar nº de mesa");
						else
							alert("Ingrese nº de mesa correcto (hasta 4 d\u00EDgitos)");
						return false;
					}
				}
				function valida_delplayer_player(){
					var v = document.getElementById("delplayer_player").value;
					if(v.length==0){
						alert("Debe ingresar identificador del jugador.");
						return false;
					}
					if(v.length>20){
						alert("El identificador de jugador no puede exceder los 20 chars");
						return false;
					}
					return true;
				}
				function valida_delplayer_conf(){
					var v1 = document.getElementById("delplayer_conf1");
					var v2 = document.getElementById("delplayer_conf2");
					if(v1.checked && v2.checked)
						return true;
					else{
						alert("Debe marcar ambas confirmaciones");
						return false;
					}
				}
			//Sección de validación FORMULARIO JUGADOR
				function valida_faddplayer(){
					var v1 = valida_addplayer_mesa();
					var v2 = valida_addplayer_player();
			
					if(v1 && v2){
						alert("Los datos para agregar jugador son correctos");
						return true;
					}
					alert("Verifique los datos y reintente");
					return false;
				}
				function valida_fdelplayer(){
					var v1 = valida_delplayer_mesa();
					var v2 = valida_delplayer_player();
					var v3 = valida_delplayer_conf();
			
					if(v1 && v2 && v3){
						alert("Los datos para borrar jugador son correctos");
						return true;
					}
					alert("Verifique los datos y reintente");
					return false;
				}
		/********************************************************************/
		</script>

		<!-- Texto estático-->
		
		<div id="div_buscador">
		<!-- FORMULARIO de BÚSQUEDA-->
			<form action="#" name="buscador" id="buscador" method="GET" enctype="multipart/form-data" onSubmit="return valida_busqueda();">
				<fieldset>
					<label for="buscar_input">Buscar elemento : </label>
					<input type="text" name="buscar_input" id="buscar_input" size="30" maxlength="60">
					<select id="buscar_type" name="buscar_type">
							<option value="null">Seleccione tipo</option>
							<option value="1">Nº Mesa</option>
							<option value="2">RUT Master</option>
							<option value="3">Nombre/Nick Master</option>
							<option value="4">ID Jugador</option>
					</select>
					<input type="submit" value="Buscar">
				</fieldset>
			</form>
		</div>
		<div id="display_busqueda">
		<!-- DISPLAY BÚSQUEDA -->
			<div id="display_mesa">
				<!-- Div para mostrar información de mesa buscada -->
			</div>
			<div id="display_master">
				<!-- Div para mostrar información de master buscado -->
			</div>
			<div id="display_player">
				<!-- Div para mostrar información de jugador buscado -->
			</div>
		</div>
		<div>
		<!--Texto estático-->
			<h3>Sección de acciones:</h3>
		</div>
		<!--***********************************************************************************************************
		*  FORMULARIOS
		***************************************************************************************************************
		- Hay un menú de botones para saber qué accioens se pueden realizar.
		- Al hacer click en algún botón desaparecerá el menú principal y aparecerá el formulario solicitado
		- Cada formulario es independiente de los otros.
		- Al cancelar el formulario se hace invisible y se hace visible el menú principal nuevamente.
		************************************************************************************************************ -->
		<div id="main_menu">
			<!-- *******************************************************************************************************
			*     MENU PRINCIPAL
			******************************************************************************************************** -->
			<!-- Acciones para Mesas-->
			<label for="main_addmesa">Acciones sobre MESA : </label>
			<input type="button" name="main_addmesa" id="main_addmesa" value="Agregar mesa" onClick="crear_faddmesa();">
			<input type="button" name="main_delmesa" id="main_delmesa" value="Borrar mesa" onClick="crear_fdelmesa();">
			<br>
			<!-- Acciones para Masters-->
			<label for="main_addmaster">Acciones sobre MASTER : </label>
			<input type="button" name="main_addmaster" id="main_addmaster" value="Agregar master" onClick="crear_faddmaster();">
			<input type="button" name="main_delmaster" id="main_delmaster" value="Borrar master" onClick="crear_fdelmaster();">
			<br>
			<!-- Acciones para Mesas-->
			<label for="main_addplayer">Acciones sobre JUGADORES : </label>
			<input type="button" name="main_addplayer" id="main_addplayer" value="Agregar jugador" onClick="crear_faddplayer();">
			<input type="button" name="main_delplayer" id="main_delplayer" value="Borrar jugador" onClick="crear_fdelplayer();">
			<br>
			<!-- Acciones para Pizarra-->
			<label for="main_editboard">Acciones sobre PIZARRA : </label>
			<input type="button" name="main_editboard" id="main_editboard" value="Editar pizarra" onClick="crear_feditboard();">
			<!-- -->
			<br>
		</div>
		
		<div id="div_faddmesa" style="display:none;">
			<form action="addmesa.php" name="faddmesa" id="faddmesa" method="POST" enctype="multipart/form-data" onSubmit="return valida_faddmesa();">
				<fieldset>
					<!-- *************************************************************************
					*         FORMULARIO AGREGAR MESA 
					************************************************************************** -->
					<!--TÍTULO FORMULARIO-->
					<h3><label id="addmesa_title">Formulario para agregar mesa : </label></h3>
					<p>
						<!--Master-->
						<label for="addmesa_master">Master (*) :</label>
						<select id="addmesa_master" name="addmesa_master">
							<option value="null">Seleccione nick master</option>
							<?php
								
								//Obtener los datos de los masters activos
							
								$sql = sprintf("SELECT rut, nick FROM masters WHERE estado = 1");
								$result = $db->query($sql);
								while( $row = $result->fetch_assoc() ){
									echo "<option value=".$row['rut'].">".$row['nick']."</option>";
								}
							
							?>
							
						</select>
					</p>
					<p>
						<!--Número de la mesa (identificador)-->
						<label for="addmesa_number">Número (*) :</label>
						<input type="text" name="addmesa_number" id="addmesa_number" size="4" maxlength="4">
					</p>
					<p>
						<!--Ubicación-->
						<label for="addmesa_ubicacion">Ubicación (*) : </label>
						<input type="text" name="addmesa_ubicacion" id="addmesa_ubicacion" size="30" maxlength="50">
					</p>
					<p>
						<!--CAP MAX-->
						<label for="addmesa_capmax">Capacidad máxima (*) (0 para no límite): </label>
						<!-- si la capmax<=0 significa que no tiene límite asignado-->
						<input type="text" name="addmesa_capmax" id="addmesa_capmax" size="3" maxlength="4" value="0">
					</p>
					<p>
						<!--CAP ACTUAL, debe ser hidden porque no debería haber nadie en la mesa al momento de crear-->
						<input type="hidden" name="addmesa_capact" id="addmesa_capact" value="0">
					</p>
					<p>
						<!--Nombre JUEGO-->
						<label for="addmesa_juego">Nombre juego (*) : </label>
						<input type="text" name="addmesa_juego" id="addmesa_juego" size="30" maxlength="50">
					</p>
					<p>
						<!--Descripción juego-->
						<label for="addmesa_descripcion">Descripción breve juego : </label>
						<input type="text" name="addmesa_descripcion" id="addmesa_descripcion" size="50" maxlength="100">
					</p>
					<p>
						<!--Dificultad-->
						<label for="addmesa_dificultad">Nivel del jugador (*) :</label>
						<select id="addmesa_dificultad" name="addmesa_dificultad">
							<option value="null">Seleccione nivel</option>
							<option value="1">Novato</option>
							<option value="2">Normal</option>
							<option value="3">Avanzado</option>
							<option value="4">Experto</option>
							<option value="5">Cualquiera</option>
						</select>
					</p>
					<p>
						<!--Estado: 1 Activo, 0 Eliminado-->
						<input type="hidden" name="addmesa_status" id="addmesa_status" value="1">
					</p>
					<p>
						<!--Horario inicio-->
						<label for="addmesa_hora">Hora inicio (*) (ej: 23 : 50) :</label>
						<input type="text" id="addmesa_hora" name="addmesa_hora" size="1" maxlength="2"> : 
						<input type="text" id="addmesa_min" name="addmesa_min" size="1" maxlength="2">
					</p>
					<p>
						<!--Fecha inicio-->
						<label for="addmesa_dia">Fecha inicio (*) (DD/MM/AAAA) :</label>
						<input type="text" id="addmesa_dia" name="addmesa_dia" size="1" maxlength="2"> / 
						<input type="text" id="addmesa_mes" name="addmesa_mes" size="1" maxlength="2"> / 
						<input type="text" id="addmesa_year" name="addmesa_year" size="2" maxlength="4">
					</p>
					<p>
						<!-- Informaciona dicional-->
						<label for="addmesa_info">Información adicional (máx 300 chars) :</label><br>
						<textarea name="addmesa_info" id="addmesa_info" rows="4" cols="50" form="faddmesa" maxlength="300"></textarea>
					</p>
					<p>
						<!-- Dónde se guardará el id de jugadores de la mesa, dicha lista será de la forma :jugador1:jugador2:jugador3:..:jugadorn:-->
						<input type="hidden" id="addmesa_players" name="addmesa_players" value=":">
					</p>
					<p>
						<!--Botones de submit y cancel-->
						<input type="submit" value="Aceptar"> <input type="button" id="addmesa_cancel" name="addmesa_cancel" value="Cancelar" onClick="cancelar_faddmesa();">
					</p>
				</fieldset>
			</form>
		</div>
		<div id="div_fdelmesa" style="display:none;">
			<form action="delmesa.php" name="fdelmesa" id="fdelmesa" method="POST" enctype="multipart/form-data" onSubmit="return valida_fdelmesa();">
				<fieldset>
					<!-- *************************************************************************
					*         FORMULARIO QUITAR MESA 
					************************************************************************** -->
					<h3><label id="delmesa_title">Formulario para eliminar mesa : </label></h3>
					<p>
						<!-- MESA que será borrada-->
						<label for="delmesa_number">Nº de mesa a borrar (*) : </label>
						<input type="text" name="delmesa_number" id="delmesa_number" size="4" maxlength="4">
					</p>
					<p>
						<!--Confirmaciones-->
						<input type="checkbox" name="delmesa_conf1" id="delmesa_conf1" value="1"> ¿Quiere borrar esta mesa?
						<br>
						<input type="checkbox" name="delmesa_conf2" id="delmesa_conf2" value="2"> ¿Está seguro de querer borrar esta mesa?
					</p>
					<p>
						<!--Botones de submit y cancel-->
						<input type="submit" value="Aceptar"> <input type="button" id="delmesa_cancel" name="delmesa_cancel" value="Cancelar" onClick="cancelar_fdelmesa();">
					</p>
				</fieldset>
			</form>
		</div>
		<div id="div_faddmaster" style="display:none;">
			<form action="addmaster.php" name="faddmaster" id="faddmaster" method="POST" enctype="multipart/form-data" onSubmit="return valida_faddmaster();">
				<fieldset>
					<!-- *************************************************************************
					*         FORMULARIO AGREGAR MASTER
					************************************************************************** -->
					<h3><label id="addmaster_title">Formulario para agregar master : </label></h3>
					<p>
						<!-- RUT del Master a agregar-->
						<label for="addmaster_rut">Rut master (*) (formato: 12345678K o 01234567K) : </label>
						<input type="text" name="addmaster_rut" id="addmaster_rut" size="7" maxlength="9">
					</p>
					<i>Tiene que ingresar al menos su nick o su nombre</i><br>
					<!-- Esta parte debe corportarse de manera que si no entrega uno de los datos este se rellena
					con el que sí fue entregado -->
					<p>
						<!-- Nombre del master -->
						<label for="addmaster_name">Nombre del master : </label>
						<input type="text" name="addmaster_name" id="addmaster_name" size="10" maxlength="50">
					</p>
					<p>
						<!-- Nick del master -->
						<label for="addmaster_nick">Nick del master : </label>
						<input type="text" name="addmaster_nick" id="addmaster_nick" size="10" maxlength="50">
					</p>
					<p>
						<!-- Estado: 1 vigente, 0 eliminado-->
						<input type="hidden" name="addmaster_status" id="addmaster_status" value="1">
					</p>
					<p>
						<!--Botones de submit y cancel-->
						<input type="submit" value="Aceptar"> <input type="button" id="addmaster_cancel" name="addmaster_cancel" value="Cancelar" onClick="cancelar_faddmaster();">
					</p>
				</fieldset>
			</form>
		</div>
		<div id="div_fdelmaster" style="display:none;">
			<form action="delmaster.php" name="fdelmaster" id="fdelmaster" method="POST" enctype="multipart/form-data" onSubmit="return valida_fdelmaster();">
				<fieldset>
					<!-- *************************************************************************
					*         FORMULARIO QUITAR MASTER
					************************************************************************** -->
					<h3><label id="delmaster_title">Formulario para eliminar master : </label></h3>
					<p>
						<!-- Master que será borrado-->
						<label for="delmaster_rut">RUT del master a borrar (*) : </label>
						<input type="text" name="delmaster_rut" id="delmaster_rut" size="7" maxlength="9">
					</p>
					<p>
						<!--Confirmaciones-->
						<input type="checkbox" name="delmaster_conf1" id="delmaster_conf1" value="1"> ¿Quiere borrar este master?
						<br>
						<input type="checkbox" name="delmaster_conf2" id="delmaster_conf2" value="2"> ¿Está seguro de querer borrar este master?
					</p>
					<p>
						<!--Bototnes de submit y cancel-->
						<input type="submit" value="Aceptar"> <input type="button" id="delmaster_cancel" name="delmaster_cancel" value="Cancelar" onClick="cancelar_fdelmaster();">
					</p>
				</fieldset>
			</form>
		</div>
		<div id="div_faddplayer" style="display:none;">
			<form action="addplayer.php" name="faddplayer" id="faddplayer" method="POST" enctype="multipart/form-data" onSubmit="return valida_faddplayer();">
				<fieldset>
					<!-- *************************************************************************
					*         FORMULARIO AGREGAR JUGADOR
					************************************************************************** -->
					<h3><label id="addplayer_title">Formulario para agregar jugador : </label></h3>
					<p>
						<!-- Mesa donde el jugador será agregado-->
						<label for="addplayer_mesa">Mesa del jugador a agregar (*) : </label>
						<input type="text" name="addplayer_mesa" id="addplayer_mesa" size="4" maxlength="4">
					</p>
					<p>
						<!-- Nº de jugador, no obligatorio -->
						<label for="addplayer_player">ID jugador a agregar (*): </label>
						<input type="text" name="addplayer_player" id="addplayer_player" size="6" maxlength="20">
					</p>
					<p>
						<!--Botones de submit y cancel-->
						<input type="submit" value="Aceptar"><input type="button" id="addplayer_cancel" name="addplayer_cancel" value="Cancelar" onClick="return cancelar_faddplayer();">
					</p>
				</fieldset>
			</form>
		</div>
		<div id="div_fdelplayer" style="display:none;">
			<form action="delplayer.php" name="fdelplayer" id="fdelplayer" method="POST" enctype="multipart/form-data" onSubmit="return valida_fdelplayer();">
				<fieldset>
					<!-- *************************************************************************
					*         FORMULARIO QUITAR JUGADOR
					************************************************************************** -->
					<h3><label id="delplayer_title">Formulario para eliminar jugador : </label></h3>
					<p>
						<!-- Mesa del jugador que será borrado-->
						<label for="delplayer_mesa">Mesa del jugador a borrar (*) : </label>
						<input type="text" name="delplayer_mesa" id="delplayer_mesa" size="4" maxlength="4">
					</p>
					<p>
						<!-- Nº de jugador, no obligatorio -->
						<label for="delplayer_player">ID jugador a borrar (*): </label>
						<input type="text" name="delplayer_player" id="delplayer_player" size="6" maxlength="20">
					</p>
					<p>
						<!--Confirmaciones-->
						<input type="checkbox" name="delplayer_conf1" id="delplayer_conf1" value="1"> ¿Quiere borrar este jugador?
						<br>
						<input type="checkbox" name="delplayer_conf2" id="delplayer_conf2" value="2"> ¿Está seguro de querer borrar este jugador de esa mesa?
					</p>
					<p>
						<!--Botones de submit y cancel-->
						<input type="submit" value="Aceptar"><input type="button" id="delplayer_cancel" name="delplayer_cancel" value="Cancelar" onClick="return cancelar_fdelplayer();">
					</p>
				</fieldset>
			</form>
		</div>
		<div id="div_feditboard" style="display:none;">
			<form action="editboard.php" name="feditboard" id="feditboard" method="POST" enctype="multipart/form-data" onSubmit="return valida_feditboard();">
				<fieldset>
					<!-- *************************************************************************
					*         FORMULARIO EDITAR PIZARRA
					************************************************************************** -->
					<h3><label id="editboard_title">Formulario para editar pizarra : </label></h3>
					<p>
						<!--Texto en la pizarra-->
						<label for="editboard_text">Texto en la parte inferior de la pizarra : </label><br>
						<textarea name="editboard_text" id="editboard_text" rows="4" cols="50" form="feditboard" maxlength="90"><?php
								//Obtener mensaje actual de la pizarra
								$sql = sprintf("SELECT * FROM mensajes ORDER BY id DESC LIMIT 1");
								$result = $db->query($sql);
								$row = $result->fetch_assoc();
								echo "".$row['value'];
							?></textarea>
					</p>
					<p>
						<!--Botones de submit y cancel-->
						<input type="submit" value="Aceptar"><input type="button" id="editboard_cancel" name="editboard_cancel" value="Cancelar" onClick="return cancelar_feditboard();">
					</p>
				</fieldset>
			</form>
		</div>
		<div>
			<br>
			<a href="../index.html">&#60;&#60; Volver</a>
			<br>
			<br>
		</div>
	</body>
</html>