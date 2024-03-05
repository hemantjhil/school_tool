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
	$previous_attended_school=$_GET["previous_attended_school"];
	$notes=$_GET["notes"];
	$dues=$_GET["dues"];
	$allAdmno=$_GET["allAdmno"];
	$religion=$_GET["religion"];
	$dob=$_GET["dob"];

	// $paid_upto=$_GET["paid_upto"];
	$activeValue=$_GET["activeValue"];

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

	$familyIdQuery = mysqli_query(
            $conn,
            "select family_id from student_detail where admno=$admno"
        );
        //$re=$conn->query("$class");
        $familyIdFetch = $familyIdQuery->fetch_assoc();
        $family_id = $familyIdFetch["family_id"];

     $admnoListWithBracket="(".$allAdmno.")";
     echo $admnoListWithBracket;

	$studentUpdateQuery="UPDATE `student_detail` SET `name`='$name',`aadhaar`='$aadhaar',`father_name`='$father_name',
	`mother_name`='$mother_name',`address`='$address',`mob1`='$mobile',`active`='$active',`enrolled_in_date`=
	'$enrolled_in_year',`enrolled_out_date`='$enrolled_out_year',`previous_attended_school`='$previous_attended_school',
	`notes`='$notes',`religion`='$religion',`dob`='$dob' WHERE admno = '$admno' ";
	// echo $studentUpdateQuery;
	echo "NAME: ".$name;

	echo "</br>";
	echo "</br>";
	if(mysqli_query($conn,$studentUpdateQuery)){

		echo "UPDATED STUDENT DETAIL";
	}else{
		echo "FAILED STUDENT DETAIL";
	}
	echo "</br>";
	echo "</br>";
	$studentSessionQuery= "UPDATE $studentSession SET `dues`='$dues',`rte`='$rte' WHERE admno='$admno' ";
	// echo $studentSessionQuery;
	if(mysqli_query($conn,$studentSessionQuery)){
		echo "UPDATED STUDENT SESSION DETAIL";
	}else{
		echo "FAILED STUDENT SESSION DETAIL";
	}
    echo $admnoListWithBracket;
	$studentFamilyUpdateQuery="update student_detail set family_id='$family_id' where admno in $admnoListWithBracket ";
	// echo $studentFamilyUpdateQuery;
	if(mysqli_query($conn,$studentFamilyUpdateQuery)){

		echo "UPDATED STUDENT FAMILY DETAIL";
	}else{
		echo "FAILED STUDENT FAMILY DETAIL";
	}

		// $studentQuery = "INSERT INTO `student_detail`(`name` ,`aadhaar`, `father_name`, `mother_name`, `address`, `mob1`, `active`, `enrolled_in_year`, `enrolled_out_year`, `previous_attended_school`, `notes`) VALUES ('$name','$aadhaar','$father_name','$mother_name','$address','$mobile','$active','$enrolled_in_year','$enrolled_out_year','$previous_attended_school','$notes') ";
}

?>