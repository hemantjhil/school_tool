<html>
<title>School Fee Portal</title>
<head>
	<!-- <script type="text/javascript" src="add_Student.js"></script> -->
	</head>
<body style="background-color:aquamarine;">
	<form action="" method="get">
<div id="student_fee0">
	<script type="text/javascript" src="add_Student.js"></script>
	<center>
<fieldset>
	<legend>STUDENT DETAIL</legend>
<center>
<h1>MODERN PUBLIC SCHOOL</h1>
<h2>JHABRA DEIPUR VARANASI</h2>
</center>

<?php
$year = date("m") < 4 ? date("Y") - 1 : date("Y");
?>
<tr>
<td>Admission No.</td>
<td><input type="text" name="admno0" id="admno0" size="30"></td>
</tr>
<tr>
<td>Year</td>
<td><input type="number" name="select_year" id="select_year" size="30" value = "<?php echo $year; ?>"></td>
</tr>
<tr>
<td>Upto Month</td>
<td><select name="en0" id="en0">
<option value="-1" selected>select..</option>
<option value=4>April</option>
<option value=5>May</option>
<option value=6>June</option>
<option value=7>July</option>
<option value=8>August</option>
<option value=9>September</option>
<option value=10>October</option>
<option value=11>November</option>
<option value=12>December</option>
<option value=1>January</option>
<option value=2>February</option>
<option value=3>March</option>
</select></td>
</tr>
<!-- <input type="integer" name=pay id="pay" size="20"/> -->

</fieldset>
</div>
<div>
<input type="hidden" name=index id="index" value="0">
<input type = "submit" name = "login" value = "CALCULATE"/>
<!--<input type="button" name="add_student" value="ADD STUDENT" onclick="addStudent()">-->
</center>
</div>
</form>
</body>
</html>
<!-- // $count=$_SESSION['index'];
// echo $count;
// echo "greet";
// $admno=$_GET["admno".$count];
// echo $admno;
// // echo $_GET["st"+$count];
// // echo $_GET["en"+$count];
// echo "great";
 -->

	<!DOCTYPE html>
<html>
	<head>
		<title></title>
	<script type="text/javascript" src="add_Student.js"></script>
</head>
	<body id="tb1" style="background-color:aquamarine;">
		<form action="res.php" method="get" id="final0">
			<fieldset>
			<legend></legend>
<?php
error_reporting(E_ERROR | E_PARSE);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    // echo "hi";
}
$index = $_GET["index"]??null;

// echo '<input type="text" name="index" id="index" value= "'.$index.'" />';
$allTotal = 0;
include('config.php');


$conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
$firstAdmno=$_GET["admno0"];
$firstEn=$_GET["en0"];


$year=$_GET["select_year"];
$studentSession = "student_" . $year;
$sessionStartDigits=fmod($year,100);
echo '<input type="hidden" maxlength=100 name="firstAdmno" id="firstAdmno" value="'.$firstAdmno.'">';
echo '<input type="hidden" maxlength=100 name="firstEn" id="firstEn" value="'.$firstEn.'">';
echo '<input type="hidden" maxlength=100 name="select_year" id="select_year" value="'.$year.'">';
$admno = $_GET["admno0"];
$studentQuery = " select st.admno,sd.name,st.class,st.rte from $studentSession st left join student_detail sd on st.admno = sd.admno where
    sd.family_id in ( select family_id from student_detail sd where sd.admno='$admno' ) ";
    // echo "</br>";
    // echo $studentQuery;
    // echo "</br>";
    // echo $studentQuery;
$allStudentList = mysqli_query($conn, $studentQuery);
$index=0;
$count=0;
if (isset($_GET["admno" . $count], $_GET["en" . $count])) {

        $dueTotal=0;
// echo "count " .$count;
while ($eachStudent = mysqli_fetch_array($allStudentList)) {
                //echo $feeQuery;
        echo "<center>";
        echo "Fees Details:   ";
        echo "</br>";

        // $counter=$_SESSION['count'];
        // for($i=0;$i<=$counter;$i++){
        echo $count;
        echo "</br>";
        $admno = $eachStudent[0];
        $_SESSION["admno" . $count] = $admno;
        $en = $_GET["en0"];

        //assign admno and en to p type html tag
        $eachAdmno="admno".$count;
        $eachEn="en".$count;
        $eachSt="st".$count;
        // echo "eachadmno: ".$eachAdmno;
        $isRTE=$eachStudent[3];
        // echo "Each Admno: ".$eachAdmno;
        echo '<input type="hidden" maxlength=100 name="'.$eachAdmno.'" id="'.$eachAdmno.'" value="'.$admno.'">';
        echo '<input type="hidden" maxlength=100 name="'.$eachEn.'" id="'.$eachEn.'" value="'.$en.'">';
        echo '<input type="hidden" maxlength=100 name="'.$eachEn.'" id="'.$eachEn.'" value="'.$en.'">';

        $firstTwoDigitOfAdmNo=(int)(($admno)/100);
        $paidUptoQuery = "select paid_upto from $studentSession where admno='$admno'";
        $startMonth = mysqli_query($conn, $paidUptoQuery);
        echo "</br>";
        //echo $paidUptoQuery;
        echo "</br>";
        //$re=$conn->query("$class");
        $startMon = $startMonth->fetch_assoc();
        $st = $startMon["paid_upto"];

        // $st=$_GET['st'.$count];
        echo "</br>";
        echo "STUDENT NAME : ".$eachStudent[1];
                echo "</br>";
        echo "STARTING MONTH:     ";
        if (is_null($st) || $st==0) {
            $st = 4;
        } elseif ($st == 12) {
            $st = 1;
        } elseif ($st==3) {
            $st=$st;
            # code...
        } else {
            $st += 1;
        }
        echo '<input type="hidden" maxlength=100 name="'.$eachSt.'" id="'.$eachSt.'" value="'.$st.'">';
        echo $allMonths[$st - 1];
        echo "</br>";
        echo "END MONTH:     ";
        if($st!=3){
            echo $allMonths[$en - 1];
        }else{
            echo "MAR";
        }
        echo "</br>";

        $_SESSION["st" . $count] = $st;
        //$mon = $en - $st + 1;
        //echo "Total Months:   ";
        //echo $mon;
        echo "</br>";
        $class = mysqli_query(
            $conn,
            "select class from $studentSession where admno=$admno"
        );
        //$re=$conn->query("$class");
        $r1 = $class->fetch_assoc();
        $r3 = $r1["class"];
        echo "Class:   " . $r3;
        echo "</br>";

        $monthIndex = $st;
        $route1 = mysqli_query(
            $conn,
            "select transport_route from $studentSession where admno='$admno'"
        );
        $route = null;
        while ($row = mysqli_fetch_array($route1)) {
            $route = $row["transport_route"];
        }
        $t1 = 0;
        // echo "intialized :".$feeValue;
        if($st!=3){
            if ($en > 3)
            {   //when end month is before start of new year
                //echo "Month Index : ".$monthIndex;
                while ($monthIndex <= $en)
                {
                    $t1+=runFeeAlgo($monthIndex,$allMonths,$studentSession,$admno,$conn,$route,$sessionStartDigits,$firstTwoDigitOfAdmNo,$en
                        ,$isRTE);
                    //
                    // echo "Month applicable" .$allMonths[$monthIndex - 1];
                    // $feeQuery = "select fee,type from fees where class in ('ALL',(select class from $studentSession where
                    //     admno=$admno)) and months_applicable in ($monthIndex,'ALL')";
                    // //echo $feeQuery;
                    // $cumulativeFee = mysqli_query($conn, $feeQuery);
                    // echo "</br>";
                    // while ($each = mysqli_fetch_array($cumulativeFee)) {
                    //     $feeTitle = $each[1];
                    //     $feeValue = $each[0];
                    //     if($feeTitle=="ADMISSION FEE"){
                    //         if($sessionStartDigits==$firstTwoDigitOfAdmNo){
                    //             echo $feeTitle . " : " . $feeValue;
                    //             $t1 += $feeValue;
                    //         }
                    //     }else if($feeTitle=="SESSION FEE"){
                    //         if($sessionStartDigits!=$firstTwoDigitOfAdmNo){
                    //             echo $feeTitle . " : " . $feeValue;
                    //             $t1 += $feeValue;
                    //         }
                    //     }else{
                    //         echo $feeTitle . " : " . $feeValue;
                    //         $t1 += $feeValue;
                    //     }
                    //     echo "</br>";

                    //     // echo "each total: ".$t1;echo "</br>";
                    // }
                    // if(!is_null($route)){
                    //     $tranf = mysqli_query(
                    //                     $conn,
                    //                     "select rfee from transport where id='$route'"
                    //                 );
                    //     if(!is_bool($tranf)){
                    //         $tranf1 = $tranf->fetch_assoc();
                    //         $tranf1 = $tranf1["rfee"];
                    //         $tranf2 = $tranf1;
                    //         $t1 += $tranf2;
                    //         echo "Transport Fee: " . $tranf2;
                    //         echo "</br>";
                    //     }
                    // }
                    // echo "</br>";
                    $monthIndex++;
                }
            }
            else
            { //when end month is in start of new year
                if ($monthIndex >= 4)
                { //when start month before new year
                    while ($monthIndex <= 12)
                    {
                        //echo "Month Index : ".$monthIndex;
                        $t1+=runFeeAlgo($monthIndex,$allMonths,$studentSession,$admno,$conn,$route,$sessionStartDigits,$firstTwoDigitOfAdmNo,$en,$isRTE);
                        // echo "Month applicable" .$allMonths[$monthIndex - 1];
                        // $feeQuery = "select fee,type from fees where class in ('ALL',(select class from $studentSession where
                        //     admno=$admno)) and months_applicable in ($monthIndex,'ALL')";
                        // //echo $feeQuery;
                        // $cumulativeFee = mysqli_query($conn, $feeQuery);
                        // echo "</br>";
                        // while ($each = mysqli_fetch_array($cumulativeFee)) {
                        //     $feeTitle = $each[1];
                        //     $feeValue = $each[0];
                        //     if($feeTitle=="ADMISSION FEE"){
                        //         if($sessionStartDigits==$firstTwoDigitOfAdmNo){
                        //             echo $feeTitle . " : " . $feeValue;
                        //         }
                        //     }else{
                        //         if($feeTitle=="SESSION FEE"){
                        //             if($sessionStartDigits!=$firstTwoDigitOfAdmNo){
                        //                 echo $feeTitle . " : " . $feeValue;
                        //             }
                        //         }else{
                        //             echo $feeTitle . " : " . $feeValue;
                        //         }
                        //     }
                        //     echo "</br>";
                        //     $t1 += $feeValue;
                        // }
                        // if(!is_null($route)){
                        //     $tranf = mysqli_query(
                        //                     $conn,
                        //                     "select rfee from transport where id='$route'"
                        //                 );
                        //     if(!is_bool($tranf)){
                        //         $tranf1 = $tranf->fetch_assoc();
                        //         $tranf1 = $tranf1["rfee"];
                        //         $tranf2 = $tranf1;
                        //         $t1 += $tranf2;
                        //         echo "TRANSPORT FEE : " . $tranf2;
                        //         echo "</br>";
                        //     }
                        // }
                        // echo "</br>";
                        $monthIndex++;
                    }
                    $monthIndex = 1;
                    while ($monthIndex <= $en)
                    {
                        //echo "Month Index : ".$monthIndex;
                        $t1+=runFeeAlgo($monthIndex,$allMonths,$studentSession,$admno,$conn,$route,$sessionStartDigits,$firstTwoDigitOfAdmNo,$en,$isRTE);
                        // echo "Month applicable" .$allMonths[$monthIndex - 1];
                        // $feeQuery = "select fee,type from fees where class in ('ALL',(select class from $studentSession where
                        //     admno=$admno)) and months_applicable in ($monthIndex,'ALL')";
                        // //echo $feeQuery;
                        // $cumulativeFee = mysqli_query($conn, $feeQuery);
                        // echo "</br>";
                        // while ($each = mysqli_fetch_array($cumulativeFee)) {
                        //     $feeTitle = $each[1];
                        //     $feeValue = $each[0];
                        //     if($feeTitle=="ADMISSION FEE"){
                        //         if($sessionStartDigits==$firstTwoDigitOfAdmNo){
                        //             echo $feeTitle . " : " . $feeValue;
                        //         }
                        //     }else{
                        //         if($feeTitle=="SESSION FEE"){
                        //             if($sessionStartDigits!=$firstTwoDigitOfAdmNo){
                        //                 echo $feeTitle . " : " . $feeValue;
                        //             }
                        //         }else{
                        //             echo $feeTitle . " : " . $feeValue;
                        //         }
                        //     }
                        //     echo "</br>";
                        //     $t1 += $feeValue;
                        // }
                        // if(!is_null($route)){
                        //     $tranf = mysqli_query(
                        //                     $conn,
                        //                     "select rfee from transport where id='$route'"
                        //                 );
                        //     if(!is_bool($tranf)){
                        //         $tranf1 = $tranf->fetch_assoc();
                        //         $tranf1 = $tranf1["rfee"];
                        //         $tranf2 = $tranf1;
                        //         $t1 += $tranf2;
                        //         echo "Transport Fee: " . $tranf2;
                        //         echo "</br>";
                        //     }
                        // }
                        // echo "</br>";
                        $monthIndex++;
                    }
                } else
                {   //when start month is also in new year
                    while ($monthIndex <= $en)
                    {
                        //echo "Month Index : ".$monthIndex;
                        $t1+=runFeeAlgo($monthIndex,$allMonths,$studentSession,$admno,$conn,$route,$sessionStartDigits,$firstTwoDigitOfAdmNo,$en,$isRTE);
                        // echo "Month applicable" .$allMonths[$monthIndex - 1];
                        // $feeQuery = "select fee,type from fees where class in ('ALL',(select class from $studentSession where
                        //     admno=$admno)) and months_applicable in ($monthIndex,'ALL')";
                        // //echo $feeQuery;
                        // $cumulativeFee = mysqli_query($conn, $feeQuery);
                        // echo "</br>";
                        // while ($each = mysqli_fetch_array($cumulativeFee)) {
                        //     $feeTitle = $each[1];
                        //     $feeValue = $each[0];
                        //     if($feeTitle=="ADMISSION FEE"){
                        //         if($sessionStartDigits==$firstTwoDigitOfAdmNo){
                        //             echo $feeTitle . " : " . $feeValue;
                        //         }
                        //     }else{
                        //         if($feeTitle=="SESSION FEE"){
                        //             if($sessionStartDigits!=$firstTwoDigitOfAdmNo){
                        //                 echo $feeTitle . " : " . $feeValue;
                        //             }
                        //         }else{
                        //             echo $feeTitle . " : " . $feeValue;
                        //         }
                        //     }
                        //     echo "</br>";
                        //     $t1 += $feeValue;
                        // }
                        // if(!is_null($route)){
                        //     $tranf = mysqli_query(
                        //                     $conn,
                        //                     "select rfee from transport where id='$route'"
                        //                 );
                        //     if(!is_bool($tranf)){
                        //         $tranf1 = $tranf->fetch_assoc();
                        //         $tranf1 = $tranf1["rfee"];
                        //         $tranf2 = $tranf1;
                        //         $t1 += $tranf2;
                        //         echo "Transport Fee: " . $tranf2;
                        //         echo "</br>";
                        //     }
                        // }
                        // echo "</br>";
                        $monthIndex++;
                    }
                }
                # code...
            }
        }
        $due = mysqli_query(
        $conn,
        "select dues from $studentSession where admno='$admno'"
        );
        $due1 = $due->fetch_assoc();
        $due1 = $due1["dues"];
        $t2 = $t1 ;
        $dueTotal+= $due1;
        echo "</br>";
        echo "TOTAL FEE: " . $t2;
        $tot[$count] = $t2;
        $allTotal += $tot[$count];
        $_SESSION["tot"] = $tot[$count];
        echo "</br>";
        echo "</br>";
        echo "</br>";
        echo "</br>";
        echo "</br>";
        $index++;
        $count++;

    }
    // echo '<input type="hidden" name="allTotal" id="allTotal" value= "$allTotal" />';
    $_SESSION["allTotal"] = $allTotal;
    echo "PREVIOUS DUES:  ".$dueTotal;
    echo "</br>";
    echo "</br>";
    $allTotal+=$dueTotal;
    echo "ALL TOTAL FEE:  ".$allTotal;
    echo "</br>";
    echo "</br>";
    echo "</center>";
    $_SESSION["index"] = $index;
}

function runFeeAlgo($monthIndex,$allMonths,$studentSession,$admno,$conn,$route,$sessionStartDigits,$firstTwoDigitOfAdmNo,$en,$isRTE){
    $t3=0;
    echo "MONTH APPLICABLE: " .$allMonths[$monthIndex - 1];
                $feeQuery = "select fee,type,month_show,frequency from fees where class in ('ALL',(select class from $studentSession where
                    admno=$admno)) and months_applicable in ($monthIndex,'ALL')";
                //echo $feeQuery;
                $cumulativeFee = mysqli_query($conn, $feeQuery);
                echo "</br>";
                if($isRTE==='0' || is_null($isRTE)){
                    while ($each = mysqli_fetch_array($cumulativeFee)) {
                        $feeTitle = $each[1];
                        $feeValue = $each[0];
                        if($feeTitle=="ADMISSION FEE"){
                            if($sessionStartDigits==$firstTwoDigitOfAdmNo){
                                echo $feeTitle . " : " . $feeValue;
                                $t3 += $feeValue;
                            }
                        }else if($feeTitle=="SESSION FEE"){
                            if($sessionStartDigits!=$firstTwoDigitOfAdmNo){
                                echo $feeTitle . " : " . $feeValue;
                                $t3 += $feeValue;
                            }
                        }else if($feeTitle=="TUTION FEE"){
                            $frequency = $each[3];
                            $month_show = $each[2];
                            echo "MONTHS FOR: ".$month_show;
                            echo "</br>";
                            $feeValue = $feeValue*$frequency;
                            echo $feeTitle . " : " . $feeValue;
                            $t3 += $feeValue;

                        }
                        else{
                            echo $feeTitle . " : " . $feeValue;
                            $t3 += $feeValue;
                        }
                        echo "</br>";

                        // echo "each total: ".$t1;echo "</br>";
                    }
                }
                if(!is_null($route) && $route!=0){
                    $tranf = mysqli_query(
                                    $conn,
                                    "select rfee from transport where id='$route'"
                                );
                                echo is_bool($tranf);
                    if(!is_bool($tranf)){
                        $tranf1 = $tranf->fetch_assoc();
                        // echo "trand";
                        $tranf1 = $tranf1["rfee"];
                        $tranf2 = $tranf1;
                        $t3 += $tranf2;
                        echo "TRANSPORT FEE: " . $tranf2;
                        echo "</br>";
                    }
                }
                echo "</br>";
                return $t3;
}

// }

?>
    <center>
	FEE PAID:
	<input type="integer" name="paid" id="paid" size="20"/>
	Discount:
	<input type="integer" name="disc" id="disc" size="20" value="0"/>
    <br/>
    <br/>
    <br/>
<!--     ANY OTHER FEE(IF NEEDED) : -->
<!--     <input type="varchar" name="fee_type" id="fee_type" size="50"/> -->
<!--     AMOUNT -->
<!--     <input type="integer" name="fee_value" id="fee_value" size="20"/> -->

	<br/>
	<br/>
	<br/>
	REMARKS :
	<input type="varchar" name="remarks" id="remarks" size="100"/>
	<br/>
	<br/>
		<br/>
		<div id="count"></div>
	Confirm:
	<input type = "submit" name = "login" id = "login" value = "CONFIRM" />

    <input type = "hidden" name = "dueTotal" id="dueTotal" value = "<?php echo $dueTotal; ?>"/>
	<input type = "hidden" name = "allTotal" id="allTotal" value = "<?php echo $allTotal; ?>"/>
	<input type = "hidden" name = "index" id="index" value = "<?php echo $index; ?>" />

	<br/>
	</center>
	</fieldset>
</form>

</body>
</html>