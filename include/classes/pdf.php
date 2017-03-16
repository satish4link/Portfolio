<?php
if(isset($_POST['insert'])){
    $cat_id = $_POST['category_id'];
    $prod_name = $_POST['prod_name'];
    $desc = $_POST['prod_desc'];
    $prod_rate = $_POST['prod_rate'];

    require_once 'fpdf/fpdf.php';
    
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont("Arial", "B", 16);
    $pdf->Cell(0, 10, "Products list", 1, 1, "C");
    $pdf->Ln();
    $pdf->SetFont("Arial", "", 12);
    $pdf->Cell(50,10, "Category Name:",1,0,"C");
    $pdf->Cell(50,10, $cat_id,1,0,"C");
    $pdf->Ln();
    $pdf->Cell(50,10, "Product Name:",1,0,"C");
    $pdf->Cell(50,10, $prod_name,1,0,"C");
    $pdf->Ln();
    $pdf->Cell(50,10, "Description:",1,0,"C");
    $pdf->Cell(50,10, $desc,1,0,"C");
    $pdf->Ln();
    $pdf->Cell(50,10, "Product Rate:",1,0,"C");
    $pdf->Cell(50,10, $prod_rate,1,0,"C");

    
    $pdf->output();  
}  
?>