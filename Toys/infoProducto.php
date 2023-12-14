<?php
session_start();
require_once("conexion.php");
if(!isset($_SESSION['codigoE'])){
  echo '<meta http-equiv="refresh" content="0; url=./login.php">';
}else{
if(isset($_POST['EditarProducto'])){
  $barcode=$_POST['barcodeP'];
  $nombre=$_POST['nombreP'];
  $marca=$_POST['marcaP'];
  $tamanio=$_POST['tamanioP'];
  $precio=$_POST['precioP'];
  require_once ("./conexion.php");
	$editProducto = "
	    UPDATE producto
	    SET nombre='$nombre',
	    marca='$marca',
	    tamanio='$tamanio', precio='$precio'
	    WHERE barcode = '$barcode';  
	";
	if(mysqli_query($con,$editProducto)){
	    header("Location: ./productos.php");
	}
}
else
{
  $barcode=$_POST['barcodep'];
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
		      <h1 class="h2">Productos</h1>
		  </div>

		  <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
		    <?php
		        $queryProducto="
		        SELECT * FROM producto
				JOIN marca on producto.marca = marca.id
				JOIN tamanio on producto.tamanio = tamanio.id
				WHERE producto.barcode = '$barcode'";
		        $queryProductoResult=mysqli_query($con,$queryProducto);
		        if(mysqli_num_rows($queryProductoResult)){
		            while($row=mysqli_fetch_array($queryProductoResult)){
		    ?>

		    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		      <center><h2>Barcode: <?php echo $row['barcode']; ?> </h2></center>
		  	</div>

		    <label for="inputUsuario" class="col-sm-2 col-form-label">Nombre</label>
		    <div class="col-sm-10">
		      <input type="hidden" name="barcodeP" value="<?php echo $row['barcode']; ?>">
		      <input type="text" class="form-control" name="nombreP" id="inputUsuario" value="<?php echo $row[1]; ?>">
		    </div>

		    <label for="precio" class="col-sm-2 col-form-label">Precio</label>
		    <div class="form-group col-md-6">
		    <input type="number" step="0.01" class="form-control" name="precioP" id="precio" value="<?php echo $row['precio']; ?>">
		    </div>
		    
		    <div class="form-group col-md-6">
		        <label for="marca">Marca</label>
		        <select class="form-control" id="marca" name="marcaP">
		            <option value="<?php echo $row[6]; ?>"><?php echo $row[7]; ?>*</option>
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
		        <label for="tamanio">Tamaño</label>
		        <select class="form-control" id="tamanio" name="tamanioP">
		            <option value="<?php echo $row[8]; ?>"><?php echo $row[9]; ?>*</option>
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

		    <center>
		      <input class="btn btn-success" type="submit" name="EditarProducto" value="Editar">
		      <a href="./productos.php" class="btn btn-primary">Regresar</a>
		    </center>
		    <?php

		            }
		        }
		    ?>
		  </form>
		  <form method="POST" action="DelProducto.php">
		    <input type="hidden" name="barcodeDel" value="<?php echo $barcode; ?>">
		    <input class="btn btn-danger" type="submit" name="DelProducto" value="Eliminar">
		  </form>
		</main>
      </div>
    <!-- END MAIN -->
    </div>
    </body>
</html>
<?php
}
}
?>