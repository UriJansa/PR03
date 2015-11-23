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
			
			//como la sentencia SIEMPRE va a buscar todos los registros de la tabla producto, pongo en la variable $sql esa parte de la sentencia que SI o SI, va a contener
			$sql = "SELECT * FROM tbl_usuario ORDER BY usu_email ASC";

			//mostramos la consulta para ver por pantalla si es lo que esperábamos o no
			//echo "$sql<br/>";

			//lanzamos la sentencia sql
			$datos = mysqli_query($con, $sql);
			?>
		<form action="insertar.proc.php" method="GET">
			Email:<br/>
			<input type="text" name="email" size="20" maxlength="25"><br/>
			Nombre:<br/>
			<input type="text" name="nombre" size="20" maxlength="25"><br/>
			Contaseña (max 15 alfanumerico):<br/>
			<input type="text" name="contra" size="20" maxlength="15"><br/>
			Rango:<br/>
			<select name="tip">
				<?php
					$sql = "SELECT DISTINCT usu_rang FROM tbl_usuario";
					$tipos = mysqli_query($con, $sql);

					while ($tbl_usuario=mysqli_fetch_array($tipos)){
						echo "<option value='$tbl_usuario[usu_rang]'";

						if($tbl_usuario['usu_rang']==$tbl_usuario['usu_rang']){
							echo " selected";
						}

						echo ">$tbl_usuario[usu_rang]</option>";
					}

				?>
				</select><br/><br/>
			<input type="submit" value="Enviar">
		</form>
		<br/><br/>
		<a href="index1.php">Volver</a>
	</body>
</html>