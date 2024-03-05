<?php
if (isset($_GET["login"])){

	include('config.php');
	$year = date("m") < 4 ? date("Y") - 1 : date("Y");
	$studentSession = "student_" . $year;
	$sessionStartDigits=fmod($year,100);

	$admno=$_GET["admno"];
	$name=$_GET["name"];
	$class=$_GET["class"];
	$rteValue=$_GET["rteValue"];
	$email_id=$_GET["email_id"];
	$aadhaar=$_GET["aadhaar"];
	$father_name=$_GET["father_name"];
	$mother_name=$_GET["mother_name"];
	$address=$_GET["address"];
	$mobile=$_GET["mobile"];
	$enrolled_in_year=$_GET["enrolled_in_year"];
	$enrolled_out_year=$_GET["enrolled_out_year"];
	if($enrolled_out_year==''){
		$enrolled_out_year=NULL;
	}
	$previous_attended_school=$_GET["previous_attended_school"];
	$notes=$_GET["notes"];
	$dues=$_GET["dues"];
	$transport_route=$_GET["route_id"];
	// $paid_upto=$_GET["paid_upto"];
	$activeValue=$_GET["activeValue"];

	// echo "Enrol",$enrolled_out_year;
	if($rteValue==="YES"){
		$rte=1;
	}else{
		$rte=0;
	}

	if($activeValue==="ACTIVE"){
		$active=1;
	}else{
		$active=0;
	}
	$studentUpdateQuery="INSERT INTO `student_detail`(`admno`, `name`, `email_id`, `aadhaar`, `father_name`, `mother_name`, `address`, `mob1`, `active`, `enrolled_in_date`, ";
	if($enrolled_out_year!=''){
			$studentUpdateQuery.="`enrolled_out_date`,";
			}
	 $studentUpdateQuery.=" `previous_attended_school`, `notes`) VALUES ('$admno','$name','$email_id','$aadhaar','$father_name','$mother_name','$address','$mobile','$active','$enrolled_in_year','$enrolled_out_year', ";
	if($enrolled_out_year!=''){
	 		$studentUpdateQuery.="'$previous_attended_school',";
	 		}
	 		$studentUpdateQuery.=" '$notes') ";

	echo $studentUpdateQuery;

	// echo $studentUpdateQuery;
	echo "NAME: ".$name;
	
	echo "</br>";
	echo "</br>";
	if(mysqli_query($conn,$studentUpdateQuery)){

		echo "UPDATE STUDENT DETAIL";
	}else{
		echo "FAILED STUDENT DETAIL";
	}

	$familyQuery= "update `student_detail` set family_id=id where admno = $admno";

	if(mysqli_query($conn,$familyQuery)){

			echo "UPDATE FAMILY ID DETAIL";
		}else{
			echo "FAILED FAMILY ID DETAIL";
		}

	echo "</br>";
	echo "</br>";
	$studentSessionQuery= "INSERT INTO $studentSession (`admno`, `class`, ";
	if($transport_route!='null'){
			$studentSessionQuery.=" `transport_route`, ";
		}
		$studentSessionQuery.="`dues`, `rte`, `paid_upto`, `amt_paid`, `discount`) VALUES ('$admno','$class',";
		if($transport_route!='null'){
			$studentSessionQuery.="'$transport_route',";
			}
			$studentSessionQuery.="'$dues','$rte','0','0.0','0.0') ";
	// echo $studentSessionQuery;
	if(mysqli_query($conn,$studentSessionQuery)){
		echo "UPDATE STUDENT SESSION DETAIL";
	}else{
		echo "FAILED STUDENT SESSION DETAIL";
	}

		// $studentQuery = "INSERT INTO `student_detail`(`name` ,`aadhaar`, `father_name`, `mother_name`, `address`, `mob1`, `active`, `enrolled_in_year`, `enrolled_out_year`, `previous_attended_school`, `notes`) VALUES ('$name','$aadhaar','$father_name','$mother_name','$address','$mobile','$active','$enrolled_in_year','$enrolled_out_year','$previous_attended_school','$notes') ";
}

?>