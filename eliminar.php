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
			echo "$usuemail";
			//esta consulta devuelve todos los datos del producto cuyo campo clave (pro_id) es igual a la id que nos llega por la barra de direcciones
			$sql = "SELECT * FROM tbl_usuario WHERE usu_email='$usuemail'";

			//mostramos la consulta para ver por pantalla si es lo que esperábamos o no
			//echo "$sql<br/>";

			//lanzamos la sentencia sql
			$datos = mysqli_query($con, $sql);
			if(mysqli_num_rows($datos)>0){
			$prod=mysqli_fetch_array($datos);
				?>
				<table border=1>
					<tr>
						<th>Nombre</th>
						<th>Correo</th>
						<th>Tipo Usuario</th>
					</tr>

					<?php

					//recorremos los resultados y los mostramos por pantalla
					//la función substr devuelve parte de una cadena. A partir del segundo parámetro (aquí 0) devuelve tantos carácteres como el tercer parámetro (aquí 25)
					$prod = mysqli_fetch_array($datos);
					echo "<tr>";
					echo "<td>$prod[usu_mail]</td>";
					
					echo "<td>$prod[usu_nom]</td>";
					echo "<td>$prod[usu_rang]</td>";
					echo "</tr>";

					?>
					<tr>
					<td>Eliminar?</td>
					<td>
					<?php
					echo "<a href='eliminar.proc.php?usu_email=$usuemail'>Si</a>";
					?>
					</td>
					<td><a href="index.php">No</td>
					</tr>
				</table>

					<?php
			} else {
				echo "Producto con usu_email='$usuemail' no encontrado!";
			}
			//cerramos la conexión con la base de datos
			mysqli_close($con);
		?>
		<br/><br/>
		<a href="index1.php">Volver</a>
	</body>
</html>