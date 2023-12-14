<?php
session_start();
require_once("conexion.php");
if(!isset($_SESSION['codigoE'])){
  echo '<meta http-equiv="refresh" content="0; url=./login.php">';
}else{
  $sessionCode = $_SESSION['codigoE'];
?>
<!DOCTYPE html>
<html>
<title>Wasa Toys</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

  <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="./js/scripts.js"></script>

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
<?php require_once("menu.php"); 
require_once ("./conexion.php");?>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<div class="w3-main" >
  <div class="w3-row w3-padding-64">
    <div class="row">
      <div class="col-sm-9"></div>
      <!-- Trigger the modal with a button -->
      <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" onclick="nvaFactura()">Nueva venta</button>
      <input type="hidden" id="usuario" value="<?php echo $_SESSION['codigoE']; ?>">
    </div>
      <center>
        <h2><label class="w3-text-teal"">Ventas</label></h2><br>
          <main role="main"  style="padding-right: 20px; padding-left: 20px" >

              <div class="table-responsive">
                <table class="table table-striped table-sm">
                  <thead>
                    <tr>
                      <th>Folio</th>
                      <th>Usuario</th>
                      <th>Total</th>
                      <th>Fecha & Hora</th>
                      <th>Pago</th>
                      <th>Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                      if ($sessionCode==1) {
                          $queryProductos="
                          SELECT * FROM facturaventa F
                          JOIN usuario U on F.Usuario = U.codigo
                          JOIN mpago P on F.pago = P.id
                          ORDER BY F.folio DESC;";
                          $queryProductos=mysqli_query($con,$queryProductos);
                      }else{
                        $queryProductos="
                        SELECT * FROM facturaventa F
                        JOIN usuario U on F.Usuario = U.codigo
                        JOIN mpago P on F.pago = P.id
                        WHERE U.codigo = '$sessionCode'
                        ORDER BY F.folio DESC;";
                        $queryProductos=mysqli_query($con,$queryProductos);
                      }
                          if(mysqli_num_rows($queryProductos)){
                              while($row=mysqli_fetch_array($queryProductos)){
                                  ?>
                                    <tr>
                                      <td><?php echo $row['folio']; ?></td>
                                      <td><?php echo $row[7]; ?></td>
                                      <td><?php echo $row['Total']; ?></td>
                                      <td><?php echo $row['fechaHora']; ?></td>
                                      <td><?php echo $row['nombre']; ?></td>
                                      <td>
                                          <form method="post" action="Facturainfo.php">
                                              <input type="hidden" name="facturainfo" id="facturainfo" value="<?php echo $row['folio']; ?>">
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
              <a href="./inicio.php" class="btn btn-primary">Regresar</a>
          </main>
      </center>
  </div>
<!-- END MAIN -->
</div>

<!-- Modal -->
<div id="myModal" class="modal fade">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Nueva Venta</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <div id="folio"></div>
        <div class="col-sm-3 ">
          <label for="metPago">Pago</label>
          <select class="form-control" id="mpago">
              <option>Elige una opcion</option>
              <?php
                  require_once("conexion.php");
                  $queryMetPago="select * from mpago";
                  $queryMPResult=mysqli_query($con,$queryMetPago);
                  if(mysqli_num_rows($queryMPResult)){
                      while($rowMP=mysqli_fetch_array($queryMPResult)){
                          echo '
                          <option value="'.$rowMP['id'].'">'.$rowMP['nombre'].'</option>';
                      }
                  }
              ?>
          </select>
        </div>


        <label for="setRol">Producto</label>
        <select class="form-control" onchange="showUser(this.value)">
            <option>Elige una opcion</option>
            <?php
                require_once("conexion.php");
                $queryprod="select * from producto";
                $queryprodResult=mysqli_query($con,$queryprod);
                if(mysqli_num_rows($queryprodResult)){
                    while($row=mysqli_fetch_array($queryprodResult)){
                        echo '
                        <option value="'.$row['barcode'].'">
                        '.$row['barcode']."
                        Producto: ".$row['nombre'].
                        '</option>';
                    }
                }
            ?>
        </select>

        <div id="txtHint"></div>

        <div class="table-responsive">

          <table class="table table-striped table-sm" id="items">
            <tr>
              <th>cantidad</th>
              <th>barcode</th>
              <th>Producto</th>
              <th>Precio  Unitario</th>
              <th>Total</th>
              <th>Opcion</th>
            </tr>
          </table>
        </div>
      </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="window.location.replace('pventa.php');">Finalizar venta</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar venta</button>
        </div>

    </div>
  </div>
</div>
<!-- END MAIN -->

<script>
  function showUser(str) {
      if (str == "") {
          document.getElementById("txtHint").innerHTML = "";
          return;
      } else {
          if (window.XMLHttpRequest) {
              // code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp = new XMLHttpRequest();
          } else {
              // code for IE6, IE5
              xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  document.getElementById("txtHint").innerHTML = this.response;
              }
          };
          xmlhttp.open("GET","getProductos.php?q="+str,true);
          xmlhttp.send();
      }
  }

  function updatePrice(cantidad,price) {
    document.getElementById("precioU").innerHTML = price*cantidad;
  }

  function nvaFactura(){
    var usercaja = document.getElementById("usuario").value;
    var newFactura = new XMLHttpRequest();
    newFactura.onreadystatechange = function(){
      if (newFactura.readyState == 4 && newFactura.status == 200) {
        document.getElementById("folio").innerHTML = newFactura.response;
      }
    };
    newFactura.open("GET","genFactura.php?user="+usercaja+"&total=0&mpago=1",true);
    newFactura.send();
  }

  function addItem(){


    cantidad= document.getElementById("cant").value;
    price= document.getElementById("updPrice").value;
    var tot = document.getElementById("totalF");
    var tot2=parseInt(tot.value)+(price*cantidad)
    document.getElementById("totalF").value = tot2;

    var cant = document.getElementById("cant").value;
    var item = document.getElementById("barcode").value;
    var nombre = document.getElementById("nombre").value;
    var folio = document.getElementById("folioFactura").value;
    var precio = price*cantidad;

    var tabla = document.getElementById("items");
    var row = tabla.insertRow(-1);
    var cnt = row.insertCell(0);
    var itm = row.insertCell(1);
    var nom = row.insertCell(2);
    var prcU = row.insertCell(3);
    var prc = row.insertCell(4);
    var opc = row.insertCell(5);
    cnt.innerHTML = cant;
    itm.innerHTML = item;
    nom.innerHTML = nombre;
    prcU.innerHTML = price;
    prc.innerHTML = precio;
    opc.innerHTML = '<button class="btn btn-danger">Quitar</button>';

    var tot3 = document.getElementById("totalF").value;
    document.getElementById("changeTotal").innerHTML = "<h2>"+tot3+"</h2>";

    var newItem = new XMLHttpRequest();
    newItem.onreadystatechange = function() {
              if (newItem.readyState == 4 && newItem.status == 200) {
                  console.log("Si jalo");
              }
          };
    newItem.open("GET","itemadd.php?item="+item+"&factura="+folio+"&precio="+precio+"&cantidad="+cant,true);
    newItem.send();
  }
</script>


</body>
</html>
<?php } ?>