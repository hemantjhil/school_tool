<html>
<title>CLASS WISE DUES</title>
<head>
	<!-- <script type="text/javascript" src="add_Student.js"></script> -->
	</head>
    <body style="background-color:aquamarine;">
<body>
	<form action="" method="get">
<div id="student_fee0">
	<!-- <script type="text/javascript" src="add_Student.js"></script> -->
<fieldset>
	<legend>CLASS AND MONTH DETAIL</legend>

<tr>
<td>CLASS</td>
<td><select name="class" id="class">
<option value="NUR" selected>NUR</option>
<option value=L.K.G>L.K.G</option>
<option value=U.K.G>U.K.G</option>
<option value=I>I - 1</option>
<option value=II>II - 2</option>
<option value=III>III - 3</option>
<option value=IV>IV - 4</option>
<option value=V>V - 5</option>
<option value=VI>VI - 6</option>
<option value=VII>VII - 7</option>
<option value=VIII>VIII - 8</option>
</select></td>
</tr>

<tr>
<td>Upto Month</td>
<td><select name="en" id="en">
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
<input type = "submit" name = "login" value = "CALCULATE DUES"/>
</div>
</form>
</body>
</html>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
	<!-- <script type="text/javascript" src="add_Student.js"></script> -->
</head>
	<body id="tb1">
		<form action="" method="get" id="final0">
			<fieldset>
			<legend>DUES DETAIL</legend>

<?php
$year = date("m") < 4 ? date("Y") - 1 : date("Y");
$studentSession = "student_" . $year;
$sessionStartDigits=fmod($year,100);
include('config.php');
if (isset($_GET["class"]) && isset($_GET["en"])) {
	$class = $_GET["class"];
    $en = $_GET["en"];

	$studentQuery = "select st.admno,sd.name,st.rte,st.class from $studentSession st left join student_detail sd on st.admno = sd.admno where
    sd.family_id in ( select sd.family_id from $studentSession st LEFT join student_detail sd on st.admno = sd.admno where st.class='$class' )
        order by sd.family_id;";
        echo $studentQuery;
    $allStudentList = mysqli_query($conn, $studentQuery);
    while ($eachStudent = mysqli_fetch_array($allStudentList)) {
                //echo $feeQuery;
        echo "<center>";
        // echo "Fees Details:   ";
        // echo "</br>";
        $admno = $eachStudent[0];
        $isRTE=$eachStudent[2];
        $class=$eachStudent[3];

        $firstTwoDigitOfAdmNo=(int)(($admno)/100);
        $paidUptoQuery = "select paid_upto from $studentSession where admno='$admno'";
        $startMonth = mysqli_query($conn, $paidUptoQuery);
        // echo "</br>";
        //echo $paidUptoQuery;
        // echo "</br>";
        //$re=$conn->query("$class");
        $startMon = $startMonth->fetch_assoc();
        $st = $startMon["paid_upto"];

        // $st=$_GET['st'.$count];
        // echo "</br>";
        echo "".$eachStudent[1]." & ";
        echo " ".$admno, " ".$class;
                // echo "</br>";
        echo " ";

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
        echo $allMonths[$st - 1];
        echo " E ";

        if($st!=3){
            echo $allMonths[$en - 1];
        }else{
            echo "MAR";
        }
        // echo "</br>";
        $route1 = mysqli_query(
            $conn,
            "select transport_route from $studentSession where admno='$admno'"
        );
        $route = null;
        while ($row = mysqli_fetch_array($route1)) {
            $route = $row["transport_route"];
        }
        $monthIndex = $st;
        $t1 = 0;
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
        echo "TD: " . $due1;
        $t2 = $t1+$due1 ;
        $dueTotal+= $due1;
        // echo "</br>";
        echo "TF: " . $t2;
    }

    $studentName=$routeFetch["name"];
    $routeName=$routeFetch["route_name"];
    $routeFee = $routeFetch["rfee"];
    echo '<input type="hidden" maxlength=100 name="admno" id="admno" value="'.$admno.'">';

    // echo "ADMISSION NO : ".$admno;
    // echo "</br>";
    // echo "</br>";

    // echo "STUDENT NAME : ".$studentName;
    // echo "</br>";
    // echo "</br>";
    // echo "ROUTE : ".$routeName;
    // echo "</br>";
    // echo "</br>";
    // echo "ROUTE FARE ".$routeFee;
    // echo "</br>";
    // echo "</br>";
}

function runFeeAlgo($monthIndex,$allMonths,$studentSession,$admno,$conn,$route,$sessionStartDigits,$firstTwoDigitOfAdmNo,$en,$isRTE){
    $t3=0;
    echo "MA" .$allMonths[$monthIndex - 1];
                $feeQuery = "select fee,type,month_show,frequency from fees where class in ('ALL',(select class from $studentSession where
                    admno=$admno)) and months_applicable in ($monthIndex,'ALL')";
                //echo $feeQuery;
                $cumulativeFee = mysqli_query($conn, $feeQuery);
                // echo "</br>";
                if($isRTE==='0' || is_null($isRTE)){
                    while ($each = mysqli_fetch_array($cumulativeFee)) {
                        $feeTitle = $each[1];
                        $feeValue = $each[0];
                        if($feeTitle=="ADMISSION FEE"){
                            if($sessionStartDigits==$firstTwoDigitOfAdmNo){
                                echo substr($feeTitle,0,1) . " : " . $feeValue."; ";
                                $t3 += $feeValue;
                            }
                        }else if($feeTitle=="SESSION FEE"){
                            if($sessionStartDigits!=$firstTwoDigitOfAdmNo){
                                echo substr($feeTitle,0,1) . " : " . $feeValue."; ";
                                $t3 += $feeValue;
                            }
                        }else if($feeTitle=="TUTION FEE"){
                            $frequency = $each[3];
                            $month_show = $each[2];
                            echo "MF".$month_show."; ";
                            $feeValue = $feeValue*$frequency;
                            echo substr($feeTitle,0,1) . " : " . $feeValue."; ";
                            $t3 += $feeValue;

                        }
                        else{
                            echo $feeTitle . " : " . $feeValue."; ";
                            $t3 += $feeValue;
                        }

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
                        echo "TRF: " . $tranf2."; ";
                    }
                }
                // echo "</br>";
                return $t3;
}
?>

<!-- 
<tr>
<td>UPDATE ROUTE</td>
<td><select name="route_id" id="route_id">
<option value="-1" selected>select..</option>
<option value=2>JANSA - 600</option>
<option value=3>BADAURA - 600</option>
<option value=4>MOHAMMADPUR - 600</option>
<option value=5>GORAI - 700</option>
<option value=6>KUNDARIA - 800</option>
<option value=7>BENIPUR - 800</option>
<option value=8>BHIKHAMPUR - 800</option>
<option value=9>SAMBHUPUR - 800</option>
<option value=10>HATHI - 800</option>
<option value=11>DASRATHPUR - 800</option>
<option value=12>KARDHANA - 800</option>
<option value=13>BASANTPUR - 800</option>
<option value=14>TARSAW - 800</option>
<option value=15>SAPREHTA - 1000</option>
<option value=16>DILAWALPUR - 1000</option>
</select></td>
</tr>

<input type = "submit" name = "login" id = "login" value = "CONFIRM" />
 -->
</fieldset>

</form>

</body>
</html>