<!DOCTYPE html>
<?php session_start(); ?>
<?php if (!isset($_SESSION['admin'])) { header('location: login.php'); } ?>
<?php require_once("../Connection/connection.php"); ?>
<?php require_once("Inactive.php"); ?>
<?php $Users="active"; ?>
<?php
//
// SUPERIOR
	$query_chairperson = "SELECT SD.deptcode, SD.deptname, SD.deptcoll, SD.deptchairman
					FROM srgb.department SD";
	$result_chairperson = pg_query($conn, $query_chairperson) or die(pg_last_error($conn));
	$count_chairperson = pg_num_rows($result_chairperson);

if (isset($_GET['search'])) {
	$condition = "WHERE ev_id LIKE '%".$_GET['search']."%'";
} 

//	DEFAULT QUERY
	$query_default = "SELECT ev_id, ev_pw FROM fes.evaluator ". $retVal = (isset($condition)) ? $condition : ""." ORDER BY ev_id DESC LIMIT 20";

	$result_default = pg_query($conn, $query_default) or die(pg_last_error($conn));
	$count_default = pg_num_rows($result_default);
	if ($count_default < 1) {
		$_SESSION['condition'] = false;
	} else {
		$_SESSION['condition'] = true;
	}
?>
<html>
	<?php require_once("header.php"); ?>
	<body class="container-fluid " style="background-color: #3cb371;">
		<?php require_once("navigation.php"); ?>
		<div class="row" style="margin-top: 40px;    padding-top: 15px;     ">
			<?php require_once("sidebar.php"); ?>
			<div class="col-8 text-left text-center">
				<!-- CONTENT HERE ------------ -->
				
				<!-- ......... -->
				<!-- Users -->
				<?php
				// while ($row = pg_fetch_assoc($result_admin)){
				// echo $row['username'];
				//}
				?>
				<!-- ......... -->
				<table class="table table-light">
					<thead>
						<tr>
							<th colspan="2" scope="col" class="h5" align="left">Faculty Evaluation Users <br><small>( Chairpersons, Faculties and Students )</small></th>
							<th colspan="2" scope="col">
								<form class="form-inline my-2 my-lg-0 text-right text-left" action="users.php" method="get">
									<input class="form-control mr-sm-2" type="search" placeholder="Search for ID" aria-label="Search" name="search">
									<button class="btn btn-outline-success my-2 my-sm-0" type="submit" value="Submit">Search</button>
								</form>
							</th>
						</tr>

						<?php if (isset($_SESSION['condition'])&&$_SESSION['condition']==false) {?>
							<tr>
								<th colspan="4" scope="col" class="h5 alert alert-danger" align="left">
								<p class="alert alert-danger">No data found! Please set the password <a href="http://localhost/FES/" title="" target="_blank">here</a></p>
								</th>
							</tr>
						<?php } ?>
						
					</thead>
					<thead>
						<tr>
							<th scope="col-1">Type</th>
							<th scope="col">Name</th>
							<th scope="col">ID</th>
							<th scope="col">Password</th>
						</tr>
					</thead>
					<tbody>
						<?php
						while ($row_default = pg_fetch_assoc($result_default)) {
										
										$var_find_department_chair = find_department_chair(trim($row_default['ev_id']));
										echo "<tr>";
													echo "<td>".$var_find_department_chair['type']."</td>";
													echo "<td>".$var_find_department_chair['name']."</td>";
													echo "<td>".$row_default['ev_id']."</td>";
													echo "<td>".$row_default['ev_pw']."</td>";
										echo "</tr>";
							}
							function find_department_chair($row_default) {
								global $conn;
										$query_chairperson = "	SELECT SD.deptcode, SD.deptname, SD.deptcoll, SD.deptchairman
															FROM srgb.department SD
															WHERE SD.deptchairman = '".$row_default."'";
										$query_faculty_name = "	SELECT PE.empid, PE.firstname, PE.lastname
															FROM pis.employee PE
															WHERE PE.empid = '".$row_default."'";
										$query_student_name = "	SELECT S.studfirstname, S.studlastname
															FROM srgb.student S
															WHERE S.studid = '" .$row_default."'";
									// For Chairperson
									$result_chairperson = pg_query($conn, $query_chairperson) or die(pg_last_error($conn));
									$count_chairperson = pg_num_rows($result_chairperson);
									// For faculty
									$result_faculty = pg_query($conn, $query_faculty_name) or die(pg_last_error($conn));
									$count_faculty = pg_num_rows($result_faculty);
									// Student
									$result_student = pg_query($conn, $query_student_name) or die(pg_last_error($conn));
									$count_student = pg_num_rows($result_student);
									if ($count_chairperson==1) {
											$query_chairperson_name = "	SELECT PE.empid, PE.firstname, PE.lastname
																FROM pis.employee PE
																WHERE PE.empid = '".$row_default."'";
										$result_chairperson_name = pg_query($conn, $query_chairperson_name) or die(pg_last_error($conn));
										$count_chairperson_name = pg_num_rows($result_chairperson_name);
										$row_name = pg_fetch_assoc($result_chairperson_name);
										$type_and_name['type'] = "<span class=\"badge badge-pill badge-danger\">Superior</span>";
										$type_and_name['name'] = $row_name['firstname']." ".$row_name['lastname'];
										return $type_and_name;
										
									} elseif ($count_faculty==1) {
										$result_faculty_name = pg_query($conn, $query_faculty_name) or die(pg_last_error($conn));
										$count_faculty_name = pg_num_rows($result_faculty_name);
										$row_name = pg_fetch_assoc($result_faculty_name);
										$type_and_name['type'] = "<span class=\"badge badge-pill badge-primary\">Faculty</span>";
										$type_and_name['name'] = $row_name['firstname']." ".$row_name['lastname'];
										return $type_and_name;
									} elseif ($count_student==1) {
										$result_student_name = pg_query($conn, $query_student_name) or die(pg_last_error($conn));
										$count_student_name = pg_num_rows($result_student_name);
										$row_name = pg_fetch_assoc($result_student_name);
										$type_and_name['name'] = ucwords(strtolower($row_name['studfirstname']." ".$row_name['studlastname']));
										$type_and_name['type'] = "<span class=\"badge badge-pill badge-success\">Student</span>";
										return $type_and_name;
									} else {
										return $type_and_name = null;
									}
									
									
							}
						?>
					</tbody>
				</table>



				<!-- END CONTENT HERE ------------ -->
			</div>
			
			<?php require_once("sidebar_left.php"); ?>
		</div>
		<div class="clearfix" style="display: block;content: "";clear: both;"></div>
	</body>
	<?php require_once("footer.php"); ?>