<?php
session_start();
require_once("conexion.php");
if(!isset($_SESSION['codigoE'])){
  echo '<meta http-equiv="refresh" content="0; url=./login.php">';
}else{
	$sessionUser = $_SESSION['codigoE'];
?>
	<div class="w3-top">
	  <div class="w3-bar w3-theme w3-top w3-left-align w3-large">
	    <a class="w3-bar-item w3-button w3-right w3-hide-large w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
	    <a href="./inicio.php" class="w3-bar-item w3-button w3-theme-l1">Wasa-Toys</a>
<?php
		if ($sessionUser<2) {
?>
	    <a href="./Usuarios.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Usuarios</a>
	    <a href="./Provedores.php" class="w3-bar-item w3-button w3-hide-small  w3-hover-white">Provedores</a>
<?php
		}
?>
	    <a href="./Productos.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Productos</a>

	    <a href="./Compras.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Compras</a>
	    <a href="./pventa.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Ventas</a>
<?php
		if ($sessionUser<2) {
?>
	    <a href="./reportes.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Reportes</a>
<?php
		}
?>
	    <a href="./logout.php" class="w3-padding-large w3-hover-red w3-hide-small w3-right" style="text-decoration: none; color: white;">Salir</a>
	    <a href="./inicio.php" class="w3-bar-item w3-button w3-right">
	    	<?php
	    	$code = $_SESSION['codigoE'];
	    	$user=mysqli_query($con,"SELECT nombre FROM usuario WHERE codigo = '$code'");
	    	$row=mysqli_fetch_array($user);
	    	echo $row['nombre'];
	    	?>
	    </a>
      
	  </div>
	</div>
<?php } ?>
