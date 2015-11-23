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
			$sql = "DELETE FROM tbl_usuario WHERE usu_email='$usuemail'";

			//mostramos la consulta para ver por pantalla si es lo que esperábamos o no
			//echo "$sql<br/>";

			//lanzamos la sentencia sql
			$datos = mysqli_query($con, $sql);
			
			if(mysqli_affected_rows($con)==1){
				header("location:index1.php");
				//echo "Producto con usu_email=$_REQUEST['usu_email'] eliminado!";
			} elseif(mysqli_affected_rows($con)==0){
				echo "No se ha eliminado ningún producto por que no existe en la BD";
			} else {
				echo "Ha pasado algo raro";
			}

			//cerramos la conexión con la base de datos
			mysqli_close($con);
		?>
		<br/><br/>
		<a href="index1.php">Volver</a>
	</body>
</html>