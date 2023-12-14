
<?php
$cantidad = $_GET["cantidad"];
$item = $_GET["item"];
$factura = $_GET["factura"];
$precio = $_GET["precio"];
$proveedor = $_GET["proveedor"];
require_once("conexion.php");

$ActualizaProveedor=mysqli_query($con, "UPDATE facturacompra SET proveedor = '$proveedor' WHERE folio='$factura';");

$detalle = mysqli_prepare($con, "CALL insertDetalleCompra(?, ?, ?, ?)");
mysqli_stmt_bind_param($detalle, 'iiid', $factura, $item, $cantidad, $precio);
mysqli_stmt_execute($detalle);
mysqli_stmt_close($detalle);

?>
