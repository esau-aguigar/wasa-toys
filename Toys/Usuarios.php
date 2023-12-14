<?php
session_start();
require_once("conexion.php");
if(!isset($_SESSION['codigoE'])){
  echo '<meta http-equiv="refresh" content="0; url=./login.php">';
}else{
require_once ("./conexion.php");;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Wasa Toys</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="icon" href="../../../../favicon.ico">
  <link href="./bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="dashboard.css" rel="stylesheet">

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
</head>
<body>

<!-- Navbar -->
<?php require_once("menu.php"); ?>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main" >

  <div class="w3-row w3-padding-64">
      <center>
        <h1 class="w3-text-teal">Usuarios</h1>

        <main role="main"  style="padding-right: 20px; padding-left: 20px" >

            <div class="table-responsive">
              <table class="table table-striped table-sm">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>status</th>
                    <th>Rol</th>
                    <th>Area</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                        $queryUsuarios="
                        SELECT * FROM usuario
                        INNER JOIN rol on usuario.rol = rol.id
                        INNER JOIN area on usuario.area = area.id
                        INNER JOIN status on usuario.status = status.id
                        ORDER BY usuario.codigo ASC";
                        $queryUsuarios=mysqli_query($con,$queryUsuarios);
                        if(mysqli_num_rows($queryUsuarios)){
                            while($row=mysqli_fetch_array($queryUsuarios)){
                                ?>
                                  <tr>
                                    <td><?php echo $row['codigo']; ?></td>
                                    <td><?php echo $row[1]; ?></td>
                                    <td><?php echo $row[11]; ?></td>
                                    <td><?php echo $row[7]; ?></td>
                                    <td><?php echo $row[9]; ?></td>
                                    <td>
                                        <form method="post" action="infoUsuario.php">
                                            <input type="hidden" name="codigoUser" value="<?php echo $row['codigo']; ?>">
                                            <input class="btn btn-warning" type="submit"value="Ver">
                                        </form>
                                    </td>
                                  </tr>
                                <?php
                            }
                        }
                    ?>
                </tbody>
              </table>
            </div>
            <form method="post" action="usuariosForm.php">
                <input class="btn btn-success" type="submit" name="addUserForm" value="Agregar">
                <a href="./inicio.php" class="btn btn-primary">Regresar</a>
            </form>
        </main>
      </center>
  </div>
<!-- END MAIN -->
</div>
</body>
</html>
<?php } ?>