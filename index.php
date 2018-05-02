<!DOCTYPE html>
<?php session_start(); ?>
<?php require_once("Connection/connection.php"); ?>
<?php require_once("form_temp.php"); ?>
<?php 
	$query_present_sy_sem = "SELECT sem, sy FROM srgb.semester ORDER BY sy DESC, sem DESC LIMIT 1";
	$result_present_sy_sem = pg_query($conn, $query_present_sy_sem) or die(pg_last_error($conn));
	$row_present_sy_sem = pg_fetch_assoc($result_present_sy_sem);
	$_SESSION['present_sy'] = trim($row_present_sy_sem['sy'], " ");
	$_SESSION['present_sem'] = trim($row_present_sy_sem['sem'], " ");

 ?>
<html>
<?php require_once("header.php"); ?>
<body>
<div class="container">
<?php 

	if (isset($_POST['pw']) && isset($_SESSION['password'])){
		$ses_pw = (string) trim($_SESSION['password'], " ");
		$pos_pw = (string) $_POST['pw'];

		if ($ses_pw == $pos_pw) {
			$_SESSION['success'] = true;
		} else {
			$_SESSION['error_msg'] = "<div class=\"alert alert-danger\">
  				I'm sorry, Your password doesn't match to ID: <u>". $_SESSION['id'] . "</u>. Please try again.<br>
  				or <a href='logout.php'>Switch ID</a>
				</div>";
		}
		
	//<!-- 2015-0649 -->	
		
	} elseif (isset($_POST['id'])) {
		$id = pg_escape_string ($conn, $_POST['id']);

		$query1 = "	SELECT FS.ev_id, FS.ev_pw
					FROM fes.evaluator FS 
					WHERE FS.ev_id='$id'";
		$query2 = "	SELECT S.studid, S.studfirstname, S.studlastname
					FROM srgb.student S 
					WHERE S.studid='$id'";
		$query3 = "	SELECT PS.firstname, PS.empid, PS.fullname
					FROM pis.employee PS
					WHERE PS.empid='$id'";					
		$result1 = pg_query($conn, $query1) or die(pg_last_error($conn));
		$result2 = pg_query($conn, $query2) or die(pg_last_error($conn));
		$result3 = pg_query($conn, $query3) or die(pg_last_error($conn));
		$count1 = pg_num_rows($result1);
		$count2 = pg_num_rows($result2);
		$count3 = pg_num_rows($result3);

		if ($count1 == 1){
			$row = pg_fetch_assoc($result1);
			$row2 = pg_fetch_assoc($result2);
			$row3 = pg_fetch_assoc($result3);
			
			$retVal = ($count3 == 1) ? ucwords(strtolower($row3['firstname'])) : ucwords(strtolower($row2['studfirstname'])) ;

			$_SESSION['id'] = trim($id);
			$_SESSION['name'] = $retVal;
			$_SESSION['password'] = trim($row['ev_pw'], " ");;
			$_SESSION['error_msg'] = "<div class=\"alert alert-success\">
				  Please enter your password<strong></strong>
				</div>";
		}
		elseif($count2 == 1){
			$row2 = pg_fetch_assoc($result2);
			$_SESSION['id'] = $id;
			$_SESSION['success'] = true;
			header("Location: register_new_pw.php");
			$_SESSION['name'] = ucwords(strtolower($row2['studfirstname']));
		}elseif($count3 == 1){
			$row3 = pg_fetch_assoc($result3);
			$_SESSION['id'] = $id;
			$_SESSION['success'] = true;
			header("Location: register_new_pw.php");
			$_SESSION['name'] = ucwords(strtolower($row3['firstname']));	
		}
		else {

		$_SESSION['error_msg'] = "<div class=\"alert alert-danger\">
  				I'm sorry, Your identification number is invalid. Please check your ID number.
				</div>";
		}
	}
	
	if (isset($_SESSION['success']) && $_SESSION['success']==true) {
		
		form_welcome();

	} elseif (isset($_SESSION['id']) && isset($_SESSION['name']) && isset($_SESSION['password'])){
		$id = $_SESSION['id'];
		form_id_pw();
		 
	} else {
		form_id();
		$_SESSION['error_msg'] = "<div class=\"alert alert-info\" style=\"border:none;\">Please enter your ID</div>";
		
	}
	

 ?>




	<?php 
		// $query1 = "	SELECT DISTINCT(SF.empid), PE.firstname, PE.lastname, SD.deptcoll, SD.deptcode
		// 			FROM srgb.department SD, srgb.faculty SF, pis.employee PE, srgb.semsubject SS
		// 			WHERE SF.empid = PE.empid
		// 			    AND SD.deptcode = 'IT'
		// 			    AND SF.deptcode = SD.deptcode
		// 			    AND PE.empid = SS.facultyid
		// 			    AND SS.sy = '2017-2018'
		// 			    AND SS.sem = '1'"; 




		// $result = pg_query($conn, $query1);
		// if (!$result) {
		//   echo "An error occurred.\n";
		//   exit;
		// }
		?>


</div>

<script>
function Checkbox() {
    var x = document.getElementById("inputSuccess");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>

<script type="text/javascript">
	$(document).ready(function () {
			  $(".navbar-toggle").on("click", function () {
				    $(this).toggleClass("active");
			  });
		});

</script>



<?php require_once("footer.php"); ?>
