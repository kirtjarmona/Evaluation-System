
<?php 



	function form_id()
	{
	global $conn;
	# d-none

	$query_find_sched = "SELECT FS.primary_id, FS.status FROM fes.sched FS WHERE FS.status = 'Stopped'";
				$result_find_sched = pg_query($conn, $query_find_sched);
				$row_find_sched = pg_fetch_assoc($result_find_sched);
				if (trim($row_find_sched['status'])=='Stopped') {
					$check_find_sched = "d-none";
					$close_message = "<div class=\"alert alert-danger\">Evaluation is now Closed.</div>";
				} else {
					$check_find_sched = "";
					$close_message = "";
				}
		 $_SESSION['error_msg'] = "<div class=\"alert alert-info\" style=\"border:none;\">Please enter your ID</div>";
		echo "<div class=\"jumbotron text-center\">
				<h2 class=\"form-signin-heading\">Faculty Evaluation System</h2>
		  		<hr class=\"my-4\">
		  		<p></p>
		       <form class=\"form-signin " . $check_find_sched . "\" method=\"POST\">
		        <div class=\"input-group\">
			  		<!-- <span class=\"input-group-addon\" id=\"basic-addon1\">@</span> -->
					
			  		<input maxlength=\"15\" type=\"text\" name=\"id\" class=\"form-control text-center\" placeholder=\"Identification Number\" required>
			  		<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>
				</div>
		        <p></p>
		        	<button class=\"btn btn-md btn-primary btn-block\" type=\"submit\">Enter</button>
		        	<br>
		        	". $_SESSION['error_msg'] . "
			
		    	</form>" . $close_message . "

		    </div>";


	}

	function form_id_pw()	{
		echo "<div class=\"jumbotron text-center\">
				<h2 class=\"form-signin-heading text-center\">Welcome <strong>" . $_SESSION['name'] . "!</strong></h2>
				<p class=\"lead text-center\"></p>
		  		<hr class=\"my-4\">
		  		<p></p>
		       <form class=\"form-signin has-success has-feedback\" method=\"POST\">
		        <div class=\"input-group\">
			  		<input id=\"inputSuccess\" type=\"password\" name=\"pw\" class=\"form-control text-center\" placeholder=\"Enter your password\" required>
			  		<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>
				</div>
			<br>
					<input type=\"checkbox\" onclick=\"Checkbox()\"> Show Password 

					<br>

		        <p></p>
		        	<button class=\"btn btn-md btn-success btn-block\" type=\"submit\">Login</button>
		    </form>". $_SESSION['error_msg']."
		</div>";
	}


function form_welcome() {
			#unset($_SESSION['success']);
			
			$_SESSION['cancel'] = true;

			navigation();
			echo "<div class=\"jumbotron\">";
			
		  	Evaluator_query();
	
			echo "</div>";

			// footer_nav();
			
	}


function footer_nav(){
	echo '<div class="container-fluid">
		
		<nav class="navbar fixed-bottom navbar-dark bg-dark">
			
				<button type="button" class="btn btn-outline-success"><a href="register_new_pw.php"><i class="fa fa-lock fa-fw"></i>Reset Password</a></button>
				<button type="button" class="btn btn-outline-success"><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i>Sign Out</a></button>
		</nav>
    	  	</div>';
}


?>



<?php  
function department_chairperson(){
	global $conn;

	$query1 =	"SELECT SD.deptcode, SD.deptname, SD.deptcoll, SD.deptchairman 
					FROM srgb.department SD
					WHERE SD.deptchairman = '" . $_SESSION['id'] . "'";
				$result1 = pg_query($conn, $query1);
				$row1 = pg_fetch_assoc($result1);
				return $row1['deptchairman'];
}


function Evaluator_query(){
	global $conn;
		$query1 = "SELECT SSt.studmajor, R.sy, R.sem, SS.section, R.studid, S.studfullname, R.subjcode,
				    SB.subjdesc, SS.facultyid,
				    CONCAT (PS.firstname, ' ' ,PS.lastname) AS Name,
				    SB.subjdept, SD.deptcoll
				FROM srgb.registration R, srgb.student S, srgb.semstudent SSt, srgb.semsubject SS, 
				    pis.employee PS, srgb.subject SB, srgb.department SD 
				WHERE S.studid = '" . $_SESSION['id'] . "'
				    AND R.studid = S.studid
				    AND R.sem = '" . $_SESSION['present_sem'] . "'
				    AND R.sy = '" . $_SESSION['present_sy'] . "'
				    AND R.subjcode = SS.subjcode
				    AND R.section = SS.section
				    AND SS.sem = R.sem
				    AND SS.sy = R.sy
				    AND SS.subjcode = SB.subjcode
				    AND SSt.sy = SS.sy
				    AND SSt.sem = SS.sem
				    AND SSt.studid = S.studid
				    AND SS.facultyid = PS.empid
				    AND SB.subjdept = SD.deptcode
				ORDER BY subjcode";
 
	$query2_A = "SELECT DISTINCT(SF.empid), PE.firstname, PE.lastname, SD.deptcoll, SD.deptcode
				FROM srgb.department SD, srgb.faculty SF, pis.employee PE, srgb.semsubject SS
				WHERE SF.empid = '" . $_SESSION['id'] . "'
					AND SF.empid = PE.empid
					AND SD.deptcode IN (SELECT deptcode FROM srgb.faculty WHERE empid = '" . $_SESSION['id'] . "' LIMIT 1)
				    AND SF.deptcode = SD.deptcode
				    AND PE.empid = SS.facultyid
				    AND SS.sy = '" . $_SESSION['present_sy'] . "'
				    AND SS.sem = '" . $_SESSION['present_sem'] . "'";
	//  -- AND LOWER(SD.deptcode) LIKE LOWER('%".trim($_SESSION['facluty_info']['0']['deptcode'])."%')
	$query2_B = "SELECT DISTINCT(SF.empid), PE.firstname, PE.lastname, SD.deptcoll, SD.deptcode, SS.sy, SS.sem
				FROM srgb.department SD, srgb.faculty SF, pis.employee PE, srgb.semsubject SS
				WHERE SF.empid = PE.empid
				   	AND SD.deptcode IN (SELECT deptcode FROM srgb.faculty WHERE empid = '" . $_SESSION['id'] . "' LIMIT 1)
				    AND SF.deptcode = SD.deptcode
				    AND PE.empid = SS.facultyid
				    AND SS.sy = '" . $_SESSION['present_sy'] . "'
				    AND SS.sem = '" . $_SESSION['present_sem'] . "'";


				$result1 = pg_query($conn, $query1);
				$result2 = pg_query($conn, $query1);
				$result3 = pg_query($conn, $query2_A);
				$result4 = pg_query($conn, $query2_B);
				if (!$result1) {
					  echo "An error occurred.\n";
					  exit;
					} 

				$row1 = pg_fetch_assoc($result1);
				$row3 = pg_fetch_assoc($result3);
				// $institution = ucwords(trim($row1['studmajor']));
				// navigation_content($institution);
			  		if ($row1>1) {

			  			out_all_student_sub($row1,$result2);
			  			$_SESSION['student_info'] = pg_fetch_all(pg_query($conn, $query1));
			  		
			  		}elseif ($row3>1) {
			  			
			  			out_all_faculty_sub($row3,$result4);
			  			$_SESSION['facluty_info'] = pg_fetch_all(pg_query($conn, $query2_B)); ////////////////////////////////////////////////////
			  			
			  			
			  		}else{

			  			echo "<div class=\"alert alert-danger\">I'm sorry your not enrolled in this School Year and Semester</div>";
			  		
			  		}

	
	
			  		// $xxxtrim = trim((string) $result3);
			  		// if ($xxxtrim == 'Resource id #12') {
			  		// 	while ($row = pg_fetch_assoc($result3)) {

						 //  	echo "<p>Evaluate</p>";
						 //  	echo "<p>".ucwords($row['firstname'])."</p>";
						 //  	echo "<p>".ucwords($row['empid'])."</p>";
						 //  	echo "<p>".ucwords(strtolower($row['deptcode']))."</p>";
						  	
			  		// 	}
			  			
			  		// } elseif (is_bool($result3)) {
			  		// 	echo "Yas False";
			  		// } else {
			  			
			  		// }
	// var_dump(pg_fetch_assoc($result3));
}


function out_all_student_sub($row1,$result2) {


			if (isset($row1['studmajor'])) {
				$institution = ucwords(trim($row1['studmajor']));
				echo "<h1 class=\"h4 form-signin-heading alert alert-success\"><strong></strong> " . ucwords(strtolower($row1['studfullname'])) . "</h1>
			  			<small class=\"lead alert alert-info\">". $institution . " Student</small>
			  			<hr class=\"my-4\">
			  			<p></p>";
		 		echo "<table style=\"width:100%\" class=\"table table-striped table-dark\">";
		 		echo "<thead>";
			  	echo "<tr>";
			  	echo "<th class=\"text-left\" width=\"20%\">Faculty Name</th>";
			  	echo "<th class=\"text-center\" width=\"50%\">Subject</th>";
			    echo "<th class=\"text-center\" width=\"30%\">Evaluate</th>";
			    // echo "<th width=\"50%\">Subject Department</th>";
			  	echo "</tr>";
			  	echo "</thead>";
		  		
				while ($row = pg_fetch_assoc($result2)) {	
				  	echo "<tr>";
				  	echo "<td align=\"left\">".ucwords(strtolower($row['name']))."</td>";
				  	echo "<td align=\"center\">".ucwords($row['subjcode'])."</td>";
				  	echo "<td align=\"center\"><button type=\"button\" class=\"btn btn-success\" onclick=\"window.location.href='evaluate.php?id=" . urlencode(trim($row['facultyid'])) . "&subjcode=" . urlencode(trim($row['subjcode'])). "&sy=" . urlencode(trim($row['sy'])). "&sem=" . urlencode(trim($row['sem']))."&EvaluateID=".trim($_SESSION['id'])."-". urlencode(trim($row['facultyid'])) ."'\">Evaluate</button></td>";
				  	// echo "<td align=\"center\">".$row['subjdept']."</td>"; 
					echo "</tr>";
				 }
					echo "</table>";
			}

}

function out_all_faculty_sub($row3,$result4) {


			if (isset($row3['deptcode'])) {
				$department = ucwords(trim($row3['deptcode']));
				$facultyid = trim($row3['empid']);

					if ($facultyid == department_chairperson()) {
						$type = "Chairperson";
					} else {
						$type = " Faculty";
					}

				
				echo "<h1 class=\"h4 form-signin-heading alert alert-success\"><strong></strong> " . ucwords(strtolower($row3['firstname'])) ." ". ucwords(strtolower($row3['lastname'])). "</h1>
			  			<small class=\"lead alert alert-info\">". $department ." ". $type . "</small>
			  			<hr class=\"my-4\">
			  			<p></p>";
		 		echo "<table style=\"width:100%\" class=\"table table-striped table-dark\">";
		 		echo "<thead class=\"thead-dark\">";
			  	echo "<tr>";
			  	echo "<th scope=\"col\" width=\"70%\" class=\"text-left\">Faculty Name</th>";
			  	// echo "<th width=\"50%\">Faculty ID</th>";
			    echo "<th width=\"30%\">Evaluate</th>";
			  	echo "</tr>";
			  	echo "</thead>";
		  		
				while ($row = pg_fetch_assoc($result4)) {	

					if (trim($row['empid']) == trim($facultyid)) {
						$button_evaluate = "Self Evaluate";
						$button_evaluate_color = "";
					} else {
						$button_evaluate = "Evaluate";
					}

					$_SESSION['sy']=$row['sy'];
					$_SESSION['sem']=$row['sem'];

				  	echo "<tr>";
				  	echo "<td class=\"text-left\">".ucwords(strtolower($row['firstname']))." ".ucwords(strtolower($row['lastname']))."</td>";
				  	// echo "<td align=\"center\">".$row['empid']."</td>";
				  	 echo "<td class=\"text-left\"><button type=\"button\" class=\"btn btn-outline-success\" onclick=\"window.location.href='evaluate.php?id=" . trim($row['empid']) . "&EvaluateID=" . trim($_SESSION['id'])."-". trim($row['empid']) . "'\">".$button_evaluate."</button></td>";
				  	// echo "<td class=\"text-left\"><a href=\"#\" title=\"\" class=\" btn btn-success\" type=\"button\">Evaluate</a></td>";
				  	 
					echo "</tr>";
				 }
					echo "</table>";
			}

}
function navigation(){

			$nav = (isset($_SESSION['cancel'])) ? require_once("navigation.php") : "LoL";
		return $nav;
}
function navigation_content(){

	global $conn;
	$query_student = "SELECT SSt.studmajor, R.sy, R.sem, SS.section, R.studid, S.studfullname, R.subjcode,
				    SB.subjdesc, SS.facultyid,
				    CONCAT (PS.firstname, ' ' ,PS.lastname) AS Name,
				    SB.subjdept, SD.deptcoll
				FROM srgb.registration R, srgb.student S, srgb.semstudent SSt, srgb.semsubject SS, 
				    pis.employee PS, srgb.subject SB, srgb.department SD 
				WHERE S.studid = '" . $_SESSION['id'] . "'
				    AND R.studid = S.studid
				    AND R.sem = '" . $_SESSION['present_sem'] . "'
				    AND R.sy = '" . $_SESSION['present_sy'] . "'
				    AND R.subjcode = SS.subjcode
				    AND R.section = SS.section
				    AND SS.sem = R.sem
				    AND SS.sy = R.sy
				    AND SS.subjcode = SB.subjcode
				    AND SSt.sy = SS.sy
				    AND SSt.sem = SS.sem
				    AND SSt.studid = S.studid
				    AND SS.facultyid = PS.empid
				    AND SB.subjdept = SD.deptcode
				ORDER BY subjcode";
				$result_S = pg_query($conn, $query_student);
				$row_S = pg_fetch_assoc($result_S);
				$type_S = trim($row_S['studid']);
	$query_chairperson = "SELECT SD.deptcode, SD.deptname, SD.deptcoll, SD.deptchairman 
					FROM srgb.department SD
					WHERE SD.deptchairman = '" . $_SESSION['id'] . "'";
				$result_C = pg_query($conn, $query_chairperson);
				$row_C = pg_fetch_assoc($result_C);
				$type_C = trim($row_C['deptchairman']);
	$query_faculty = "SELECT DISTINCT(SF.empid), PE.firstname, PE.lastname, SD.deptcoll, SD.deptcode
				FROM srgb.department SD, srgb.faculty SF, pis.employee PE, srgb.semsubject SS
				WHERE SF.empid = '" . $_SESSION['id'] . "'
					AND SF.empid = PE.empid
				    AND SD.deptcode IN (SELECT deptcode FROM srgb.faculty WHERE empid = '" . $_SESSION['id'] . "' LIMIT 1)
				    AND SF.deptcode = SD.deptcode
				    AND PE.empid = SS.facultyid
				    AND SS.sy = '" . $_SESSION['present_sy'] . "'
				    AND SS.sem = '" . $_SESSION['present_sem'] . "'";
				$result_F = pg_query($conn, $query_faculty);
				$row_F = pg_fetch_assoc($result_F);
				$type_F = trim($row_F['empid']);

				if ($type_S) {
					echo "Student";
					$_SESSION['evaluator_type'] = "Student";
				}elseif ($type_C) {
					echo "Superior";
					$_SESSION['evaluator_type'] = "Superior";
				}elseif ($type_F) {
					echo "Peer";
					$_SESSION['evaluator_type'] = "Peer";
				}


	// $institution = trim($row1['studmajor']);

	//      if (isset($institution)) {
 //            if ($institution == 'ACT'|| $institution == 'ACT-SULOP'|| $institution == 'BIT'|| $institution == 'BSAE'|| $institution == 'BSIT'|| $institution == 'DIT') {
 //              echo "ICET";
 //            } elseif ($institution == 'BSA-A'|| $institution == 'BSA-H'|| $institution == 'BSAB'|| $institution == 'BSAF'|| $institution == 'DAT'|| $institution == 'DAT-1'|| $institution == 'DAT-KA'|| $institution == 'DAT-KAPATAGN') {
 //              echo "IABARS";
 //            } elseif ($institution == 'BSAT'|| $institution == 'BSDC'|| $institution == 'BSED-BIO'|| $institution == 'BSED-MATH'|| $institution == 'BSED-TLE'|| $institution == 'BPA'|| $institution == 'BPA-SULOP'|| $institution == 'MABM'|| $institution == 'MAED'|| $institution == 'MAED-ECE'|| $institution == 'MAED-EDAD'|| $institution == 'MAED-EM'|| $institution == 'MAED-LT'|| $institution == 'MAED-MT'|| $institution == 'MAED-ST'|| $institution == 'MBA'|| $institution == 'MED-ECE'|| $institution == 'MIT'|| $institution == 'MPA'|| $institution == 'MSA'|| $institution == 'MSE-LWRET'|| $institution == 'MSERM'|| $institution == 'PHD'|| $institution == 'PSED'|| $institution == 'TCP') {
 //              echo "IEGS";
 //            }
 //          } else {
 //          	echo "Undefined";
 //          }
}




?>