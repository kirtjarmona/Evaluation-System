<!DOCTYPE html>
<?php session_start(); ?>
<?php if (!isset($_SESSION['admin'])) { header('location: login.php'); } ?>
<?php require_once("../Connection/connection.php"); ?>
<?php require_once("Inactive.php"); ?>
<?php $Faculty_info="active"; ?>
<?php
// WHAT SUBJECT THEY HAVE
// 
$subjcode_subject_faculty = (isset($_GET['id'])) ? $_GET['id'] : "" ;

$query_subject_faculty = "SELECT PE.empid, PE.firstname, PE.lastname, SS.subjcode, SS.section, SB.subjdesc, SS.facultyid, SD.deptcode, SD.deptchairman
FROM pis.employee PE, srgb.semsubject SS, srgb.subject SB, srgb.department SD
WHERE SS.facultyid = '".$subjcode_subject_faculty."'
AND SS.facultyid = PE.empid
AND SS.sy = '".$_SESSION['sy']."'
AND SS.sem = '".$_SESSION['sem']."'
AND SS.subjcode = SB.subjcode
AND SB.subjdept = SD.deptcode";
$result_subject_faculty = pg_query($conn, $query_subject_faculty) or die(pg_last_error($conn));
$count_subject_faculty = pg_num_rows($result_subject_faculty);
# DEPT FaCULTY
#
$deptcode_dept_faculty = (isset($_GET['department'])) ? $_GET['department'] : "" ;
#
$query_dept_faculty = "SELECT DISTINCT(FF.empid), PE.firstname, PE.lastname, SD.deptcoll, SD.deptcode
FROM srgb.department SD, fes.faculty FF, pis.employee PE, srgb.semsubject SS
WHERE FF.empid = PE.empid
AND FF.deptcode = '".$deptcode_dept_faculty."'
AND FF.deptcode = SD.deptcode
AND PE.empid = SS.facultyid
AND SS.sy = '".$_SESSION['sy']."'
AND SS.sem = '".$_SESSION['sem']."'
ORDER BY PE.lastname ASC";
# . $retVal = (isset($_GET['department'])) ? $_GET['department'] :"";."'
#echo $query_dept_faculty;
$result_dept_faculty = pg_query($conn, $query_dept_faculty) or die(pg_last_error($conn));
$count_dept_faculty = pg_num_rows($result_dept_faculty);
// COLLECGES
$query_ins_dept = "SELECT deptcoll, deptcode, deptname, deptchairman FROM srgb.department ". $retVal = (isset($_GET['college'])) ? "WHERE deptcoll = '" . $_GET['college'] ."'": "" . " ORDER BY deptcoll, deptcode ASC";
$result_ins_dept = pg_query($conn, $query_ins_dept) or die(pg_last_error($conn));
$count_ins_dept = pg_num_rows($result_ins_dept);
?>
<html>
	<?php require_once("header.php"); ?>
	<body class="container-fluid " style="background-color: #3cb371;">
		<?php require_once("navigation.php"); ?>
		<div class="row" style="margin-top: 40px;    padding-top: 15px;">
			<?php require_once("sidebar.php"); ?>
			<div class="col-8 text-left text-center">
				<!-- ------------ CONTENT HERE  -->
				<div class="jumbotron">
					<p>Institute of:</p>
					<a class="btn btn btn-<?php  echo $retVal = (isset($_GET['college']) && $_GET['college']=='IABARS') ? '' : 'outline-' ;?>success btn-md" href="faculty_info.php?college=IABARS" role="button">IABARS</a>
					<a class="btn btn btn-<?php  echo $retVal = (isset($_GET['college']) && $_GET['college']=='ICET') ? '' : 'outline-' ;?>success btn-md" href="faculty_info.php?college=ICET" role="button">ICET</a>
					<a class="btn btn btn-<?php  echo $retVal = (isset($_GET['college']) && $_GET['college']=='IEGS') ? '' : 'outline-' ;?>success btn-md" href="faculty_info.php?college=IEGS" role="button">IEGS</a>
					<hr class="my-4">
					<div class="row">
						<?php if (isset($_GET['college'])): ?>
						<div class="col-3 text-right" style="border-right: 1px solid #959595;">
						<h6 class="text-center">Department</h6>	
							<?php while ($row_ins_dept = pg_fetch_assoc($result_ins_dept)) {
									echo "<a class=\"text-right btn btn-block btn-sm btn-".$retVal_department = (isset($_GET['department']) && $_GET['department']==trim($row_ins_dept['deptcode'])) ? "" : "outline-";
										echo "success my-2 my-sm-0 my-sm-1 pr-sm-0\" href=\"faculty_info.php?college=" . trim($row_ins_dept['deptcoll']) . "&department=" . trim($row_ins_dept['deptcode']) . "\">".
											ucwords(strtolower($row_ins_dept['deptname'])).
									"<i class=\"fa fa-angle-right fa-fw\"></i></a>";
							}
							?>
						</div>
						<?php endif ?>
						<!-- ---- -->
						<?php if (isset($_GET['department'])): ?>
						<div class="col-4 text-right" style="border-right: 1px solid #959595;">
						<h6 class="text-center">Faculty</h6>
							<?php while ($row_dept_faculty = pg_fetch_assoc($result_dept_faculty)) {
										echo "<a class=\"text-right btn btn-block btn-sm btn-".$retVal_id = (isset($_GET['id']) && $_GET['id']==trim($row_dept_faculty['empid'])) ? "" : "outline-";
											echo "success my-2 my-sm-0 my-sm-1 pr-sm-0\" href=\"faculty_info.php?college=" . trim($row_dept_faculty['deptcoll']) . "&department=" . trim($row_dept_faculty['deptcode']) . "&id=" . trim($row_dept_faculty['empid']). "&fullname=" . ucwords(strtolower($row_dept_faculty['firstname']. " " . $row_dept_faculty['lastname'])) . "\">"
										.ucwords(strtolower($row_dept_faculty['firstname']. " " . $row_dept_faculty['lastname']))." <i class=\"fa fa-angle-right fa-fw\"></i></a>";
								}
							?>
						</div>
						<?php endif ?>

						<?php if (isset($_GET['department'])): ?>
						<div class="col-4 text-center" style="border-right: 1px solid #959595;">
						<h6>Subject handled</h6>
							<?php while ($row_subject_faculty = pg_fetch_assoc($result_subject_faculty)) {
										echo "<a class=\"text-center btn btn-sm btn-".$retVal_id = (isset($_GET['id']) && $_GET['id']==trim($row_subject_faculty['empid'])) ? "" : "outline-";
											echo "success my-0 my-sm-2 mr-sm-1 pr-sm-2\" href=\"result.php?college=".trim($_GET['college']) . "&department=" . trim($_GET['department']) . "&id=" . trim($_GET['id']). "&fullname=" . $_GET['fullname']. "&type=Student\">"
										.ucwords(trim($row_subject_faculty['subjcode']))." | ".ucwords(trim($row_subject_faculty['section']))."</a>";
										#." <i class=\"fa fa-angle-right fa-fw\"></i>
										
								}
								
							?>
						<hr class="my-4">
						<small>Click to see Result</small>
						
						</div>
						<?php endif ?>
						
					</div>
					<!-- <p></p> -->
					
					
					
					
				</div>
				
				<!-- ------------END CONTENT HERE  -->
			</div>
			<?php require_once("sidebar_left.php"); ?>
		</div>
		<div class="clearfix" style="display: block;content: "";clear: both;"></div>
	</body>
	<?php require_once("footer.php"); ?>