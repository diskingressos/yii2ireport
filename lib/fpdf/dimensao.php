 <?php
  define('FPDF_FONTPATH','font/');
  require_once("fpdf.php");
  require('celulas.php');
  
  $pdf=new pdf();
  $pdf->Open();
  $pdf->AddPage();
  $pdf->SetFont('Arial','',14);
  //Table with 20 rows and 4 columns
  $pdf->SetWidths(array(30,50,30,40));//CADA VALOR DESTE ARRAY SERÁ A LARGURA DE CADA COLUNA
  srand(microtime()*1000000);
  for($i=0;$i<20;$i++)
    $pdf->Row(array("$valor1","$valor2","$valor3","$valor4"));
$pdf->Output("dimensao.pdf","I");
  ?>
