<?php
session_start();
	if(isset($_SESSION['nombre']))$login=1;
	if(isset($_POST['login']))$login=1;
	if(isset($_POST['reservar']))$login=1;
	if(isset($_POST['retornar']))$login=1;
	if(isset($_POST['manteniment']))$login=1;
	if(isset($login)){
		if(isset($_POST['login'])){	
			if(isset($_POST['mail']))$mail = $_POST['mail'];
			if(isset($_POST['contraseña']))$contraseña = $_POST['contraseña'];
			$con = mysqli_connect('localhost', 'root', '', 'bd_reservas1');
			$sql=("SELECT * FROM `tbl_usuario` WHERE usu_email = '$mail' && usu_contra = '$contraseña' ");
			//echo $sql;
			$datos = mysqli_query($con, $sql);
			if(mysqli_num_rows($datos) > 0){
				while($send = mysqli_fetch_array($datos)){
					$send['usu_nom'] = utf8_encode($send['usu_nom']);
					//echo "<br/><br/>$send[usu_nom]";
					$_SESSION['nombre']=$send['usu_nom'];
					$_SESSION['mail']=$send['usu_email'];
					$_SESSION['rang']=$send['usu_rang'];
				}
			}else{
				$_SESSION['error'] = 'error';
				header("Location: index.php");
				die();
			}
			mysqli_close($con);
		}
		if(isset($_POST['manteniment'])){
			if(isset($_POST['manteniment']))$manteniment = $_POST['manteniment'];
			$con = mysqli_connect('localhost', 'root', '', 'bd_reservas1');
			//echo $manteniment;
			$sql1=("SELECT * FROM `tbl_recursos` WHERE rec_id = $manteniment");
			echo $sql1;
			$datos = mysqli_query($con, $sql1);
			if(mysqli_num_rows($datos) > 0){
				while($cerca = mysqli_fetch_array($datos)){
					$validar = $cerca['rec_desactivat'];
					if ($validar == 1) {
						$sql=("UPDATE tbl_recursos SET rec_desactivat = 0 WHERE rec_id = $manteniment ");
						$estat = "averiat";
						echo $estat;
					}else{
						$sql=("UPDATE tbl_recursos SET rec_desactivat = 1 WHERE rec_id = $manteniment ");
						$estat = "Ja en funcionament";
						echo $estat;
					}
				}
			}
			mysqli_query($con, $sql);	
			mysqli_close($con);
		}
		if(isset($_POST['reservar'])){
			$reservar = $_POST['reservar'];
			$con = mysqli_connect('localhost', 'root', '', 'bd_reservas1');
			//echo $reservar;
			$sql1=("SELECT * FROM `tbl_recursos` WHERE rec_id = $reservar");
			//echo $sql1;
			$datos = mysqli_query($con, $sql1);
			if(mysqli_num_rows($datos) > 0){
				while($cerca = mysqli_fetch_array($datos)){
					$validar = $cerca['rec_reservado'];
					if ($validar == 1) {
						$hoy = getdate();
						$hora=($hoy['hours'].':'.$hoy['minutes'].':'.$hoy['seconds']);
						$data=($hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday']);
						//echo "$hora<br/>$data";
						$usuari=$_SESSION['mail'];
						$sql=("UPDATE tbl_recursos SET rec_reservado = 0 WHERE rec_id = $reservar ");
						$estat = "Recurs reserva't";
						mysqli_query($con, $sql);	
						$sql2=("INSERT INTO `tbl_reservas`(`res_fecha_ini`, `res_hora_ini`, `UsuarioReservante`, `id_rec`)VALUES
						('$data','$hora','$usuari', $reservar)");
						//echo $sql2;
						mysqli_query($con, $sql2);	
					}else{
						$hoy = getdate();
						$hora=($hoy['hours'].':'.$hoy['minutes'].':'.$hoy['seconds']);
						$data=($hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday']);
						//echo "$hora<br/>$data";
						$usuari=$_SESSION['mail'];
						$sql=("UPDATE tbl_recursos SET rec_reservado = 1 WHERE rec_id = $reservar ");
						$estat = "Recurs retorna't";
						mysqli_query($con, $sql);	
						$sql2=("UPDATE `tbl_reservas` SET `res_fecha_fin` = '$data',  `res_hora_fin` = '$hora' WHERE id_rec = $reservar &&  UsuarioReservante = '$usuari' ORDER BY tbl_reservas.res_fecha_fin ASC LIMIT 1");
						//echo $sql2;
						mysqli_query($con, $sql2);	
					}
					break;
				}
			}
						
			mysqli_close($con);
		}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Reservar</title>
        <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <link rel="stylesheet" href="css/stylesBar.css">
        <link rel="stylesheet" type="text/css" href="css/reservas.css" />
	    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	    <script src="js/scriptBar.js"></script>
<link rel="shortcut icon" type="image/x-icon" href="/images/favicon" />
	</head>
    <body>
		<div class="header">
			<div id='cssmenu'>
				<ul>
					<li class='active'><a href='reservas.php'>RESERVAS</a></li>
					<li><a href='incidencia.php'>INCIDENCIAS</a></li>
					<?php
					$rang=$_SESSION['rang'];
					if($rang=='administrador'){
						echo "<li><a href='administrar.php'>ADMINISTRAR</a></li>";
					}
					?>
					<?php
					$rang=$_SESSION['rang'];
					if($rang=='administrador'){
						echo "<li><a href='index1.php'>ADMINISTRAR USERS</a></li>";
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
				<h1>AULES</h1>
				<?php
					$con = mysqli_connect('localhost', 'root', '', 'bd_reservas1');
					$sql = ("SELECT * FROM `tbl_recursos` ");
					$datos = mysqli_query($con, $sql);
                    if(mysqli_num_rows($datos) > 0){
                        while($cerca = mysqli_fetch_array($datos)){
							$manteniment=1;
							$id = $cerca['rec_id'];
                            $cerca['rec_contingut']= utf8_encode($cerca['rec_contingut']);
                            $img = "images/$cerca[rec_contingut].jpg";
							if($cerca['rec_desactivat']=="1"){
								if($cerca['rec_reservado']=="1"){
									$img = "images/$cerca[rec_contingut].jpg";
								}else{
									$img = "images/$cerca[rec_contingut]ocupada.jpg";
								}
							}else{
								$img = "images/$cerca[rec_contingut]mantenimiento.jpg";
								$manteniment=0;
							}
                            echo "<div class='objeto'><div class='text1'>$cerca[rec_contingut]</div><div class='objeto2'><img src='$img'><br/></div>";
							if($manteniment==1){
								echo "<form action='#' method='POST'>";
								echo "<input type='hidden' name='reservar' value='$cerca[rec_id]'/>";
								if($cerca['rec_reservado']==1){
									
									echo "<input type='submit' value='RESERVAR'/>";
									echo "<br/>";
									echo "HORA Entrada";
									echo "<br/>";
									echo "	<select name=''> 
											<option value='08:00:00'>08:00</option>
											  <option value='09:00:00'>09:00</option>
											  <option value='10:00:00'>10:00</option>
											  <option value='11:00:00'>11:00</option>
											  <option value='12:00:00'>12:00</option>
											  <option value='13:00:00'>13:00</option>
															
											
										</select>";
										echo "<br/>";
									echo "HORA Retorn";
									echo "	<select name=''> 
											<option value='08:59:00'>09:00</option>
											  <option value='09:59:00'>10:00</option>
											  <option value='10:59:00'>11:00</option>
											  <option value='11:59:00'>12:00</option>
											  <option value='12:59:00'>13:00</option>
											  <option value='13:59:00'>14:00</option>
																								
											
										</select>";
								}else{
									$con1 = mysqli_connect('localhost', 'root', '', 'bd_reservas1');
									$sql1 = ("SELECT * FROM `tbl_reservas` WHERE tbl_reservas.rec_id=$id ");
									$datos1 = mysqli_query($con1, $sql1);
									$usuari=$_SESSION['mail'];
									//echo $sql1;
									if(mysqli_num_rows($datos1) > 0){
										while($cercaret = mysqli_fetch_array($datos1)){
											if($usuari==$cercaret['UsuarioReservante']){
												echo "<input type='submit' value='RETORNAR'/>";
												break;
											}
										}
									}
									mysqli_close($con1);
								}
								echo "</form>";
							}
							echo "</div>";
                        }
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