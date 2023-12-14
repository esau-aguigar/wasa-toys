<?php
require('./fpdf181/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('LogoFactura.png',10,0,200);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Movernos a la derecha
    $this->Cell(80);
    // Salto de línea
    $this->Ln(50);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    $this->Image('firmaFactura.png',20,200,180);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
// Tabla coloreada
function FancyTable()
{
    // Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Cabecera
    $this->Cell(36,8,"Cantidad",1,0,'C',true);
    $this->Cell(36,8,"U. Medida",1,0,'C',true);
    $this->Cell(36,8,"Descripcion",1,0,'C',true);
    $this->Cell(36,8,"P. Unitario",1,0,'C',true);
    $this->Cell(36,8,"Importe",1,0,'C',true);
    $this->Ln();
    // Restauración de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Datos
    require("conexion.php");
    $folio = $_GET['folio'];
    $queryDetalle="
	  SELECT * FROM detalleventa DV
	  JOIN facturaventa FV ON DV.factura = FV.folio
        JOIN producto P ON DV.producto = P.barcode
        JOIN usuario U ON FV.usuario = U.codigo
        WHERE DV.factura = '$folio';";
	   $queryDetalleRes=mysqli_query($con,$queryDetalle);
	   if(mysqli_num_rows($queryDetalleRes)){
            while ($rowDetalles=mysqli_fetch_array($queryDetalleRes)) {
    	    	$this->Cell(36,8,$rowDetalles['cantidad'],'LR',0,'L',"toys");
    	    	$this->Cell(36,8,"Pieza",'LR',0,'L',"toys");
    	    	$this->Cell(36,8,$rowDetalles[11],'LR',0,'L',"toys");
    	    	$this->Cell(36,8,$rowDetalles[14],'LR',0,'L',"toys");
    	    	$this->Cell(36,8,$rowDetalles[4],'LR',0,'L',"toys");
        		$this->Ln();
            }
        $queryDetalleRes=mysqli_query($con,$queryDetalle);
        $rowDetalles2=mysqli_fetch_array($queryDetalleRes);
        $this->Cell(180,0,'','T');
        $this->Ln();
    	$this->Cell(144,8,"Pago en efectivo en una sola exhibicion. A la entrega. Efectivo",'LR',0,'L',"toys");
    	$this->Cell(36,8,"Total: $".$rowDetalles2[7].".",'LR',0,'L',"toys");
        $this->Ln();
        $this->Cell(180,0,'','T');
	}
    // Línea de cierre
}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->FancyTable();
$pdf->Output();

?>