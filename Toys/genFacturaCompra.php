<?php
	$folio = $_GET["folio"];
	$user = $_GET["user"];
	$total = $_GET["total"];
	$proveedor = $_GET["proveedor"];
	require_once("conexion.php");
	$sqlUser = "SELECT * FROM usuario WHERE codigo ='$user';";
	$getuser = mysqli_query($con, $sqlUser);
	$rowUs = mysqli_fetch_array($getuser);

	$newfolio = mysqli_prepare($con, "CALL genFacturaCompra(?, ?, ?, ?)");
	mysqli_stmt_bind_param($newfolio, 'iiid', $folio, $user,$proveedor, $total);
	mysqli_stmt_execute($newfolio);
	mysqli_stmt_close($newfolio);

	$retval = mysqli_query($con, "CALL getFolioCompra()");
	$row=mysqli_fetch_array($retval);

	?>
	<div class="container">
		<div class="row">
			<div class="col-xs-3">
				RECIBE:<?php echo $rowUs['nombre']; ?> 
			</div>
			<div class="col-sm-6"></div>
			<div class="row">
				<div class="col-xs-3">
					<input type="hidden" id="totalF" value="<?php echo $row["Total"]; ?>">
					<h2>Total:$</h2><div class="col-sm-3" id="changeTotal"> <h2><?php echo $row["Total"]; ?></h2></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3">
				<input type="hidden" id="folioFactura" value="<?php echo $row["folio"]; ?>">
				<h5>Folio:<?php echo $row["folio"]; ?></h5>
		</div>
	</div>