<?php
require('./fpdf181/fpdf.php');
date_default_timezone_set('america/mexico_city');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('LogoReportes.png',10,0,200);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Movernos a la derecha
    $this->Cell(80);
    // Salto de línea
    $this->Ln(50);
}

// Tabla coloreada
function FancyTable()
{
    // Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','I',12);
    // Cabecera
    $this->Cell(20,8,"Folio",1,0,'C',true);
    $this->Cell(70,8,"Usuario",1,0,'C',true);
    $this->Cell(30,8,"Pago",1,0,'C',true);
    $this->Cell(40,8,"Fecha&Hora",1,0,'C',true);
    $this->Cell(20,8,"Total",1,0,'C',true);
    $this->Ln();
    // Restauración de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Datos
    $mydate=getdate(date("U"));
    $NOWfecha= "$mydate[year]-$mydate[mon]-$mydate[mday]";
    $NOWfechaP= "$mydate[year]-$mydate[mon]-$mydate[mday]%";
    require("conexion.php");
    $queryProductos1="
    SELECT * FROM facturaventa F
    JOIN usuario U on F.Usuario = U.codigo
    JOIN mpago P on F.pago = P.id
    WHERE fechaHora like '$NOWfechaP'
    ORDER BY F.folio ASC;";
    $queryProductosRes=mysqli_query($con,$queryProductos1);
    if(mysqli_num_rows($queryProductosRes)){
        while($rowC=mysqli_fetch_array($queryProductosRes)){
            $this->Cell(20,8,$rowC['folio'],'LR',0,'L',"KoSports");
            $this->Cell(70,8,$rowC[7],'LR',0,'L',"KoSports");
            $this->Cell(30,8,$rowC['nombre'],'LR',0,'C',"KoSports");
            $this->Cell(40,8,$rowC['fechaHora'],'LR',0,'L',"KoSports");
            $this->Cell(20,8,$rowC['Total'],'LR',0,'R',"KoSports");
            $this->Ln();
        }
    $this->Cell(180,0,'','T');
    $this->Ln();
	$this->Cell(120,8,"Historico de ventas",'LR',0,'L',"KoSports");
    $queryCompras="SELECT SUM(Total) FROM facturaventa WHERE fechaHora like '$NOWfechaP';";
    $queryComprasRes=mysqli_query($con,$queryCompras);
    $totalCompras=mysqli_fetch_array($queryComprasRes);
	$this->Cell(60,8,"Total: $".$totalCompras[0],'LR',0,'R',"KoSports");
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