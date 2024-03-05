<!DOCTYPE html>
<html>
	<head>
		<title></title>
	<script type="text/javascript" src="add_Student.js"></script>
</head>
	<body id="tb1">
		<form action="UPDATE_STUDENT_DETAIL.php" method="get" id="final0">
			<fieldset>
			<legend>STUDENT DETAIL</legend>
<?php
$admno = $_GET["admno"];
include('config.php');
$year = date("m") < 4 ? date("Y") - 1 : date("Y");
$studentSession = "student_" . $year;
$sessionStartDigits=fmod($year,100);
$studentQuery = " select sd.name,st.class,st.rte,sd.email_id,sd.aadhaar,sd.father_name,sd.mother_name,sd.address,
sd.mob1,sd.enrolled_in_date,sd.enrolled_out_date,sd.previous_attended_school,sd.notes,st.dues,st.paid_upto,
sd.active,sd.religion,sd.dob from  student_detail sd left join $studentSession st on st.admno = sd.admno where
    sd.admno= '$admno' ";
$student_detail = mysqli_query($conn, $studentQuery);

$studentFamilyQuery = " select st.admno from student_detail sd left join $studentSession st on st.admno = sd.admno where
    sd.family_id in ( select family_id from student_detail sd where sd.admno='$admno' ) ";
    // echo $studentFamilyQuery;
$student_family_detail = mysqli_query($conn, $studentFamilyQuery);


while ($each = mysqli_fetch_array($student_detail)) {

$name=$each[0];
$class=$each[1];
$rte=$each[2];
$email_id=$each[3];
$aadhaar=$each[4];
$father_name=$each[5];
$mother_name=$each[6];
$address=$each[7];
$mobile=$each[8];
$enrolled_in_year=$each[9];
$enrolled_out_year=$each[10];
$previous_attended_school=$each[11];
$notes=$each[12];
$dues=$each[13];
$paid_upto=$each[14];
$active=$each[15];
$religion=$each[16];
$dob=$each[17];
echo "ADMNO: ".$admno;
if($rte==1){
	$rteValue="YES";
}else{
	$rteValue="NO";
}

if($active==1){
	$activeValue="ACTIVE";
}else{
	$activeValue="IN-ACTIVE";
}


$allMonths = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ];
if($paid_upto>0){
	$paidUptoValue=$allMonths[$paid_upto-1];
}else{
	$paidUptoValue=null;
}

$allAdmno="";
$size=$row_cnt = mysqli_num_rows($student_family_detail); 
$index=1;
while ($eachStudent = mysqli_fetch_array($student_family_detail)) {
	if($index<$size){
		$allAdmno=$allAdmno."".$eachStudent[0].",";
	}else{
		$allAdmno=$allAdmno."".$eachStudent[0];
	}
	$index++;
}


}


?>
<center>
<input type = "hidden" name="admno" value = "<?php echo $admno; ?>" size="40"/>
<table  cellpadding="0" cellspacing="0" align="center" width="100%" border="0">
	<tbody>
		<tr>
			<th><p>NAME</p></th>
			<th><p>CLASS</p></th>
			<th><p>RTE </p></th>
			<th><p>EMAIL ID </p></th>
			
		</tr>
		<tr>
			<th><input type = "text" name="name" value = "<?php echo $name; ?>" size="40"/></th>
			<th><input type = "text" name="class" value = "<?php echo $class; ?>" size="20" readonly></th>
			<th><input type = "text" name="rteValue" value = "<?php echo $rteValue; ?>" size="20"/></th>
			<th><input type = "text" name="email_id" value = "<?php echo $email_id; ?>" size="40" readonly ></th>
		</tr>
		<tr>
		    <td>
		        &nbsp;
		        <!--you just need a space in a row-->
		    </td>
		</tr>
		<tr>
			<th><p>AADHAAR</p></th>
			<th><p>FATHER NAME</p></th>
			<th><p>MOTHER NAME </p></th>
			<th><p>ADDRESS </p></th>
			
		</tr>
		<tr>
			<th><input type = "number" name="aadhaar" value = "<?php echo $aadhaar; ?>" size="16"/></th>
			<th><input type = "text" name="father_name" value = "<?php echo $father_name; ?>" size="30"/></th>
			<th><input type = "text" name="mother_name" value = "<?php echo $mother_name; ?>" size="30"/></th>
			<th><input type = "text" name="address" value = "<?php echo $address; ?>" size="40"  /></th>
		</tr>
		<tr>
		    <td>
		        &nbsp;
		        <!--you just need a space in a row-->
		    </td>
		</tr>
		<tr>
			<th><p>MOBILE NUMBER</p></th>
			<th><p>ENROLLED IN DATE (DD/MM/YYYY)</p></th>
			<th><p>ENROLLED OUT DATE (DD/MM/YYYY)</p></th>
			<th><p>PREVIOUS ATTENDED SCHOOL </p></th>
			
		</tr>
		<tr>
			<th><input type = "number" name="mobile" value = "<?php echo $mobile; ?>" size="10"/></th>
			<th><input type = "text" name="enrolled_in_year" value = "<?php echo $enrolled_in_year; ?>" size="10"/></th>
			<th><input type = "text" name="enrolled_out_year" value = "<?php echo $enrolled_out_year; ?>" size="10"/></th>
			<th><input type = "text" name="previous_attended_school" value = "<?php echo $previous_attended_school; ?>" size="60"  /></th>
		</tr>
		<tr>
		    <td>
		        &nbsp;
		        <!--you just need a space in a row-->
		    </td>
		</tr>
		<tr>
			<th><p>NOTES</p></th>
			<th><p>DUES (IN RUPEE)</p></th>
			<th><p>FEE PAID UPTO </p></th>
			<th><p>CURRENT STATUS </p></th>
			
		</tr>
		<tr>
			<th><input type = "text" name="notes" value = "<?php echo $notes; ?>" size="40"/></th>
			<th><input type = "number" name="dues" value = "<?php echo $dues; ?>" size="10"/></th>
			<th><input type = "text" name="paidUptoValue" value = "<?php echo $paidUptoValue; ?>" size="20" readonly></th>
			<th><input type = "text" name="activeValue" value = "<?php echo $activeValue; ?>" size="20"  /></th>
		</tr>
		<tr>
		    <td>
		        &nbsp;
		        <!--you just need a space in a row-->
		    </td>
		</tr>
		<tr>
			<th><p>FAMILY ADMNO'S </p></th>
			<th><p>RELIGION </p></th>
			<th><p>DATE OF BIRTH (DD/MM/YYYY) </p></th>
		</tr>
		<tr>
			<th><input type = "text" name="allAdmno" value = "<?php echo $allAdmno; ?>" size="40"/></th>
			<th><input type = "text" name="religion" value = "<?php echo $religion; ?>" size="40"/></th>
			<th><input type = "text" name="dob" value = "<?php echo $dob; ?>" size="40"/></th>

		</tr>
	</tbody>
	</table>
	<br/>
	<br/>

	UPDATE DETAILS:
	<input type = "submit" name = "login" id = "login" value = "UPDATE" /></center>
</fieldset>
</form>
</body>
</html>












