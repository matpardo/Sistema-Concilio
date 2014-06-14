<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Pizarra Sistema Concilio</title>
	</head>
	<body>
<?php
$con=mysqli_connect("localhost","root","","sistema_concilio");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$num_tables=1;
$count_rows=0;
$result = mysqli_query($con,"SELECT * FROM mensajes ORDER BY id DESC LIMIT 1");
$row = mysqli_fetch_array($result);
mysqli_close($con);
?>
		<div>
		<marquee class="fijo" scrollamount=10 id="aviso" style="background-color:white;">
		<label id="mensajillo">
		<h2><?php echo utf8_encode($row['value']); ?></h2>
		</label>
		</marquee>
		</div>
		<script>	
		setInterval('window.location.reload()', 20000);
		</script>	

	</body>
</html>
