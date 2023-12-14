
<?php
$cantidad = $_GET["cantidad"];
$item = $_GET["item"];
$factura = $_GET["factura"];
$precio = $_GET["precio"];
require_once("conexion.php");

$detalle = mysqli_prepare($con, "CALL insertDetalle(?, ?, ?, ?)");
mysqli_stmt_bind_param($detalle, 'iiid', $factura, $item, $cantidad, $precio);
mysqli_stmt_execute($detalle);
mysqli_stmt_close($detalle);

?>
