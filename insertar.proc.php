<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Ejemplo de formularios con datos en BD</title>
	</head>
	<body>
		<?php
			//realizamos la conexión con mysql
			$con = mysqli_connect('localhost', 'root', '', 'bd_reservas1');
			
			$sql = "INSERT INTO tbl_usuario (usu_email, usu_nom, usu_rang, usu_contra) VALUES ('$_REQUEST[email]', '$_REQUEST[nombre]', '$_REQUEST[tip]', '$_REQUEST[contra]')";

			
			//lanzamos la sentencia sql
			$datos = mysqli_query($con, $sql);

			header("location: index1.php")
		?>
	</body>
</html>