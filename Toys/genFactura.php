<?php
	$user = $_GET["user"];
	$total = $_GET["total"];
	$mpago = $_GET["mpago"];
	require_once("conexion.php");
	$sqlUser = "SELECT * FROM usuario WHERE codigo ='".$user."'";
	$getuser = mysqli_query($con, $sqlUser);
	$rowUs = mysqli_fetch_array($getuser);

	$folio = mysqli_prepare($con, "CALL genFactura(?, ?, ?)");
	mysqli_stmt_bind_param($folio, 'iii', $user, $total, $mpago);
	mysqli_stmt_execute($folio);
	mysqli_stmt_close($folio);

	$retval = mysqli_query($con, "CALL getFolio()");
	$row=mysqli_fetch_array($retval);

	?>
	<div class="container">
		<div class="row">
			<div class="col-xs-3">
				Cajero:<?php echo $rowUs['nombre']; ?> 
			</div>
			<div class="col-sm-6"></div>
			<div class="col-xs-3">
				<input type="hidden" id="totalF" value="<?php echo $row["Total"]; ?>"><h2>Total:$</h2>
			</div>
			<div class="col-sm-3" id="changeTotal"> <h2><?php echo $row["Total"]; ?></h2></div>

		</div>
		<div class="row">
			<div class="col-sm-3">
				<input type="hidden" id="folioFactura" value="<?php echo $row["folio"]; ?>">
				<h5>Folio:<?php echo $row["folio"]; ?></h5>
		</div>
	</div>