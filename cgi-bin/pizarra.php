<!DOCTYPE html>
<html>
	<head>
		 <meta charset="UTF-8">
		<title>Pizarra Sistema Concilio</title>
		<!--Espacio para css -->
		<!--Espacio para scripts-->
	</head>
	<body>
<div>			
<?php
function verDif($num){
	if ($num == 1) {
		return "Novato";
	} elseif ($num == 2) {
		return "Normal";
	} elseif ($num == 3) {
		return "Avanzado";
	}elseif ($num == 4) {
		return "Experto";
	}else{
		return "Cualquiera";
	}
}
function verCap($num){
	if ($num == 0){
		return "";
	}
	return "-".$num;
}
$con=mysqli_connect("localhost","root","","sistema_concilio");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$num_tables=1;
$count_rows=0;
$result = mysqli_query($con,"SELECT num, juego, cupos, cupos_ocupados, dificultad, ubicacion, h_inicio, masters.nick FROM mesas, masters, partidas WHERE mesas.estado=1 AND rut = rut_master
AND num = num_mesa ORDER BY num");
while(($row = mysqli_fetch_array($result)) ){	
	if($count_rows == 0)
	{
		echo "<table id='table_".$num_tables."' border='1'  style='display:none;'>
		<tr>
		<th width='5%'>Mesa</th>
		<th width='10%'>Juego</th>
		<th width='15%'>Master</th>
		<th width='10%'>Cupos</th>
		<th width='10%'>dificultad</th>
		<th width='40%'>ubicacion</th>
		<th width='10%'>hora de inicio</th>
		</tr>";
	}
	echo "<tr>";
	echo "<td>" . utf8_encode($row['num']) . "</td>";
	echo "<td>" . utf8_encode($row['juego']) . "</td>";
	echo "<td>" . utf8_encode($row['nick']) . "</td>";
	echo "<td>" . utf8_encode($row['cupos_ocupados'] .verCap($row['cupos'])) . "</td>";
	echo "<td>" . utf8_encode(verDif( $row['dificultad'] )) . "</td>";
	echo "<td>" . utf8_encode($row['ubicacion']) . "</td>";
	echo "<td>" . utf8_encode($row['h_inicio']) . "</td>";
	echo "</tr>";
	$count_rows++;
	if($count_rows == 16)
	{
		$count_rows = 0;
		$num_tables++;
		echo "</table>";
	}
}
echo "</table>";
mysqli_close($con);
?>
</div>

<script>
var actual_table=1;
var num_tables=<?php echo $num_tables;?>;
	function rotate_tables(){
		for(var i=1;i<=num_tables;i++){
			if(i == actual_table){
				document.getElementById("table_"+i).style.display="compact";
			}
			else{
				document.getElementById('table_'+i).style.display="none";
			}
		}
		if(actual_table > num_tables)
		{
			window.location.reload();
		}
		actual_table++;
	}
window.onload=rotate_tables();
</script>
<script>	
window.onload=setInterval(rotate_tables, 5000);
</script>	
	</body>
	
</html>
