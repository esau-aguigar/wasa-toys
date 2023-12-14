<?php
session_start();
require_once("conexion.php");
if(!isset($_SESSION['codigoE'])){
  echo '<meta http-equiv="refresh" content="0; url=./login.php">';
}else{
if(isset($_POST['EditarUsuario'])){
  $codigo=$_POST['codigo'];
  $nombre=$_POST['nombre'];
  $password=$_POST['password'];
  $status=$_POST['status'];
  $rol=$_POST['rol'];
  $area=$_POST['area'];
        require_once ("./conexion.php");
        $editUsuario = "
            UPDATE usuario
            SET nombre='$nombre',
            password='$password',
            status='$status',
            rol='$rol', area='$area'
            WHERE codigo = '$codigo';  
        ";
        if(mysqli_query($con,$editUsuario)){
            header("Location: ./usuarios.php");
        }
}
else
{
        $codigo=$_POST['codigoUser'];
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
        <center><h1 class="w3-text-teal">USUARIOS</h1></center>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                      <h1 class="h2">Usuario</h1>
                  </div>

                  <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
                    <?php
                        $queryUsuario="
                        SELECT * FROM usuario
                        INNER JOIN rol on usuario.rol = rol.id
                        INNER JOIN area on usuario.area = area.id
                        INNER JOIN status on usuario.status = status.id
                        WHERE usuario.codigo = '$codigo'";
                        $queryUsuarioResult=mysqli_query($con,$queryUsuario);
                        if(mysqli_num_rows($queryUsuarioResult)){
                            while($row=mysqli_fetch_array($queryUsuarioResult)){
                    ?>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <center><h2>Codigo: <?php echo $row['codigo']; ?> </h2></center>
        </div>

        <label for="inputUsuario" class="col-sm-2 col-form-label">Nombre</label>
        <div class="col-sm-10">
          <input type="hidden" name="codigo" value="<?php echo $row['codigo']; ?>">
          <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $row[1]; ?>">
        </div>

        <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
        <div class="form-group col-md-6">
        <input type="password" step="0.01" class="form-control" name="password" id="inputPassword" value="<?php echo $row['password']; ?>">
        </div>
        
        <div class="form-group col-md-6">
            <label for="setRol">Status</label>
            <select class="form-control" id="setStatus" name="status">
                <option value="<?php echo $row[10]; ?>"><?php echo $row[11]; ?>*</option>
                <?php
                    $queryStatus="select * from status";
                    $queryStatusResult=mysqli_query($con,$queryStatus);
                    if(mysqli_num_rows($queryStatusResult)){
                        while($rowM=mysqli_fetch_array($queryStatusResult)){
                            echo '<option value="'.$rowM['id'].'">'.$rowM['nombre'].'</option>';
                        }
                    }
                ?>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="rol">Rol</label>
            <select class="form-control" id="rol" name="rol">
                <option value="<?php echo $row[6]; ?>"><?php echo $row[7]; ?>*</option>
                <?php
                     $queryRoles="select * from rol";
                                $queryRolesResult=mysqli_query($con,$queryRoles);
                                if(mysqli_num_rows($queryRolesResult)){
                                    while($rowR=mysqli_fetch_array($queryRolesResult)){
                                        echo '<option value="'.$rowR['id'].'">'.$rowR['nombre'].'</option>';
                                    }
                    }
                ?>
            </select>
        </div>

        <div class="form-group col-md-6">
                        <label for="setArea">Area</label>
                        <select class="form-control" id="setArea" name="area">
                            <option value="<?php echo $row[8]; ?>"><?php echo $row[9]; ?>*</option>
                            <?php
                                $queryArea="select * from area";
                                $queryAreaResult=mysqli_query($con,$queryArea);
                                if(mysqli_num_rows($queryAreaResult)){
                                    while($rowA=mysqli_fetch_array($queryAreaResult)){
                                        echo '<option value="'.$rowA['id'].'">'.$rowA['nombre'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <center>
                      <input class="btn btn-success" type="submit" name="EditarUsuario" value="Editar">
                      <a href="./usuarios.php" class="btn btn-primary">Regresar</a>
                    </center>
                    <?php

                }
            }
        ?>
      </form>
      <form method="POST" action="Delusuario.php">
        <input type="hidden" name="codigoDel" value="<?php echo $codigo; ?>">
        <input class="btn btn-danger" type="submit" name="Delusuario" value="Eliminar">
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