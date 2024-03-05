<?php
include('config.php');
$conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
$studentQuery = " select admno,name FROM student_detail  ";
    // echo "</br>";
    // echo $studentQuery;
    // echo "</br>";
$allStudentList = mysqli_query($conn, $studentQuery);
$count=0;
while ($eachStudent = mysqli_fetch_array($allStudentList)) {
		$name = $eachStudent[1];
		$admno = $eachStudent[0];
		$nameArray = explode(" ",$name);
		$firstName = strtolower(reset($nameArray));
		$email=$firstName.".".$admno."@mpsvns.in";
		// echo "email".$email."admno".$admno;
		$updateQuery = " update student_detail set email_id = '$email' where admno='$admno' ";
		if(mysqli_query($conn,$updateQuery)){
			$count++;
		}
		echo $email;
		echo "</br>";
	}
echo $count++;
	?>