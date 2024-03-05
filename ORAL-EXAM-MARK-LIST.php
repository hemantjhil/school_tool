<?php
ob_start ();
$dbusername = "id18479409_hemantjhil";
$dbpassword = "Manoj1234567@";
$dbname = "id18479409_modernjhabra";
$dbhost = "localhost";
$conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);


//getting file name from DB
$fileKey='oral-exam-mark-list';
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
$current_year=date("Y");
$studentSession = "student_" . $year;
$studentListQuery = "SELECT sy.admno,sd.name FROM $studentSession sy
    JOIN student_detail sd on sd.admno=sy.admno WHERE sy.class= '$classValue' ORDER BY sd.name ";
                //echo $feeQuery;
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

$Y_POS=23;
$pdf->AddPage();
$tplIdx = $pdf->importPage(1);
$pdf->useTemplate($tplIdx, 0, 0);
$pdf -> SetY(19);
$pdf -> SetX(85);
$pdf->Cell(27 ,5,$current_year.', CLASS-  ',0,0);
$pdf->Cell(117 ,5,$classValue,0,1);
$pdf -> SetY($Y_POS);
$pdf -> SetX(19);
$count=0;
while ($each = mysqli_fetch_array($studentList)) {
    $admno = $each[0];
    $name = $each[1];
    // $pdf->SetFont('Times', '', 6);
    // $pdf->SetTextColor(192, 192, 192);
    $count++;
    if($count<26){
        $pdf -> SetY($Y_POS);
    $pdf -> SetX(19);
    $pdf->Cell(217 ,$Y_POS,$name,0,1);
    
    $Y_POS+=4.38;
    }else{
        $pdf -> SetY($Y_POS);
    $pdf -> SetX(19);
    $pdf->Cell(217 ,$Y_POS,$name,0,1);
    
    $Y_POS+=1.38;
    }
}

// $pdf->Output($fileNl,'F');
$pdf->Output();

ob_end_flush();
?>