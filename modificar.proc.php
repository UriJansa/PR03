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
			$usuemail = $_REQUEST['usu_email'];
			$sql = "UPDATE tbl_usuario SET usu_nom='$_REQUEST[nom]', usu_email='$_REQUEST[mail]', usu_rang='$_REQUEST[tip]' WHERE usu_email='$usuemail'";
	
	
			//echo $sql;
			echo "$sql";
			//lanzamos la sentencia sql
			$datos = mysqli_query($con, $sql);
			
			header("location: index1.php")
			
		?>
	</body>
</html>