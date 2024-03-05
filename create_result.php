<?php
ob_start ();

include('config.php');
$conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);


//getting file name from DB
$fileKey='internal-result-file-name';
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
// echo yes;

//getting the student list
$year = date("m") < 4 ? date("Y") - 1 : date("Y");
$studentSession = "student_" . $year;
$studentListQuery = "SELECT
    max(CASE WHEN su.id = '1' THEN er.Marks END) AS h,
    max(CASE WHEN su.id = '2' THEN er.Marks END) AS e,
    max(CASE WHEN su.id = '3' THEN er.Marks END) AS m,
    max(CASE WHEN su.id = '4' THEN er.Marks END) AS sc,
    max(CASE WHEN su.id = '5' THEN er.Marks END) AS so,
    max(CASE WHEN su.id = '6' THEN er.Marks END) AS pt,
    max(CASE WHEN su.id = '7' THEN er.Marks END) AS gk,
    max(CASE WHEN su.id = '8' THEN er.Marks END) AS comp,
    max(CASE WHEN su.id = '9' THEN er.Marks END) AS apt,
    max(CASE WHEN su.id = '10' THEN er.Marks END) AS att,
    s.admno,
    s.name,
    s.father_name
FROM
    student_detail s
JOIN
    exam_results er ON s.admno = er.admno
JOIN
    subjects su ON er.subject_id = su.id
JOIN
    exams e ON er.exam_id = e.id
JOIN
	$studentSession st on st.admno=s.admno
WHERE st.class= '$classValue' and e.id=2
GROUP BY
    s.admno";
                // echo $feeQuery;
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
    $h = $each[0];
    $e = $each[1];
    $m = $each[2];
    $sc = $each[3];
    $so = $each[4];
    $pt = $each[5];
    $gk = $each[6];
    $comp = $each[7];
    $apt = $each[8];
    $att = $each[9];
    $admno = $each[10];
    $name = $each[11];
    $fname=$each[12];
    $total=$h+$m+$e+$gk+$pt; // + //$sc+$so+$comp+$apt; // +$sc+$so;
    $decimalPlaces = 4;
    $percent = number_format($total / 400.0, $decimalPlaces);
    $percent=$percent*100;
    // echo "total ".$total;
    // $pdf->SetFont('Times', '', 6);
    // $pdf->SetTextColor(192, 192, 192);
    if($even){
        $pdf->AddPage();
        $tplIdx = $pdf->importPage(1);
        $pdf->useTemplate($tplIdx, 0, 0);
        $pdf -> SetY(42);
        $pdf -> SetX(44);
    }else{
        $pdf -> SetY(173);
        $pdf -> SetX(44);
    }
    
    $pdf->Cell(102 ,5,$name,0,0);
    $pdf->Cell(42 ,5,$classValue,0,0);
    $pdf->Cell(5 ,5,$admno,0,1);
    if($even){
        $pdf -> SetY(51);
        $pdf -> SetX(44);
    }else{
        $pdf -> SetY(181);
        $pdf -> SetX(44);
    }
    // father name 
    $pdf->Cell(119 ,5,$fname,0,1);
    if($even){
        $pdf -> SetY(77);
        $pdf -> SetX(170);
    }else{
        $pdf -> SetY(208);
        $pdf -> SetX(170);
    }
    // father name 
    $pdf->Cell(20 ,5,"400",0,0);
    $pdf->Cell(10 ,5,"100",0,1);
    
    if($even){
        $pdf -> SetY(93);
        $pdf -> SetX(42);
    }else{
        $pdf -> SetY(224);
        $pdf -> SetX(42);
    }
    $pdf->Cell(16 ,5,$h,0,0);
    $pdf->Cell(16 ,5,$e,0,0);
    $pdf->Cell(16 ,5,$m,0,0);
    if($sc>0){
    $pdf->Cell(16 ,5,$sc,0,0);
    }
    else
    {
         $pdf->Cell(16 ,5,'-',0,0);
    }
    if($so>0)
    {
    $pdf->Cell(12 ,5,$so,0,0);
    }
     else
    {
         $pdf->Cell(12 ,5,'-',0,0);
    }
    if($gk>0)
    {
    $pdf->Cell(14 ,5,$gk,0,0);
    }
     else
    {
         $pdf->Cell(14 ,5,'-',0,0);
    }
    if($pt>0)
    {
    $pdf->Cell(12 ,5,$pt,0,0);
    }
     else
    {
         $pdf->Cell(12 ,5,'-',0,0);
    }
    if($comp>0)
    {
    $pdf->Cell(12 ,5,$comp,0,0);
    }
     else
    {
         $pdf->Cell(12 ,5,'-',0,0);
    }
    if($apt>0)
    {
    $pdf->Cell(12 ,5,$apt,0,0);
    }
     else
    {
         $pdf->Cell(12 ,5,'-',0,0);
    }
    $pdf->Cell(20 ,5,$total,0,0);
    $pdf->Cell(15 ,5,$percent.'%',0,1);
    
   // $att=44;
    if($even){
        $pdf -> SetY(117);
        $pdf -> SetX(180);
        $even=false;
    }else{
        $pdf -> SetY(249);
        $pdf -> SetX(180);
        $even=true;
    }
    $pdf->Cell(15 ,5,$att.'/57',0,0);
    
}

// $pdf->Output($fileNl,'F');
$pdf->Output();

ob_end_flush();
?>