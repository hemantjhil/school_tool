<?php
ob_start ();

include('config.php');
$conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);


//getting file name from DB
$fileKey='admit-card-file-name';
$fileName = mysqli_query(
            $conn,
            "select value from constants where constant_key = '$fileKey' "
        );

        $query="select value from constants where constant_key = '$fileKey' ";
        // echo "Query".$query;
$fileAss = $fileName->fetch_assoc();
$fileValue = $fileAss["value"];

//getting the classs name from DB constants
$classKey='admit-card-class';
$className = mysqli_query(
            $conn,
            "select value from constants where constant_key= '$classKey' "
        );
$classAss = $className->fetch_assoc();
$classValue = $classAss["value"];

//getting the student list
$year = date("m") < 4 ? date("Y") - 1 : date("Y");
$studentSession = "student_" . $year;
$studentListQuery = "SELECT sy.admno,sd.name FROM $studentSession sy
    JOIN student_detail sd on sd.admno=sy.admno WHERE sy.class= '$classValue' ";
                //echo $feeQuery;
               // echo $studentListQuery;
$studentList = mysqli_query($conn, $studentListQuery);
// echo "</br>";

$month=date("F");

$fileNl="\\".$classValue.".pdf";

        //echo $total;
require_once('fpdf185/fpdf.php');
require_once 'FPDI/src/autoload.php';
// require_once('FPDI/src/Tfpdf/Fpdi.php');

$pdf = new \setasign\Fpdi\Fpdi();
//A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm
$pages_count = $pdf->setSourceFile($fileValue);
//use the imported page and place it at point 0,0; calculate width and height
//automaticallay and ajust the page size to the size of the imported page
//output the result
//set font to arial, bold, 14pt
//$pdf->SetFont('Arial','B',14);

$pdf->SetFont('Arial','',12);
$even=true;

while ($each = mysqli_fetch_array($studentList)) {
    $admno = $each[0];
    $name = $each[1];
    // $pdf->SetFont('Times', '', 6);
    // $pdf->SetTextColor(192, 192, 192);
    if($even){
        $pdf->AddPage();
        $tplIdx = $pdf->importPage(1);
        $pdf->useTemplate($tplIdx, 0, 0);
        $pdf -> SetY(24);
        $pdf -> SetX(32);
        $even=false;
    }else{
        $pdf -> SetY(172);
        $pdf -> SetX(32);
        $even=true;
    }
    $pdf->Cell(119 ,5,$name,0,0);
    $pdf->Cell(37 ,5,$classValue,0,0);
    $pdf->Cell(10 ,5,$admno,0,0);
}

// $pdf->Output($fileNl,'F');
$pdf->Output();

ob_end_flush();
?>