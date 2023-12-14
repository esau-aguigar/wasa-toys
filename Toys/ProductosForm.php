<?php
session_start();
require_once("conexion.php");
if(!isset($_SESSION['codigoE'])){
  echo '<meta http-equiv="refresh" content="0; url=./login.php">';
}else{
if(isset($_POST['addProducto']))
{
    $nombre = $_POST['nombreP'];
    $marca = $_POST['marcaP'];
    $tamanio = $_POST['tamanioP'];
    $precioV = $_POST['precioV'];
    $precioC = $_POST['precioC'];
    require_once ("./conexion.php");
    $addProdquery="INSERT INTO producto (nombre, marca, tamanio, precioVenta, precioCompra, existencia) 
    values ('$nombre', '$marca', '$tamanio', '$precioV', '$precioC', 0);";
    #$addProdqueryResult =
    if(!mysqli_query($con,$addProdquery))
      echo "Error";
    else
      header ("Location: ./productos.php");
?>

<?php
}
else
{
  require_once ("./conexion.php");
?>
<!DOCTYPE html>
  <html>
    <title>Wasa Toys</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="./bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif;}
    .w3-sidebar {
      z-index: 3;
      width: 250px;
      top: 43px;
      bottom: 0;
      height: inherit;
    }
    </style>
    <body>

    <!-- Navbar -->
    <?php require_once("menu.php"); ?>

    <!-- Overlay effect when opening sidebar on small screens -->
    <div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

    <div class="w3-main" >

      <div class="w3-row w3-padding-64">
        <center><h1 class="w3-text-teal">Productos</h1></center>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h2">Agregar Producto</h1>
          </div>
          <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">

            <label for="nombreProducto" class="col-sm-2 col-form-label">Producto</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="nombreP" id="nombreProducto" placeholder="Producto" required>
            </div>

            <label for="IDprecio" class="col-sm-2 col-form-label">Precio (venta)</label>
            <div class="col-sm-10">
              <input type="number" step="0.01" class="form-control" name="precioV" placeholder="Precio" required>
            </div>

            <label for="IDprecio" class="col-sm-2 col-form-label">Precio (compra)</label>
            <div class="col-sm-10">
              <input type="number" step="0.01" class="form-control" name="precioC" placeholder="Precio" required>
            </div>

            <div class="form-group col-md-6">
                <label for="setMarca">Marca</label>
                <select class="form-control" id="setMarca" name="marcaP">
                    <option>Elige una opcion</option>
                    <?php
                        $queryMarca="select * from marca";
                        $queryMarcaResult=mysqli_query($con,$queryMarca);
                        if(mysqli_num_rows($queryMarcaResult)){
                            while($rowM=mysqli_fetch_array($queryMarcaResult)){
                                echo '<option value="'.$rowM['id'].'">'.$rowM['nombre'].'</option>';
                            }
                        }
                    ?>
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="setTamanio">Tamaño</label>
                <select class="form-control" id="setTamanio" name="tamanioP">
                    <option>Elige una opcion</option>
                    <?php
                        $queryTamanio="select * from tamanio";
                        $queryTamanioResult=mysqli_query($con,$queryTamanio);
                        if(mysqli_num_rows($queryTamanioResult)){
                            while($rowT=mysqli_fetch_array($queryTamanioResult)){
                                echo '<option value="'.$rowT['id'].'">'.$rowT['nombre'].'</option>';
                            }
                        }
                    ?>
                </select>
            </div>

            <input class="btn btn-success" type="submit" name="addProducto" value="Agregar">
            <a href="./productos.php" class="btn btn-primary">Regresar</a>
          </form>
        </main>
      </div>
    <!-- END MAIN -->
    </div>

    </body>
  </html>
?>
<?php
}
}
?>