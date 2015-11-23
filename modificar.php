<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Ejemplo de formularios con datos en BD</title>
	</head>
	<body>
		<?php
	
			$con = mysqli_connect('localhost', 'root', '', 'bd_reservas1');
			$usuemail = $_REQUEST['usu_email'];
			
			$sql = "SELECT * FROM tbl_usuario WHERE usu_email='$usuemail'";

			$datos = mysqli_query($con, $sql);
			if(mysqli_num_rows($datos)>0){
				$prod=mysqli_fetch_array($datos);
				?>
				<form name="formulario1" action="modificar.proc.php" method="get">
				<input type="hidden" name="usu_email" value="<?php echo $prod['usu_email']; ?>">
				Nombre:<br/>
				<input type="text" name="nom" size="20" maxlength="25" value="<?php echo $prod['usu_nom']; ?>"><br/>
				Correo:<br/>
				<input type="text" name="mail" size="20"maxlength="25" value="<?php echo $prod['usu_email']; ?>"><br/>
				Rango:<br/>
				<select name="tip">
				<?php
					//esta consulta devuelve todos los datos del producto cuyo campo clave (pro_id) es igual a la id que nos llega por la barra de direcciones
					$sql = "SELECT DISTINCT usu_rang FROM tbl_usuario";
					//lanzamos la sentencia sql que devuelve todos los tipos de producto
					$tipos = mysqli_query($con, $sql);

					while ($tbl_usuario=mysqli_fetch_array($tipos)){
						echo "<option value='$tbl_usuario[usu_rang]'";

						if($tbl_usuario['usu_rang']==$prod['usu_rang']){
							echo " selected";
						}

						echo ">$tbl_usuario[usu_rang]</option>";
					}

				?>
				</select><br/><br/>
							
				<input type="submit" value="Guardar">
				</form>
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