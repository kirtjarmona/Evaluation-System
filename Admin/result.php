<!DOCTYPE html>
<?php session_start(); ?>
<?php if (!isset($_SESSION['admin'])) { header('location: login.php'); } ?>
<?php require_once("../Connection/connection.php"); ?>
<?php require_once("Inactive.php"); ?>
<?php $Result="active"; ?>
<!-- ---------- -->
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
$result_dept_faculty_2 = pg_query($conn, $query_dept_faculty) or die(pg_last_error($conn));
$count_dept_faculty = pg_num_rows($result_dept_faculty);
// COLLECGES
$query_ins_dept = "SELECT deptcoll, deptcode, deptname, deptchairman
					FROM srgb.department ". $retVal = (isset($_GET['college'])) ? "WHERE deptcoll = '" . $_GET['college'] ."'": "" . " ORDER BY deptcoll, deptcode ASC";
$result_ins_dept = pg_query($conn, $query_ins_dept) or die(pg_last_error($conn));
$count_ins_dept = pg_num_rows($result_ins_dept);
$query_ratings_result = "SELECT COUNT(faculty_id) AS FF, SUM(total_form1), SUM(total_form2),SUM(total_form3),SUM(total_form4),evaluator_type
						FROM fes.ratings
						WHERE sem = '".$_SESSION['sem']."'
						AND sy = '".$_SESSION['sy']."'
						AND faculty_id = '".$_GET['id']."'
						GROUP BY evaluator_type
						ORDER BY FF DESC";
$result_ratings_result = pg_query($conn, $query_ratings_result) or die(pg_last_error($conn));
$count_ratings_result = pg_num_rows($result_ratings_result);
?>
<?php function get_total_score($id_target){
	global $conn;
	$query_ratings_result_2 = "SELECT COUNT(faculty_id) AS FF, SUM(total_form1)+SUM(total_form2)+SUM(total_form3)+SUM(total_form4),evaluator_type
							FROM fes.ratings
							WHERE sem = '2'
							AND sy = '2017-2018'
							AND faculty_id = '".$id_target."'
							GROUP BY evaluator_type
							ORDER BY evaluator_type DESC";
	$query_superior = "SELECT deptchairman FROM srgb.department
										WHERE deptchairman = '".$id_target."'";
		$result_ratings_result_X_2 = pg_query($conn, $query_ratings_result_2) or die(pg_last_error($conn));
		$result_superior = pg_query($conn, $query_superior) or die(pg_last_error($conn));
		$row_superior = pg_fetch_array($result_superior);
							while ($row_ratings_result = pg_fetch_array($result_ratings_result_X_2)) {
								if (trim($row_ratings_result[2])=='Student') {
									$Student_RR = ($row_ratings_result[1]/$row_ratings_result[0])*.30;
								} elseif (trim($row_ratings_result[2])=='Peer') {
									$Peer_RR = ($row_ratings_result[1]/$row_ratings_result[0])*.20;
								}elseif (trim($row_ratings_result[2])=='Superior') {
									$Superior_RR = ($row_ratings_result[1]/$row_ratings_result[0])*.30;
								}elseif (trim($row_ratings_result[2])=='Self') {
									$Self_RR = ($row_ratings_result[1]/$row_ratings_result[0])*.20;
								}
								}
		
		if (isset($row_superior[0])) {
			$Total_SCORE = ($Student_RR+$Peer_RR+$Superior_RR+$Self_RR);
			return $Total_SCORE+=30;
		} else {
			return $Total_SCORE = ($Student_RR+$Peer_RR+$Superior_RR+$Self_RR);
		}
} ?>
<!-- ---------- -->
<html>
	<?php require_once("header.php"); ?>
	<body class="container-fluid " style="background-color: #3cb371;">
		<?php require_once("navigation.php"); ?>
		<div class="row" style="margin-top: 40px;    padding-top: 15px;">
			<?php require_once("sidebar.php"); ?>
			<div class="col-8 text-left text-center">
				<!-- ------------ CONTENT HERE  -->
				<div class="jumbotron" style="padding-top: 1em;">
					<div class="text-left">
						<a class="btn btn btn-<?php  echo $retVal = (isset($_GET['college']) && $_GET['college']=='IABARS') ? '' : 'outline-' ;?>primary btn-md" href="result.php?college=IABARS" role="button">IABARS</a>
						<a class="btn btn btn-<?php  echo $retVal = (isset($_GET['college']) && $_GET['college']=='ICET') ? '' : 'outline-' ;?>primary btn-md" href="result.php?college=ICET" role="button">ICET</a>
						<a class="btn btn btn-<?php  echo $retVal = (isset($_GET['college']) && $_GET['college']=='IEGS') ? '' : 'outline-' ;?>primary btn-md" href="result.php?college=IEGS" role="button">IEGS</a>
					</div>
					
					<hr class="my-4">
					<div class="row">
						<?php if (isset($_GET['college'])): ?>
						<div class="col-3 text-right" style="border-right: 1px solid #959595;">
							<h6 class="text-center">Department</h6>
							<?php while ($row_ins_dept = pg_fetch_assoc($result_ins_dept)) {
									echo "<a class=\"text-right btn btn-block btn-sm btn-".$retVal_department = (isset($_GET['department']) && $_GET['department']==trim($row_ins_dept['deptcode'])) ? "" : "outline-";
															echo "primary my-2 my-sm-0 my-sm-1 pr-sm-0\" href=\"result.php?college=" . trim($row_ins_dept['deptcoll']) . "&department=" . trim($row_ins_dept['deptcode']) . "\">".
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
																echo "primary my-2 my-sm-0 my-sm-1 pr-sm-0\" href=\"result.php?college=" . trim($row_dept_faculty['deptcoll']) . "&department=" . trim($row_dept_faculty['deptcode']) . "&id=" . trim($row_dept_faculty['empid']) ."&type=Student"."&fullname=".ucwords(strtolower($row_dept_faculty['firstname']. " " . $row_dept_faculty['lastname']))."\">"
										.ucwords(strtolower($row_dept_faculty['firstname']. " " . $row_dept_faculty['lastname']))." <i class=\"fa fa-angle-right fa-fw\"></i></a>";
										// ------------
										
										// ------------
								}
							?>
						</div>
						<?php endif ?>
						<!-- ------------------ -->
						<?php if (!isset($_GET['type'])) { ?>
						<div class="col-5 text-center" style="border-right: 1px solid #959595;">
							<?php $_SESSION['Dept_Id'] = array(); ?>
							<?php while ($row_dept_faculty_id = pg_fetch_array($result_dept_faculty_2)) { ?>
							
							<?php
							#['Shanghai', 24.2]
							$cell = "['".$row_dept_faculty_id[2].", ".$row_dept_faculty_id[1][0]."', ".get_total_score($row_dept_faculty_id[0])."]";
							
							?>
							<?php array_push($_SESSION['Dept_Id'], $cell); ?>
							
							
							<?php } ?>
							
							<div id="container_2" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
						</div>
						<?php } ?>
						<!-- ------------------ -->
						
						<?php if (isset($_GET['department']) && isset($_GET['type'])): ?>
						<div class="col-5 text-center" style="border-right: 1px solid #959595;">
							<h6>Ratings</h6>
							
							<?php while ($row_ratings_result = pg_fetch_array($result_ratings_result)) { ?>
							<a class="text-center btn btn-sm btn-<?php echo $retVal_id = (isset($_GET['type']) && $_GET['type']==trim($row_ratings_result['5'])) ? "" : "outline-"; ?>primary my-0 my-sm-2 mr-sm-1 pr-sm-2"
								href="result.php?college=<?php echo trim($_GET['college']) . "&department=" . trim($_GET['department']) . "&id=" . trim($_GET['id']). "&type=" . ucwords(trim($row_ratings_result['5'])). "&fullname=" . $_GET['fullname']; ?>">
								<?php echo ucwords(trim($row_ratings_result[5])); ?>
							</a>
							<?php
								
								if ($_GET['type']=="Student" && trim($row_ratings_result[5])=="Student") {
									$result_form1 = $row_ratings_result[1]/$row_ratings_result[0];
									$result_form2 = $row_ratings_result[2]/$row_ratings_result[0];
									$result_form3 = $row_ratings_result[3]/$row_ratings_result[0];
									$result_form4 = $row_ratings_result[4]/$row_ratings_result[0];
									
								}
								if ($_GET['type']=="Superior" && trim($row_ratings_result[5])=="Superior") {
									$result_form1 = $row_ratings_result[1]/$row_ratings_result[0];
									$result_form2 = $row_ratings_result[2]/$row_ratings_result[0];
									$result_form3 = $row_ratings_result[3]/$row_ratings_result[0];
									$result_form4 = $row_ratings_result[4]/$row_ratings_result[0];
								}
								if ($_GET['type']=="Peer" && trim($row_ratings_result[5])=="Peer") {
									$result_form1 = $row_ratings_result[1]/$row_ratings_result[0];
									$result_form2 = $row_ratings_result[2]/$row_ratings_result[0];
									$result_form3 = $row_ratings_result[3]/$row_ratings_result[0];
									$result_form4 = $row_ratings_result[4]/$row_ratings_result[0];
								}
								if ($_GET['type']=="Self" && trim($row_ratings_result[5])=="Self") {
									$result_form1 = $row_ratings_result[1]/$row_ratings_result[0];
									$result_form2 = $row_ratings_result[2]/$row_ratings_result[0];
									$result_form3 = $row_ratings_result[3]/$row_ratings_result[0];
									$result_form4 = $row_ratings_result[4]/$row_ratings_result[0];
								}
							?>
							<?php } ?>
							<?php if (isset($_GET['type'])) { ?>
							<hr class="my-4">
							<div id="container" style="min-width: 310px; max-width: 800px; height: 200px; margin: 0 auto"></div>
							<script type="text/javascript">
											Highcharts.chart('container', {
										    chart: {
										        type: 'column'
										    },
										    title: {
										        text: null
										    },
										    subtitle: {
										        text: null
										    },
										    xAxis: {
										        categories: null,
										        title: {
										            text: null
										        }
										    },
										    yAxis: {
										        min: 0,
										        title: {
										            text: null,
										            align: 'high'
										        },
										        labels: {
										            overflow: 'justify'
										        }
										    },
										    tooltip: {
										        valueSuffix: ' mean'
										    },
										    plotOptions: {
										        bar: {
										            dataLabels: {
										                enabled: true
										            }
										        }
										    },
										    legend: {
										        layout: 'vertical',
										        align: 'right',
										        verticalAlign: 'top',
										        x: 10,
										        y: -10,
										        floating: true,
										        borderWidth: 1,
										        backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
										        shadow: true
										    },
										    credits: {
										        enabled: false
										    },
										    series: [{
										        name: 'Com',
										        data: [<?php echo $result_form1; ?>]
										    }, {
										        name: 'KSM',
										        data: [<?php echo $result_form2; ?>]
										    }, {
										        name: 'TIL',
										        data: [<?php echo $result_form3; ?>]
										    }, {
										        name: 'ML',
										        data: [<?php echo $result_form4; ?>]
										    }]
										});
							</script>
							<?php } ?>
							<?php if (isset($_GET['type'])&&isset($result_form1)&&isset($result_form2)&&isset($result_form3)&&isset($result_form4)) { ?>
							<hr class="my-4">
							<a class="text-center btn btn-sm btn-danger my-0 my-sm-2 mr-sm-1 pr-sm-2" target="_blank" href="report_file.php?college=<?php echo trim($_GET['college']) . "&department=" . trim($_GET['department']) . "&id=" . trim($_GET['id']). "&fullname=" . trim($_GET['fullname']); ?>">Print Result</a>
							<a class="text-center btn btn-sm btn-warning my-0 my-sm-2 mr-sm-1 pr-sm-2" target="_blank" href="comment.php?college=<?php echo trim($_GET['college']) . "&department=" . trim($_GET['department']) . "&id=" . trim($_GET['id']). "&fullname=" . trim($_GET['fullname']); ?>">Comments</a>
							
							<?php } ?>
							
						</div>
						<?php endif ?>
						
					</div>
					<hr class="my-4">
					
					
					<!-- ------------ -->
					
				</div>
				<script type="text/javascript">
				Highcharts.chart('container_2', {
			    chart: {
			        type: 'column'
			    },
			    title: {
			        text: 'Total Ratings'
			    },
			    subtitle: {
			        text: null
			    },
			    xAxis: {
			        type: 'category',
			        labels: {
			            rotation: -45,
			            style: {
			                fontSize: '13px',
			                fontFamily: 'Verdana, sans-serif'
			            }
			        }
			    },
			    yAxis: {
			        min: 0,
			        title: {
			            text: null
			        }
			    },
			    legend: {
			        enabled: false
			    },
			    tooltip: {
			        pointFormat: 'Total score: <b>{point.y:.1f} % percent</b>'
			    },
			    series: [{
			        name: 'Population',
			        data: [
			            <?php $count = 0; ?>
			            <?php foreach ($_SESSION['Dept_Id'] as $key) {
								echo $key;
								$count++;
								if (count($_SESSION['Dept_Id'])==$count) {
									echo "";
								}else{
									echo ",";
								}
							} ?>
			        ],
			        dataLabels: {
			            enabled: true,
			            rotation: 0,
			            color: '#FFFFFF',
			            align: 'right',
			            format: '{point.y:.1f}', // one decimal
			            y: 10, // 10 pixels down from the top
			            style: {
			                fontSize: '9px',
			                fontFamily: 'Verdana, sans-serif'
			            }
			        }
			    }]
			});
				</script>
				
				<!-- ------------END CONTENT HERE  -->
			</div>
			<?php require_once("sidebar_left.php"); ?>
		</div>
		<div class="clearfix" style="display: block;content: "";clear: both;"></div>
	</body>
	<?php require_once("footer.php"); ?>