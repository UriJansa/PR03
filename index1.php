<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Ejemplo de formularios con datos en BD</title>
	    <!-- full d'estils per a fer servir fonts d'icons -->
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	    <style>
	    	a {color: blue;}
	    </style>
	</head>
	<body>
		<?php
			//realizamos la conexión con mysql
			$con = mysqli_connect('localhost', 'root', '', 'bd_reservas1');

			//como la sentencia SIEMPRE va a buscar todos los registros de la tabla producto, pongo en la variable $sql esa parte de la sentencia que SI o SI, va a contener
			$sql = "SELECT * FROM tbl_usuario";

			//mostramos la consulta para ver por pantalla si es lo que esperábamos o no
			//echo "$sql<br/>";

			//lanzamos la sentencia sql
			$datos = mysqli_query($con, $sql);

			?>
			<table border>
				<tr>
					<th>Nombre</th>
					<th>Correo</th>
					<th>Tipo Usuario</th>
					<th>Operaciones</th>
				</tr>

				<?php

				//recorremos los resultados y los mostramos por pantalla
				//la función substr devuelve parte de una cadena. A partir del segundo parámetro (aquí 0) devuelve tantos carácteres como el tercer parámetro (aquí 25)
				while ($prod = mysqli_fetch_array($datos)){
					echo "<td>$prod[usu_nom]";
					echo "</td><td>$prod[usu_email]";
					echo "<td>$prod[usu_rang]</td><td>";
					
				
					echo "<a href='modificar.php?usu_email=$prod[usu_email]'><i class='fa fa-pencil fa-2x fa-pull-left fa-border' title='modificar'></i></a>";
					

					//enlace a la página que elimina el producto pasándole la id (clave primaria)
					
					echo "<a href='eliminar.php?usu_email=$prod[usu_email]'><i class='fa fa-trash fa-2x fa-pull-left fa-border' title='borrar'></i></a>";
					

					

					echo "</td></tr>";
				}

				?>

			</table>

			<a href="insertar.php"><i class='fa fa-plus-square fa-2x fa-pull-left fa-border'></i></a>

				<?php
			//cerramos la conexión con la base de datos
			mysqli_close($con);
		?>
			<br/><br/>
		<a href="reservas.php">Volver</a>
	</body>
</html>