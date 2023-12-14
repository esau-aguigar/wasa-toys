<?php
session_start();
require_once("conexion.php");
if(!isset($_SESSION['codigoE'])){
  echo '<meta http-equiv="refresh" content="0; url=./login.php">';
}else{
  if(isset($_POST["facturainfo"])){
    $folio = $_POST["facturainfo"];
    require_once("conexion.php");
    ?>
    <!DOCTYPE html>
    <html>

      <head>
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
      </head>

      <body>

        <!-- Navbar -->

        <?php require_once("menu.php"); ?>

        <!-- Overlay effect when opening sidebar on small screens -->
        <div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

        <!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
        <div class="w3-main" >
          <div class="w3-row w3-padding-64">
            <div class="row">
              <div class="col-sm-3"></div>
              <div class="col-sm-3">
                <h1 class="w3-text-teal">FACTURA:<?php echo $folio; ?></h1>
              </div>
              <div class="col-sm-3"></div>
              <div class="col-sm-3">
                <button class="btn btn-primary" onclick="window.history.go(-1)">Regresar</button>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-2"></div>
              <div class="col-sm-3">
                <?php
                $queryusuario="
                          SELECT * FROM facturaventa FV 
                          JOIN usuario U ON FV.usuario = U.codigo
                          WHERE FV.folio = '$folio';";
                $queryusuario=mysqli_query($con,$queryusuario);
                $rowUsr=mysqli_fetch_array($queryusuario);
                ?>
                <label style="size: 10px; color: green;" >Usuario:<?php echo $rowUsr[6]; ?></label>
              </div>
            </div>
              <center>
                <div>
                  <h2>Detalle</h2>
                </div>
                <div class="col-sm-9">
                  <div class="table-responsive">
                    <table class="table table-striped table-sm">
                      <thead>
                        <tr>
                          <th>Barcode</th>
                          <th>Producto</th>
                          <th>Cantidad</th>
                          <th>$ (Unidad)</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $queryDetalle="
                          SELECT * FROM detalleventa DV
                          JOIN facturaventa FV ON DV.factura = FV.folio
                          JOIN producto P ON DV.producto = P.barcode
                          JOIN usuario U ON FV.usuario = U.codigo
                          WHERE DV.factura = '$folio';";
                          $queryDetalle=mysqli_query($con,$queryDetalle);
                          if(mysqli_num_rows($queryDetalle)){
                            while ($rowDetalles=mysqli_fetch_array($queryDetalle)) {
                              ?>
                              <tr>
                                <td><?php echo $rowDetalles['barcode']; ?></td>
                                <td><?php echo $rowDetalles[11]; ?></td>
                                <td><?php echo $rowDetalles['cantidad']; ?></td>
                                <td><?php echo $rowDetalles[14]; ?></td>
                                <td><?php echo $rowDetalles[4]; ?></td>
                              </tr>
                              <?php
                            }
                          }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </center>
              <center>
                <form method="get" action="makepdf.php" target="_blank">
                  <input type="hidden" name="folio" id="folio" value="<?php echo $folio; ?>">
                  <input type="submit"  class="btn btn-success" value="Imprimir">
                </form>
              </center>
            </div>
          </div>
        </div>
        <!-- END MAIN -->
      </body>
    </html>
    <?php
  }
}
?>