<?php
session_start();
	if(isset($_SESSION['nombre']))$login=1;
	if(isset($_POST['reservar']))$login=1;
	if(isset($_POST['retornar']))$login=1;
	if(isset($_POST['manteniment']))$login=1;
	if(isset($login)){
		if(isset($_POST['manteniment'])){
			if(isset($_POST['manteniment']))$manteniment = $_POST['manteniment'];
			$con = mysqli_connect('localhost', 'root', '', 'bd_reservas1');
			//echo $manteniment;
			$sql1=("SELECT * FROM `tbl_recursos` WHERE rec_id = $manteniment");
			//echo $sql1;
			$datos = mysqli_query($con, $sql1);
			if(mysqli_num_rows($datos) > 0){
				while($cerca = mysqli_fetch_array($datos)){
					$validar = $cerca['rec_desactivat'];
					if ($validar == 1) {
						$sql=("UPDATE tbl_recursos SET rec_desactivat = 0 WHERE rec_id = $manteniment ");
						$estat = "averiat";
					}else{
						$sql=("UPDATE tbl_recursos SET rec_desactivat = 1 WHERE rec_id = $manteniment ");
						$estat = "Ja en funcionament";
					}
				}
			}
			mysqli_query($con, $sql);	
			mysqli_close($con);
		}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Administracio</title>
        <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <link rel="stylesheet" href="css/stylesBar.css">
        <link rel="stylesheet" type="text/css" href="css/reservas.css" />
	    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	    <script src="js/scriptBar.js"></script>
		<link rel="icon" type="image/x-icon" href="images/favicon" />
	</head>
    <body>
		<div class="header">
			<div id='cssmenu'>
				<ul>
					<li class='active'><a href='reservas.php'>RESERVAS</a></li>
					<li><a href='incidencia.php'>INCIDENCIAS</a></li>
					<?php
					$rang=$_SESSION['rang'];
					if($rang==0){
						echo "<li><a href='administrar.php'>ADMINISTRAR</a></li>";
					}
					?>
					<li class='wel'><?php echo "<br/>&nbsp;&nbsp; Bienvenido $_SESSION[nombre] ";
					?></li>
					<li class='cerrar'><a href="index.php">Cerrar Sesión</a></li>
				</ul>
			</div>
		</div>
		<?php
			if(isset($estat))echo $estat;
		?>
        <div class="fondo">
		
			<div class="principal">
				<h1>AULAS</h1>
				<?php
					$con = mysqli_connect('localhost', 'root', '', 'bd_reservas1');
					$sql = ("SELECT * FROM `tbl_recursos` WHERE tbl_recursos.rec_tipo_rec= 1");
					$datos = mysqli_query($con, $sql);
                    if(mysqli_num_rows($datos) > 0){
						echo "<div class='objeto'>";
								echo "<table border=1 >";
                        while($cerca = mysqli_fetch_array($datos)){
							$id = $cerca['rec_id'];
							$reservado =  $cerca['rec_reservado'];
                            $cerca['rec_contingut']= utf8_encode($cerca['rec_contingut']);
										echo "<tr><td>";
										echo "<b>" . $cerca['rec_contingut'] . "</b>";
										echo "</td>";
										echo "<td>";
										$con1 = mysqli_connect('localhost', 'root', '', 'bd_reservas1');
										$sql1 = ("SELECT * FROM `tbl_reservas` WHERE tbl_reservas.res_id=$id  ORDER BY tbl_reservas.res_fecha_fin ASC, tbl_reservas.res_hora_fin ASC LIMIT 1");
										$datos1 = mysqli_query($con1, $sql1);
										$usuari=$_SESSION['mail'];
										//echo $sql1;
										if(mysqli_num_rows($datos1) > 0){
											while($cercaret = mysqli_fetch_array($datos1)){
												$usuarioep=$cercaret['usu_email'];
												
												if($reservado==1){
													echo "Disponible";
													echo "</td>";
													echo "<td>";
													break;
												}else{

													echo "En uso";
													echo "</td>";
													echo "<td>".$usuarioep;
													break;
												}
												
												
											}
										}else {
											echo "Disponible";
													echo "</td>";
													echo "<td>";
										}
											echo "<td>";
											if($cercaret['res_incidencia']==0){
												echo "Hi ha una incidencia amb aquest recurs";
										}else{
											echo "No hi ha cap incidencia ";
										}
										
										echo "</td>";
										mysqli_close($con1);
										echo "</td>";
										echo "<td>";
										echo "<form action='#' method='POST'>";
										if($cerca['rec_desactivat']=="1"){
											echo "  <input type='hidden' name='manteniment' value='$cerca[rec_id]'/>";
											echo "  <input type='submit' value='MANTENIMENT '/><br/>";
										}else{
											echo "  <input type='hidden' name='manteniment' value='$cerca[rec_id]'/>";
											echo "  <input type='submit' value='REPARAT'/><br/>";		
										}
										
									echo "</form>";
								echo "</td></tr>";
                        }
						echo "</table>";
							echo "</div>";
                    }
					mysqli_close($con);
				?>
			</div>
			<div class="aside">
				<h1>MATERIALES</h1>
				<?php
					$con = mysqli_connect('localhost', 'root', '', 'bd_reservas1');
					$sql = ("SELECT * FROM `tbl_recursos` WHERE tbl_recursos.rec_tipo_rec= 0");
					$datos = mysqli_query($con, $sql);
                    if(mysqli_num_rows($datos) > 0){
						echo "<div class='objeto'>";
								echo "<table border=1 >";
                        while($cerca = mysqli_fetch_array($datos)){
							$id = $cerca['rec_id'];
							$reservado=$cerca['rec_reservado'];
                            $cerca['rec_contingut']= utf8_encode($cerca['rec_contingut']);
										echo "<tr><td style=padding:20px; >";
										echo "<b>" . $cerca['rec_contingut'] . "</b>";
										echo "</td>";
										echo "<td>";
										$con1 = mysqli_connect('localhost', 'root', '', 'bd_reservas1');
										$sql1 = ("SELECT * FROM `tbl_reservas` WHERE tbl_reservas.idRecurso=$id  ORDER BY tbl_reservas.res_fecha_fin ASC, tbl_reservas.res_hora_fin ASC LIMIT 1 ");
										$datos1 = mysqli_query($con1, $sql1);
										$usuari=$_SESSION['mail'];
										//echo $sql1;
										if(mysqli_num_rows($datos1) > 0){
											while($cercaret = mysqli_fetch_array($datos1)){
												$usuarioep=$cercaret['UsuarioReservante'];
												
												if($reservado==1){
													echo "Disponible";
													echo "</td>";
													echo "<td>";
												}else{
													echo "En uso";
													echo "</td>";
													echo "<td>".$usuarioep;
												}
													break;
											}
										}else {
											echo "Disponible";
													echo "</td>";
													echo "<td>";
										}
echo "<td>";
										if($cercaret['res_incidencia']==1){
											echo "No hi ha cap incidencia ";
										}else{
											echo "Hi ha una incidencia amb aquest recurs";
										}
										echo "</td>";
										mysqli_close($con1);
										echo "</td>";
										echo "<td>";
										echo "<form action='#' method='POST'>";
										if($cerca['rec_desactivat']=="1"){
											echo "  <input type='hidden' name='manteniment' value='$cerca[rec_id]'/>";
											echo "  <input type='submit' value='MANTENIMENT'/><br/>";
										}else{
											echo "  <input type='hidden' name='manteniment' value='$cerca[rec_id]'/>";
											echo "  <input type='submit' value='REPARAT'/><br/>";		
										}
										
									echo "</form>";
								echo "</td></tr>";
                        }
						echo "</table>";
							echo "</div>";
                    }
					mysqli_close($con);
				?>
			</div>
		</div>
    </body>
</html>
<?php
}else{
	$_SESSION['validarse'] = 'error';
	header("Location: index.php");
	die();
}

?>