<?php
session_start();
require_once("conexion.php");
if(!isset($_SESSION['codigoE'])){
  echo '<meta http-equiv="refresh" content="0; url=./login.php">';
}else{
if (isset($_POST['BORRARDEF'])){
require_once ("./conexion.php");
	$Proveedor = $_POST['idP'];
	$borrarProducto = "
		DELETE FROM proveedor WHERE id = '$Proveedor';
	";
	if (mysqli_query($con,$borrarProducto)) {
		header("Location: ./provedores.php");
		# code...
	}

}
else
{
	require_once ("./conexion.php");
	$DelProveedor = $_POST['idDel'];
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
        <center><h1 class="w3-text-teal">Proveedor</h1></center>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div id="contenido">
            	<?php
            		$queryEliminarProveedor="
            			SELECT * FROM proveedor
            			WHERE id= '$DelProveedor';
            		";
            		$queryDelProveedor=mysqli_query($con,$queryEliminarProveedor);
if(mysqli_num_rows($queryDelProveedor))
{
    while($row=mysqli_fetch_array($queryDelProveedor))
    {
                ?>

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                  <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
                    <?php
                        $queryProveedor="
                        SELECT * FROM proveedor
						WHERE proveedor.id = '$DelProveedor'";
                        $queryProductoResult=mysqli_query($con,$queryProveedor);
                        if(mysqli_num_rows($queryProductoResult)){
                            while($row=mysqli_fetch_array($queryProductoResult)){
                    ?>

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                      <center><h2>ID: <?php echo $row['id']; ?> </h2></center>
                  	</div>

                    <label for="inputUsuario" class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                      <input type="hidden" name="idP" value="<?php echo $row['id']; ?>">
                      <input type="text" class="form-control" name="nombreP" id="inputUsuario" value="<?php echo $row['nombre']; ?>" disabled>
                    </div>

                    <label for="telefono" class="col-sm-2 col-form-label">Teléfono</label>
                    <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="telefonoP" id="telefono" value="<?php echo $row['telefono']; ?>" disabled>
                    </div>                    

                   <label for="correo" class="col-sm-2 col-form-label">Correo</label>
                    <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="correoP" id="correo" value="<?php echo $row['correo']; ?>" disabled>
                    </div>  

                   <label for="Domicilio" class="col-sm-2 col-form-label">Domicilio</label>
                    <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="domicilioP" id="Domicilio" value="<?php echo $row['domicilio']; ?>" disabled>
                    </div>  
                    <?php

                            }
                        }
                    ?>
                    <center>
                      <input class="btn btn-danger" type="submit" name="BORRARDEF" value="Eliminar Definitivamente">
                      <a href="./provedores.php" class="btn btn-primary">Regresar</a>
                    </center>                    
                  </form>
<?php
    }
}
?>
            </div>
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