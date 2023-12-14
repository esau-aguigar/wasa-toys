<?php
session_start();
require_once("conexion.php");
if(!isset($_SESSION['codigoE'])){
  echo '<meta http-equiv="refresh" content="0; url=./login.php">';
}else{
  $sessionCode = $_SESSION['codigoE'];
  date_default_timezone_set('america/mexico_city');
  $mydate=getdate(date("U"));
  $NOWfecha= "$mydate[year]-$mydate[mon]-$mydate[mday]";
  $NOWfechaP= "$mydate[year]-$mydate[mon]-$mydate[mday]%";
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
<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main" >

  <div class="w3-row w3-padding-64">
      <center>
        <h1 class="w3-text-teal">Reportes</h1>
        <div id="accordion">
<!--____________________________________________________________________________________-->
          <div class="card" data-toggle="collapse" href="#collapseOne">

            <div class="card-header">
              <label class="w3-text-blue">Ventas del dia</label>
            </div>

            <div id="collapseOne" class="collapse hide" data-parent="#accordion">
              <div class="card-body">
                <div class="card">
                  <h2><?php echo "$mydate[weekday], $mydate[month], $mydate[mday], $mydate[year]"; ?><br>
                    Total: $
                    <?php
                        $queryVentas="
                          SELECT SUM(Total) FROM facturaventa
                          WHERE fechaHora like '$NOWfechaP';
                          ";
                        $queryVentasRes=mysqli_query($con,$queryVentas);
                        $totalVentas=mysqli_fetch_array($queryVentasRes);
                        echo $totalVentas[0];
                    ?>
                  </h2>
                    <form method="get" action="VentasDia.php" target="_blank">
                      <input type="submit"  class="btn btn-outline-success" value="Imprimir">
                    </form>
                </div>
              <div class="table-responsive">
                  <table class="table table-striped table-sm">
                    <thead>
                      <tr>
                        <th>Folio</th>
                        <th>Usuario</th>
                        <th>Pago</th>
                        <th>Fecha & Hora</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                            $queryProductos="
                            SELECT * FROM facturaventa F
                            JOIN usuario U on F.Usuario = U.codigo
                            JOIN mpago P on F.pago = P.id
                            WHERE fechaHora like '$NOWfechaP'
                            ORDER BY F.folio ASC;";
                            $queryProductos1=mysqli_query($con,$queryProductos);
                            if(mysqli_num_rows($queryProductos1)){
                                while($row=mysqli_fetch_array($queryProductos1)){
                                    ?>
                                      <tr>
                                        <td><?php echo $row['folio']; ?></td>
                                        <td><?php echo $row[7]; ?></td>
                                        <td><?php echo $row['nombre']; ?></td>
                                        <td><?php echo $row['fechaHora']; ?></td>
                                        <td><?php echo $row['Total']; ?></td>
                                      </tr>
                                    <?php
                                }
                            }
                        ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
<!--____________________________________________________________________________________-->
          <div class="card" data-toggle="collapse" href="#collapseTwo">

            <div class="card-header">
              <label class="w3-text-blue">Compras del dia</label>
            </div>

            <div id="collapseTwo" class="collapse hide" data-parent="#accordion">
              <div class="card-body">
                <div class="card">
                  <h2><?php echo "$mydate[weekday], $mydate[month], $mydate[mday], $mydate[year]"; ?><br>
                    Total: $
                    <?php
                        $queryCompras="
                          SELECT SUM(Total) FROM facturacompra
                          WHERE fechaHora like '$NOWfechaP';
                          ";
                        $queryComprasRes=mysqli_query($con,$queryCompras);
                        $totalCompras=mysqli_fetch_array($queryComprasRes);
                        echo $totalCompras[0];
                    ?>
                  </h2>
                    <form method="get" action="ComprasDia.php" target="_blank">
                      <input type="submit"  class="btn btn-outline-success" value="Imprimir">
                    </form>
                </div>
              <div class="table-responsive">
                  <table class="table table-striped table-sm">
                    <thead>
                      <tr>
                        <th>Folio</th>
                        <th>Usuario</th>
                        <th>Proveedor</th>
                        <th>Fecha & Hora</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                            $queryProductos1="
                            SELECT * FROM facturacompra F
                            JOIN usuario U on F.Usuario = U.codigo
                            JOIN proveedor P on F.proveedor = P.id
                            WHERE fechaHora like '$NOWfechaP'
                            ORDER BY F.folio ASC;";
                            $queryProductosRes=mysqli_query($con,$queryProductos1);
                            if(mysqli_num_rows($queryProductosRes)){
                                while($rowC=mysqli_fetch_array($queryProductosRes)){
                                    ?>
                                      <tr>
                                        <td><?php echo $rowC['folio']; ?></td>
                                        <td><?php echo $rowC[7]; ?></td>
                                        <td><?php echo $rowC[13]; ?></td>
                                        <td><?php echo $rowC['fechaHora']; ?></td>
                                        <td><?php echo $rowC['Total']; ?></td>
                                      </tr>
                                    <?php
                                }
                            }
                        ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
<!--____________________________________________________________________________________-->
          <div class="card" data-toggle="collapse" href="#collapsethree">

            <div class="card-header">
              <label class="w3-text-blue">Historico Ventas</label>
            </div>

            <div id="collapsethree" class="collapse hide" data-parent="#accordion">
              <div class="card-body">
                <div class="card">
                  <h2><?php echo "$mydate[weekday], $mydate[month], $mydate[mday], $mydate[year]"; ?><br>
                    Total: $
                    <?php
                        $queryCompras="SELECT SUM(Total) FROM facturaventa;";
                        $queryComprasRes=mysqli_query($con,$queryCompras);
                        $totalCompras=mysqli_fetch_array($queryComprasRes);
                        echo $totalCompras[0];
                    ?>
                  </h2>
                    <form method="get" action="hventasReporte.php" target="_blank">
                      <input type="submit"  class="btn btn-outline-success" value="Imprimir">
                    </form>
                </div>
              <div class="table-responsive">
                  <table class="table table-striped table-sm">
                    <thead>
                      <tr>
                        <th>Folio</th>
                        <th>Usuario</th>
                        <th>Pago</th>
                        <th>Fecha & Hora</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                            $queryProductos1="
                            SELECT * FROM facturaventa F
                            JOIN usuario U on F.Usuario = U.codigo
                            JOIN mpago P on F.pago = P.id
                            ORDER BY F.folio ASC;";
                            $queryProductosRes=mysqli_query($con,$queryProductos1);
                            if(mysqli_num_rows($queryProductosRes)){
                                while($rowC=mysqli_fetch_array($queryProductosRes)){
                                    ?>
                                      <tr>
                                        <td><?php echo $rowC['folio']; ?></td>
                                        <td><?php echo $rowC[7]; ?></td>
                                        <td><?php echo $rowC['nombre']; ?></td>
                                        <td><?php echo $rowC['fechaHora']; ?></td>
                                        <td><?php echo $rowC['Total']; ?></td>
                                      </tr>
                                    <?php
                                }
                            }
                        ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
<!--____________________________________________________________________________________-->
          <div class="card" data-toggle="collapse" href="#collapsefour">

            <div class="card-header">
              <label class="w3-text-blue">Compras del dia</label>
            </div>

            <div id="collapsefour" class="collapse hide" data-parent="#accordion">
              <div class="card-body">
                <div class="card">
                  <h2><?php echo "$mydate[weekday], $mydate[month], $mydate[mday], $mydate[year]"; ?><br>
                    Total: $
                    <?php
                        $queryCompras="SELECT SUM(Total) FROM facturacompra;";
                        $queryComprasRes=mysqli_query($con,$queryCompras);
                        $totalCompras=mysqli_fetch_array($queryComprasRes);
                        echo $totalCompras[0];
                    ?>
                  </h2>
                </div>
              <div class="table-responsive">
                  <table class="table table-striped table-sm">
                    <thead>
                      <tr>
                        <th>Folio</th>
                        <th>Usuario</th>
                        <th>Proveedor</th>
                        <th>Fecha & Hora</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                            $queryProductos1="
                            SELECT * FROM facturacompra F
                            JOIN usuario U on F.Usuario = U.codigo
                            JOIN proveedor P on F.proveedor = P.id
                            ORDER BY F.folio ASC;";
                            $queryProductosRes=mysqli_query($con,$queryProductos1);
                            if(mysqli_num_rows($queryProductosRes)){
                                while($rowC=mysqli_fetch_array($queryProductosRes)){
                                    ?>
                                      <tr>
                                        <td><?php echo $rowC['folio']; ?></td>
                                        <td><?php echo $rowC[7]; ?></td>
                                        <td><?php echo $rowC[13]; ?></td>
                                        <td><?php echo $rowC['fechaHora']; ?></td>
                                        <td><?php echo $rowC['Total']; ?></td>
                                      </tr>
                                    <?php
                                }
                            }
                        ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
<!--____________________________________________________________________________________-->
        </div>
      </center>
  </div>
<!-- END MAIN -->
</div>
</body>
</html>
<?php } ?>