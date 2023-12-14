<?php
session_start();
require_once("conexion.php");
if(isset($_SESSION['codigoE'])){
	echo '<meta http-equiv="refresh" content="0; url=./inicio.php">';
}else{
	if(isset($_POST['login'])){
		$codigo = $_POST['codigoE'];
		$pass = $_POST['pass'];
		$log=mysqli_query($con,"SELECT * FROM usuario WHERE codigo='$codigo' AND password ='$pass'");
		if(mysqli_num_rows($log)>0){
			$rowLog=mysqli_fetch_array($log);
			$_SESSION['codigoE'] = $codigo;
			echo '<meta http-equiv="refresh" content="0; url=./inicio.php">';
		}
		else{
			echo '<script>alert("Datos incorrectos!");</script>';
			echo '<meta http-equiv="refresh" content="0; url=./login.php">';
		}
	}
}
?>
<!doctype html>
<html>
  <head>
  	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/cssfont-awesome.min.css">
	<link href="./bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Toys-Login</title>

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" method="post" action="">
      <img src="logo.png" alt="" width="200" height="200">
      <h1 class="h3 mb-3 font-weight-normal">Inicia Session</h1>
      
      <label for="codigoE" class="sr-only">Codigo de empleado</label>
      <input type="text" name="codigoE" id="codigoE" class="form-control" placeholder="Codigo" required autofocus>
      
      <label for="pass" class="sr-only">pass</label>
      <input type="password" name="pass" id="pass" class="form-control" placeholder="contraseña" required>
      
      <input type="submit" name="login" class="btn btn-lg btn-primary btn-block" value="Entrar">
    </form>
  </body>
</html>
