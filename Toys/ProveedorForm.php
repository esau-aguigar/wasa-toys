<?php
session_start();
require_once("conexion.php");
if(!isset($_SESSION['codigoE'])){
  echo '<meta http-equiv="refresh" content="0; url=./login.php">';
}else{
if(isset($_POST['addProveedor']))
{
    $nombre = $_POST['nombreP'];
    $telefono = $_POST['telefonoP'];
    $correo = $_POST['correoP'];
    $domicilio = $_POST['domicilioP'];
    require_once ("./conexion.php");
    $addProvquery="
    INSERT INTO proveedor (nombre, telefono, correo, domicilio) 
    values ('$nombre', '$telefono', '$correo', '$domicilio');";
    #$addProvqueryResult =
    if(!mysqli_query($con,$addProvquery))
      echo "Error";
    else
      header ("Location: ./provedores.php"); //<----------- OJO
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
        <center><h1 class="w3-text-teal">Proveedores</h1></center>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h2">Registrar Proveedor</h1>
          </div>
          <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">

            <label for="nombreProveedor" class="col-sm-2 col-form-label">Proveedor</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="nombreP" id="nombreProveedor" placeholder="Nombre del Proveedor">
            </div>

            <label for='IdContacto' class="col-sm-2 col-form-label">Contacto</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="telefonoP" id="IdContacto" placeholder="Contacto">
            </div>
            
             <label for='IdCorreo' class="col-sm-2 col-form-label">Correo</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="correoP" id="IdCorreo" placeholder="Correo">
            </div>

             <label for='IdDomicilio' class="col-sm-2 col-form-label">Domicilio</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="domicilioP" id="IdDomicilio" placeholder="Domicilio">
            </div>

            <input class="btn btn-success" type="submit" name="addProveedor" value="Agregar">
            <a href="./Provedores.php" class="btn btn-primary">Regresar</a>
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