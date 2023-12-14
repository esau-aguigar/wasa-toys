
<?php
$q = intval($_GET['q']);

require_once("conexion.php");
$sql="SELECT * FROM producto WHERE barcode = '".$q."'";
$result = mysqli_query($con,$sql);

echo '
<div class="table-responsive">
<table class="table table-striped table-sm">
    <thead>
    <tr>
    <th>cantidad</th>
    <th>barcode</th>
    <th>Producto</th>
    <th>Precio Unitario</th>
    <th>Precio</th>
    <th> Opciones </th>
    </tr>
    </thead>';
while($row = mysqli_fetch_array($result)) {
    echo ''?>
    <tr>
    <td>
        <input class="form-control" type="number" min="1" value="1" step="1" name="" id="cant" onchange="updatePrice(this.value,<?php echo $row['precioCompra']; ?>)">
    </td>
    <td>
        <input type="hidden" id="barcode" value="<?php echo $row['barcode']; ?>">
        <?php echo $row['barcode']; ?>
    </td>
    <td>
        <input type="hidden" id="nombre" value="<?php echo $row['nombre']; ?>">
        <?php echo $row['nombre']; ?>     
    </td>
    <td>
        <label><?php echo $row['precioCompra']; ?></label>
    </td>
    <td>
        <input type="hidden" id="updPrice" value="<?php echo $row['precioCompra']; ?>">
        <label id="precioU"><?php echo $row['precioCompra']; ?></label>
    </td>
    <td>
        <button class="btn btn-success" id="nvoElemento" onclick="addItem()">agregar</button>
    </td>
    </tr><?php
}
echo "</table>";

echo "</table>";
mysqli_close($con);
?>