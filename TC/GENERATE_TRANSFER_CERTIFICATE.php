<?php
//error_reporting(E_ERROR | E_PARSE);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
$admno = $_GET["admno"];
$tcno = $_GET["tcno"];
include('../config.php');
$year = date("m") < 4 ? date("Y") - 1 : date("Y");
$studentYear=$year-1;
$studentSession = "student_" . $studentYear;
//$sessionStartDigits=fmod($year,100);
$studentQuery = " select sd.name,sd.aadhaar,sd.religion,sd.father_name,sd.mother_name,sd.address,sd.dob,
    sd.enrolled_in_date,sd.enrolled_out_date,sd.previous_attended_school,st.rte,st.class
 from  student_detail sd left join  $studentSession st on st.admno = sd.admno where
    sd.admno= '$admno' ";
$student_detail = mysqli_query($conn, $studentQuery);

//echo "yes";

while ($each = mysqli_fetch_array($student_detail)) {
//echo "yes";
$firstTwoDigitOfAdmNo=(int)(($admno)/100);
$year = date("Y");
$sessionStartDigits=fmod($year,100);
//echo $sessionStartDigits." ";
//echo $firstTwoDigitOfAdmNo," ";
$classesToFill=$sessionStartDigits-$firstTwoDigitOfAdmNo-1;



$name=$each[0];
$aadhaar=$each[1];
$religion=$each[2];
$father_name=$each[3];
$mother_name=$each[4];
$address=$each[5];
$dob=$each[6];
$enrolled_in_date=$each[7];
$enrolled_out_year=$each[8];
$previous_attended_school=$each[9];
$rte=$each[10];
$class=$each[11];
//echo "ADMNO: ".$admno;
if($rte==1){
	$rteValue="YES";
}else{
	$rteValue="NO";
}
$classInInt=getClassInInteger($class);
if(!is_null($dob)){
$birth_date = $dob;
$new_birth_date = explode('/', $birth_date);
$year = $new_birth_date[2];
$month = $new_birth_date[1];
$day  = $new_birth_date[0];
$birth_day=numberTowords($day);
$birth_year=numberTowords($year);
$monthNum = $month;
$dateObj = DateTime::createFromFormat('!m', $monthNum);//Convert the number into month name
$monthName = strtoupper($dateObj->format('F'));
}
require('../fpdf185/fpdf.php');

//A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm

//create pdf object
$pdf = new FPDF('P','mm','A4');
//add new page
$pdf->AddPage();

    //Put the watermark
    $pdf->SetFont('Arial','',12);

//output the result
//set font to arial, bold, 14pt
$pdf->SetFont('Arial','',12);
$img1="../schoollogo1.png";
//$pdf->imageUniformToFill($img1);
//$pdf->Cell( 100, 40, $pdf->Image($img1, $pdf->GetX(), $pdf->GetY()+5, 33.78), 0, 1 ,'R', false);
$pdf->Image($img1,10,15,35,35,'png');

//$pdf->SetWatermarkImage(35,90,$img1,10);
$pdf->Cell(139 ,5,'',0,0);
// $pdf->Image($img1, 0, 0, 0, 0);
//Cell(width , height , text , border , end line , [align] )
$pdf->Cell(59 ,5,'UDISE CODE - 09670509902',0,1);//end of line
//$pdf->Cell(59 ,5,'',0,1);//end of line
//$pdf->Cell(59 ,5,'',0,1);//end of line
$pdf->Cell(59 ,5,'',0,0);

$pdf->SetFont('Arial','B',18);
$pdf->Cell(130 ,5,'MODERN PUBLIC SCHOOL',0,1);



//set font to arial, regular, 12pt
$pdf->SetFont('Arial','',12);
$pdf->Cell(62 ,5,'',0,0);
$pdf->Cell(130 ,5,'JHABRA DEIPUR VARANASI 221405',0,0);
$pdf->Cell(59 ,5,'',0,1);//end of line

//$pdf->Cell(130 ,5,'VARANASI INDIA 221405',0,0);

$Date=date("d/m/Y");
//$pdf->Cell(25 ,5,'Date',0,0);
//$pdf->Cell(34 ,5,$Date,0,1);//end of line
$pdf->Cell(52 ,5,'',0,0);
$pdf->Cell(40 ,5,'Mob. - 9451093677',0,0);


$pdf->Cell(30 ,5,'Mail ID - modern@mpsvns.in',0,1);
$pdf->Cell(63 ,5,'',0,1);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(70 ,5,'',0,0);
$pdf->Cell(60 ,5,'TRANSFER CERTIFICATE',1,1,'C');//end of line
$pdf->Cell(63 ,5,'',0,1);

$pdf->Cell(38 ,5,'',0,0);
$pdf->Cell(25 ,5,'TC No. #',0,0);
$pdf->Cell(25 ,5,$tcno,0,0);//end of line

$pdf->SetFont('Arial','B',12);

$pdf->Cell(23 ,5,'SCH NO. - ',0,0);

$pdf->SetFont('Arial','',12);
$pdf->Cell(43 ,5,$admno,0,0);//end of line

$pdf->SetFont('Arial','B',12);
$pdf->Cell(23 ,5,'ADM NO. - ',0,0);

$pdf->SetFont('Arial','',12);
$pdf->Cell(13 ,5,$admno,0,1);//end of line
// $pdf->Cell(130 ,5,'',0,0);


$pdf->Cell(38 ,5,'',0,0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(25 ,5,'Name - ',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(25 ,5,$name,0,1);//end of line


$pdf->Cell(38 ,5,'',0,0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(35 ,5,'Date Of Birth -',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(10 ,5,$dob,0,0);//end of line

$pdf->Cell(38 ,5,'',0,0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(35 ,5,'Religion/Caste - ',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(25 ,5,$religion,0,1);//end of line

//$pdf->Cell(38 ,5,'',0,0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(30 ,5,'Mother Name - ',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(60 ,5,$mother_name,0,0);//end of line


//$pdf->Cell(38 ,5,'',0,0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(32 ,5,'Father Name - ',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(25 ,5,$father_name,0,1);//end of line

//$pdf->Cell(38 ,5,'',0,0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(55 ,5,'Last Institution Attended - ',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(25 ,5,$previous_attended_school,0,1);//end of line

//$pdf->Cell(38 ,5,'',0,0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(25 ,5,'Address - ',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(25 ,5,$address,0,1);//end of line

$pdf->SetFont('Arial','B',12);
$pdf->Cell(40 ,5,'Aadhaar Number - ',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(25 ,5,$aadhaar,0,1);//end of line

$pdf->SetFont('Arial','B',12);
$pdf->Cell(45 ,5,'Admitted under RTE - ',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(25 ,5,$rteValue,0,1);//end of line

$pdf->SetFont('Arial','B',12);
$pdf->Cell(55 ,5,'Date Of Birth (In Words) - ',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(25 ,5,$birth_day.' '.$monthName.' '.$birth_year,0,1);//end of line

$pdf->SetFont('Arial','B',12);

$pdf->Cell(38 ,5,'',0,1);
$pdf->Cell(38 ,5,'',0,1);
$pdf->Cell(38 ,5,'',0,1);

//HEADING
$pdf->Cell(15 ,5,'Class',0,0,'C');
$pdf->Cell(30 ,5,'Date Of',0,0,'C');
$pdf->Cell(30 ,5,'Date Of',0,0,'C');
$pdf->Cell(30 ,5,'Date Of',0,0,'C');
$pdf->Cell(30 ,5,'Cause Of',0,0,'C');
$pdf->Cell(15 ,5,'Year',0,0,'C');
$pdf->Cell(30 ,5,'Moral ',0,0,'C');
$pdf->Cell(15 ,5,'Sign',0,1,'C');

$pdf->Cell(15 ,5,'',0,0);
$pdf->Cell(30 ,5,'Admission',0,0,'C');
$pdf->Cell(30 ,5,'Promotion',0,0,'C');
$pdf->Cell(30 ,5,'Removal',0,0,'C');
$pdf->Cell(30 ,5,'Removal',0,0,'C');
$pdf->Cell(15 ,5,'',0,0);
$pdf->Cell(30 ,5,'Character ',0,0,'C');
$pdf->Cell(15 ,5,'',0,1);

$pdf->SetFont('Arial','',12);
//NUR
$pdf->Cell(15 ,5,'NUR',1,0,'C');
$pdf->Cell(30 ,5,'',1,0,'C');
$pdf->Cell(30 ,5,'',1,0,'C');
$pdf->Cell(30 ,5,'',1,0,'C');
$pdf->Cell(30 ,5,'',1,0,'C');
$pdf->Cell(15 ,5,'',1,0,'C');
$pdf->Cell(30 ,5,' ',1,0,'C');
$pdf->Cell(15 ,5,'',1,1,'C');

//LKG
$pdf->Cell(15 ,5,'L.K.G.',1,0,'C');
$pdf->Cell(30 ,5,'',1,0,'C');
$pdf->Cell(30 ,5,'',1,0,'C');
$pdf->Cell(30 ,5,'',1,0,'C');
$pdf->Cell(30 ,5,'',1,0,'C');
$pdf->Cell(15 ,5,'',1,0,'C');
$pdf->Cell(30 ,5,' ',1,0,'C');
$pdf->Cell(15 ,5,'',1,1,'C');

//UKG
$pdf->Cell(15 ,5,'U.K.G.',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(15 ,5,'',1,0);
$pdf->Cell(30 ,5,' ',1,0);
$pdf->Cell(15 ,5,'',1,1);

//I
$pdf->Cell(15 ,5,'I',1,0,'C');
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(15 ,5,'',1,0);
$pdf->Cell(30 ,5,' ',1,0);
$pdf->Cell(15 ,5,'',1,1);

//II
$pdf->Cell(15 ,5,'II',1,0,'C');
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(15 ,5,'',1,0);
$pdf->Cell(30 ,5,' ',1,0);
$pdf->Cell(15 ,5,'',1,1);

//III
$pdf->Cell(15 ,5,'III',1,0,'C');
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(15 ,5,'',1,0);
$pdf->Cell(30 ,5,' ',1,0);
$pdf->Cell(15 ,5,'',1,1);

//IV
$pdf->Cell(15 ,5,'IV',1,0,'C');
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(15 ,5,'',1,0);
$pdf->Cell(30 ,5,' ',1,0);
$pdf->Cell(15 ,5,'',1,1);


//V
$pdf->Cell(15 ,5,'V',1,0,'C');
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(15 ,5,'',1,0);
$pdf->Cell(30 ,5,' ',1,0);
$pdf->Cell(15 ,5,'',1,1);


//VI
$pdf->Cell(15 ,5,'VI',1,0,'C');
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(15 ,5,'',1,0);
$pdf->Cell(30 ,5,' ',1,0);
$pdf->Cell(15 ,5,'',1,1);

//VII
$pdf->Cell(15 ,5,'VII',1,0,'C');
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(15 ,5,'',1,0);
$pdf->Cell(30 ,5,' ',1,0);
$pdf->Cell(15 ,5,'',1,1);


//VIII
$pdf->Cell(15 ,5,'VIII',1,0,'C');
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(30 ,5,'',1,0);
$pdf->Cell(15 ,5,'',1,0);
$pdf->Cell(30 ,5,' ',1,0);
$pdf->Cell(15 ,5,'',1,1);


$lastClass=6;
//echo $lastClass." ";
$x=11;
$y=110 + $classInInt*5;
$pdf -> SetY($y);
$pdf -> SetX($x);
$startYear=2022;
$endYear=2023;
$index=0;
//echo $lastClass." ";
$classesToFill=$sessionStartDigits-$firstTwoDigitOfAdmNo-1;
//echo $sessionStartDigits." ";
//echo $firstTwoDigitOfAdmNo," ";
//echo $classesToFill." "; 
while($classesToFill>=0){

$pdf->Cell(15 ,5,'',0,0,'C');
if($classesToFill!=0){

$pdf->Cell(30 ,5,'01/04/'.$startYear,0,0,'C');

}
else{

$pdf->Cell(30 ,5,$enrolled_in_date,0,0,'C');

}

$pdf->Cell(30 ,5,'31/03/'.$endYear,0,0,'C');
if($index==0){
$pdf->Cell(30 ,5,'31/03/'.$endYear,0,0,'C');
$pdf->Cell(30 ,5,'PERSONAL',0,0,'C');
}else{
$pdf->Cell(30 ,5,'',0,0);
$pdf->Cell(30 ,5,'',0,0,'C');
}

$pdf->Cell(15 ,5,$endYear,0,0,'C');
$pdf->Cell(30 ,5,'GOOD',0,0,'C');
$pdf->Cell(15 ,5,'',0,1);
$y-=5;
$pdf -> SetY($y);
$pdf -> SetX($x);
$classesToFill--;
$endYear--;
$startYear--;
$index++;
}
$lastClass=11;
$startYear=2022;
$endYear=2023;
$index=0;
$classesToFill=$sessionStartDigits-$firstTwoDigitOfAdmNo-1;
$x=8;
$y=220;
$pdf -> SetY($y);
$pdf -> SetX($x);
$pdf->Cell(215 ,5,'Certified that the entries as regards details of the student has been duly checked from the admission',0,1);
$pdf->Cell(15 ,5,'form  and that they are completely correct. ',0,1);
//$pdf->Cell(214 ,5,'Certified that the above student register has been posted up-to-date of the student leaving as ',0,1);
//$pdf->Cell(215 ,5,'required by the department rules.',0,1);




$x=8;
$y=250;
$pdf -> SetY($y);
$pdf -> SetX($x);
$pdf->Cell(28 ,5,'Prepared by - ',0,0);
$pdf->Cell(95 ,5,'RAJKUMAR VISWAKARMA',0,0);

$pdf->Cell(15 ,5,'Dated - ',0,0);
$pdf->Cell(15 ,5,$Date,0,1);

$pdf->Cell(195 ,5,'',0,1);
$pdf->Cell(195 ,5,'',0,1);
$pdf->Cell(195 ,5,'',0,1);
$pdf->Cell(155 ,5,'',0,0);
$pdf->Cell(15 ,5,'Head Of Institution',0,1);
//$pdf->Cell(15 ,5,'  ',0,0);
$pdf->Output();

}


?>
