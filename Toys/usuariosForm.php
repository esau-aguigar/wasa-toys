<?php
session_start();
require_once("conexion.php");
if(!isset($_SESSION['codigoE'])){
  echo '<meta http-equiv="refresh" content="0; url=./login.php">';
}else{
if(isset($_GET['addUser']))
{
    $nombre = $_GET['nombre'];
    $password = $_GET['password'];
    $status = $_GET['status'];
    $area = $_GET['area'];
    $rol = $_GET['rol'];
    require_once ("./conexion.php");
    $addUserQuery="INSERT INTO usuario (nombre, password, status, rol, area) 
    values ('$nombre', '$password', '$status', '$rol', '$area');";
    $addUserQueryResult = mysqli_query($con,$addUserQuery);
    header ("Location: ./usuarios.php");
?>

<?php
}
else
{
    $con = mysqli_connect("localhost","root","picapiedra","kosports");
    if (mysqli_connect_errno($con))
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
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
          <?php require_once("menu.php"); ?>
          <div class="w3-main" >
            <div class="w3-row w3-padding-64">
              <center><h1 class="w3-text-teal">Agregar usuario</h1></center>
              <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <form method="get" action="<?php $_SERVER['PHP_SELF']; ?>">
                  <label for="inputUsuario" class="col-sm-2 col-form-label">Nombre</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="nombre" id="inputUsuario" placeholder="Nombre">
                  </div>

                  <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Password">
                  </div>

                  <div class="form-group col-md-6">
                      <label for="setRol">Status</label>
                      <select class="form-control" id="setStatus" name="status">
                          <option>Elige una opcion</option>
                          <?php
                              $queryStatus="select * from status";
                              $queryStatusResult=mysqli_query($con,$queryStatus);
                              if(mysqli_num_rows($queryStatusResult)){
                                  while($row=mysqli_fetch_array($queryStatusResult)){
                                      echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
                                  }
                              }
                          ?>
                      </select>
                  </div>

                  <div class="form-group col-md-6">
                      <label for="setRol">Rol</label>
                      <select class="form-control" id="setRol" name="rol">
                          <option>Elige una opcion</option>
                          <?php
                              $queryRoles="select * from rol";
                              $queryRolesResult=mysqli_query($con,$queryRoles);
                              if(mysqli_num_rows($queryRolesResult)){
                                  while($row=mysqli_fetch_array($queryRolesResult)){
                                      echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
                                  }
                              }
                          ?>
                      </select>
                  </div>

                  <div class="form-group col-md-6">
                      <label for="setArea">Area</label>
                      <select class="form-control" id="setArea" name="area">
                          <option>Elige una opcion</option>
                          <?php
                              $queryArea="select * from area";
                              $queryAreaResult=mysqli_query($con,$queryArea);
                              if(mysqli_num_rows($queryAreaResult)){
                                  while($row=mysqli_fetch_array($queryAreaResult)){
                                      echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
                                  }
                              }
                          ?>
                      </select>
                  </div>

                  <input class="btn btn-success" type="submit" name="addUser" value="Agregar">
                  <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
                      <input class="btn btn-primary" type="submit" name="addUser" value="Regresar">
                  </form>
                </form>
              </main>
            </div>
          </body>
        </html>


?>
<?php
}
}
?>