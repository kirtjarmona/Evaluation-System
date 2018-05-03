<!DOCTYPE html>
<?php session_start(); ?>
<?php if (!isset($_SESSION['admin'])) { header('location: login.php'); } ?>
<?php require_once("../Connection/connection.php"); ?>
<?php
			$query_chairperson_name = "	SELECT id, position, name
								FROM fes.signatory ORDER BY id DESC";
			$result_signatories = pg_query($conn, $query_chairperson_name) or die(pg_last_error($conn));
			$count_chairperson_name = pg_num_rows($result_signatories);
			$row_default = pg_fetch_all($result_signatories);
			#$row_name = pg_fetch_assoc($result_signatories);
			
		
		$query_superior = "SELECT deptchairman FROM srgb.department
									WHERE deptchairman = '".$_GET['id']."'";
		$result_superior = pg_query($conn, $query_superior) or die(pg_last_error($conn));
		$row_superior = pg_fetch_array($result_superior);
		
	if (isset($row_superior[0])) {
		$_SESSION['result_form1_super']=$_SESSION['result_form2_super']=$_SESSION['result_form3_super']=$_SESSION['result_form4_super']=25;
		$_SESSION['super_t'] = $_SESSION['result_form1_super']+$_SESSION['result_form2_super']+$_SESSION['result_form3_super']+$_SESSION['result_form4_super'];
		$_SESSION['super_w'] = $_SESSION['super_t']*.30;
	}
?>
<?php
	$query_ratings_result = "SELECT COUNT(faculty_id) AS FF, SUM(total_form1), SUM(total_form2),SUM(total_form3),SUM(total_form4),evaluator_type
							FROM fes.ratings
							WHERE sem = '".$_SESSION['sem']."'
							AND sy = '".$_SESSION['sy']."'
							AND faculty_id = '".$_GET['id']."'
							GROUP BY evaluator_type
							ORDER BY FF DESC";
	$result_ratings_result = pg_query($conn, $query_ratings_result) or die(pg_last_error($conn));
	$count_ratings_result = pg_num_rows($result_ratings_result);
while ($row_ratings_result = pg_fetch_array($result_ratings_result)) { ?>
<?php
								if (trim($row_ratings_result[5])=="Student") {
									$_SESSION['result_form1_student'] = $row_ratings_result[1]/$row_ratings_result[0];
									$_SESSION['result_form2_student'] = $row_ratings_result[2]/$row_ratings_result[0];
									$_SESSION['result_form3_student'] = $row_ratings_result[3]/$row_ratings_result[0];
									$_SESSION['result_form4_student'] = $row_ratings_result[4]/$row_ratings_result[0];
									$_SESSION['student_t'] = $_SESSION['result_form1_student']+$_SESSION['result_form2_student']+$_SESSION['result_form3_student']+$_SESSION['result_form4_student'];
									$_SESSION['student_w'] = $_SESSION['student_t']*.30;
								}
								if (trim($row_ratings_result[5])=="Superior") {
									$_SESSION['result_form1_super'] = $row_ratings_result[1]/$row_ratings_result[0];
									$_SESSION['result_form2_super'] = $row_ratings_result[2]/$row_ratings_result[0];
									$_SESSION['result_form3_super'] = $row_ratings_result[3]/$row_ratings_result[0];
									$_SESSION['result_form4_super'] = $row_ratings_result[4]/$row_ratings_result[0];
									$_SESSION['super_t'] = $_SESSION['result_form1_super']+$_SESSION['result_form2_super']+$_SESSION['result_form3_super']+$_SESSION['result_form4_super'];
									$_SESSION['super_w'] = $_SESSION['super_t']*.30;
								}
								if (trim($row_ratings_result[5])=="Peer") {
									$_SESSION['result_form1_peer'] = $row_ratings_result[1]/$row_ratings_result[0];
									$_SESSION['result_form2_peer'] = $row_ratings_result[2]/$row_ratings_result[0];
									$_SESSION['result_form3_peer'] = $row_ratings_result[3]/$row_ratings_result[0];
									$_SESSION['result_form4_peer'] = $row_ratings_result[4]/$row_ratings_result[0];
									$_SESSION['peer_t'] = $_SESSION['result_form1_peer']+$_SESSION['result_form2_peer']+$_SESSION['result_form3_peer']+$_SESSION['result_form4_peer'];
									$_SESSION['peer_w'] = $_SESSION['peer_t']*.20;
								}
								if (trim($row_ratings_result[5])=="Self") {
									$_SESSION['result_form1_self'] = $row_ratings_result[1]/$row_ratings_result[0];
									$_SESSION['result_form2_self'] = $row_ratings_result[2]/$row_ratings_result[0];
									$_SESSION['result_form3_self'] = $row_ratings_result[3]/$row_ratings_result[0];
									$_SESSION['result_form4_self'] = $row_ratings_result[4]/$row_ratings_result[0];
									$_SESSION['self_t'] = $_SESSION['result_form1_self']+$_SESSION['result_form2_self']+$_SESSION['result_form3_self']+$_SESSION['result_form4_self'];
									$_SESSION['self_w'] = $_SESSION['self_t']*.20;
								}
								$_SESSION['total_evaluated']=$_SESSION['self_w']+$_SESSION['peer_w']+$_SESSION['super_w']+$_SESSION['student_w']
?>
<?php } ?>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Print</title>
		<link rel="stylesheet" href="">
		<style type="text/css">
			@page { size: auto;  margin: 0mm; }
			table {
				font-family: sans-serif;
			}
			body {
				margin: 0 10%;
			}
			.colbor td{
				border: 1px solid black;
				border-collapse: collapse;
				border-spacing: 0px;
				margin: 0;
				}
			.no_colbor{
				border: 0px solid black;
				border-collapse: collapse;
				border-spacing: 0px;
				margin: 0;
				}
			.t2 {
				font-size: 14px;
			}
		</style>
	</head>
	<body>
		<table style="width:100%" class="t1">
			<caption style="margin-bottom:20px;"><b>FACULTY PERFORMANCE OVER-ALL RATING SHEET</b></caption>
			<br><br>
			<tbody>
				<tr>
					<td>Name of Faculty: <b><?php echo $_GET['fullname']; ?></b></td>
					<td>College: <b>CAS</b></td>
				</tr>
				<tr>
					<?php if ($_SESSION['sem']=='2') {
						$text = "nd";
					} elseif ($_SESSION['sem']=='1') {
						$text = "st";
					} elseif ($_SESSION['sem']=='S') {
						$text = "Summer";
					} elseif (isset($_SESSION['sem'])) {
						$text = " ";
					} ?>
					<td>Rating Period: <b><?php echo $_SESSION['sem'].$text; ?> Sem, <?php echo $_SESSION['sy'] ?></b></td>
					<td>Department: <b><?php echo $_GET['department']; ?></b></td>
					
				</tr>
				<tr>
					<td><b></b></td>
					
				</tr>
				<tr>
					<td><b></b></td>
				</tr>
				
			</tbody>
		</table>
		<table style="width:100%" class="t2">
			<thead>
				
			</thead>
			<tbody>
				<tr>
					<td style="width:50%"><b>COMPONENTS</b></td>
					<td><b>MEAN SCORE</b></td>
					<td><b>WEIGHTED POINTS</b></td>
					<td><b>RATING</b></td>
				</tr>
			</tbody>
			<tr>
				<td colspan="4"><b>I. STUDENT</b></td>
			</tr>
			<tr class="colbor">
				<td style="width:50%"><b>A. Commitment</b></td>
				<td><b><?php echo $_SESSION['result_form1_student']; ?></b></td>
				<td style="border: 0px"><b></b></td>
				<td style="border: 0px"><b></b></td>
			</tr>
			<tr class="colbor">
				<td style="width:50%"><b>B. Knowledge of Subject Matter</b></td>
				<td><b><?php echo $_SESSION['result_form2_student']; ?></b></td>
				<td style="border: 0px"><b></b></td>
				<td style="border: 0px"><b></b></td>
			</tr>
			<tr class="colbor">
				<td style="width:50%"><b>C. Teaching for Independent Learning</b></td>
				<td><b><?php echo $_SESSION['result_form3_student']; ?></b></td>
				<td style="border: 0px"><b></b></td>
				<td style="border: 0px"><b></b></td>
			</tr>
			<tr class="colbor">
				<td style="width:50%"><b>C. Management of Learning</b></td>
				<td><b><?php echo $_SESSION['result_form4_student']; ?></b></td>
				<td style="border: 0px"><b></b></td>
				<td style="border: 0px"><b></b></td>
			</tr>
			<tr class="colbor">
				<td style="width:50%"><b>TOTAL</b></td>
				<td><b><?php echo $_SESSION['student_t']; ?></b></td>
				<td><b>x 30%</b></td>
				<td><b><?php echo $_SESSION['student_w']; ?></b></td>
			</tr>
			<tr>
				<td colspan="4"><b>II. PEER</b></td>
			</tr>
			<tr class="colbor">
				<td style="width:50%"><b>A. Commitment</b></td>
				<td><b><?php echo $_SESSION['result_form1_peer']; ?></b></td>
				<td style="border: 0px"><b></b></td>
				<td style="border: 0px"><b></b></td>
			</tr>
			<tr class="colbor">
				<td style="width:50%"><b>B. Knowledge of Subject Matter</b></td>
				<td><b><?php echo $_SESSION['result_form2_peer']; ?></b></td>
				<td style="border: 0px"><b></b></td>
				<td style="border: 0px"><b></b></td>
			</tr>
			<tr class="colbor">
				<td style="width:50%"><b>C. Teaching for Independent Learning</b></td>
				<td><b><?php echo $_SESSION['result_form3_peer']; ?></b></td>
				<td style="border: 0px"><b></b></td>
				<td style="border: 0px"><b></b></td>
			</tr>
			<tr class="colbor">
				<td style="width:50%"><b>C. Management of Learning</b></td>
				<td><b><?php echo $_SESSION['result_form4_peer']; ?></b></td>
				<td style="border: 0px"><b></b></td>
				<td style="border: 0px"><b></b></td>
			</tr>
			<tr class="colbor">
				<td style="width:50%"><b>TOTAL</b></td>
				<td><b><?php echo $_SESSION['peer_t']; ?></b></td>
				<td><b>x 20%</b></td>
				<td><b><?php echo $_SESSION['peer_w']; ?></b></td>
			</tr>
			<tr>
				<td colspan="4"><b>III. SUPERIOR</b></td>
			</tr>
			<tr class="colbor">
				<td style="width:50%"><b>A. Commitment</b></td>
				<td><b><?php echo $_SESSION['result_form1_super']; ?></b></td>
				<td style="border: 0px"><b></b></td>
				<td style="border: 0px"><b></b></td>
			</tr>
			<tr class="colbor">
				<td style="width:50%"><b>B. Knowledge of Subject Matter</b></td>
				<td><b><?php echo $_SESSION['result_form2_super']; ?></b></td>
				<td style="border: 0px"><b></b></td>
				<td style="border: 0px"><b></b></td>
			</tr>
			<tr class="colbor">
				<td style="width:50%"><b>C. Teaching for Independent Learning</b></td>
				<td><b><?php echo $_SESSION['result_form3_super']; ?></b></td>
				<td style="border: 0px"><b></b></td>
				<td style="border: 0px"><b></b></td>
			</tr>
			<tr class="colbor">
				<td style="width:50%"><b>C. Management of Learning</b></td>
				<td><b><?php echo $_SESSION['result_form4_super']; ?></b></td>
				<td style="border: 0px"><b></b></td>
				<td style="border: 0px"><b></b></td>
			</tr>
			<tr class="colbor">
				<td style="width:50%"><b>TOTAL</b></td>
				<td><b><?php echo $_SESSION['super_t']; ?></b></td>
				<td><b>x 30%</b></td>
				<td><b><?php echo $_SESSION['super_w']; ?></b></td>
			</tr>
			<tr>
				<td colspan="4"><b>IV. SELF</b></td>
			</tr>
			<tr class="colbor">
				<td style="width:50%"><b>A. Commitment</b></td>
				<td><b><?php echo $_SESSION['result_form1_self']; ?></b></td>
				<td style="border: 0px"><b></b></td>
				<td style="border: 0px"><b></b></td>
			</tr>
			<tr class="colbor">
				<td style="width:50%"><b>B. Knowledge of Subject Matter</b></td>
				<td><b><?php echo $_SESSION['result_form2_self']; ?></b></td>
				<td style="border: 0px"><b></b></td>
				<td style="border: 0px"><b></b></td>
			</tr>
			<tr class="colbor">
				<td style="width:50%"><b>C. Teaching for Independent Learning</b></td>
				<td><b><?php echo $_SESSION['result_form3_self']; ?></b></td>
				<td style="border: 0px"><b></b></td>
				<td style="border: 0px"><b></b></td>
			</tr>
			<tr class="colbor">
				<td style="width:50%"><b>C. Management of Learning</b></td>
				<td><b><?php echo $_SESSION['result_form4_self']; ?></b></td>
				<td style="border: 0px"><b></b></td>
				<td style="border: 0px"><b></b></td>
			</tr>
			<tr class="colbor">
				<td style="width:50%"><b>TOTAL</b></td>
				<td><b><?php echo $_SESSION['self_t']; ?></b></td>
				<td><b>x 20%</b></td>
				<td><b><?php echo $_SESSION['self_w']; ?></b></td>
			</tr>
			<tr class="colbor">
				<td style="width:50%; border: 0px;"><b></b></td>
				<td colspan="2"><b>Over-All Rating:</b></td>
				<!-- <td style="border: 0px"><b></b></td> -->
				<td><b><?php echo $_SESSION['total_evaluated']; ?></b></td>
			</tr>
			<tr>
				<td style="width:50%; border: 0px;"><b>SUMMARY:</b></td>
			</tr>
		</table>
		<table style="width:100%" class="t3">
			
			
			<tr>
				<td>Final Numeric Rating: <b><?php echo $_SESSION['total_evaluated']; ?></b></td>
			</tr>
			<tr>
				<?php if ($_SESSION['total_evaluated']>=95) {
					$message="Outstanding";
				}elseif ($_SESSION['total_evaluated']>=90) {
					$message="Excellent";
				}elseif ($_SESSION['total_evaluated']>=80) {
					$message="Very Good";
				}elseif ($_SESSION['total_evaluated']>=70) {
					$message="Good";
				}elseif ($_SESSION['total_evaluated']>=60) {
					$message="Fair";
				} ?>
				<td>Descriptive Rating: <b><?php echo($message); ?></b></td>
			</tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr>
				<td>Showed to me and concurred</td>
				<td>Prepared by:</td>
			</tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr>
				<td><b><?php echo $_GET['fullname']; ?></b></td>
				<td><b><?php echo strtoupper(trim($row_default[3]['name'])); ?></b></td>
			</tr>
			<tr>
				<td><b>Faculty</b></td>
				<td><b>Dean's Staff</b></td>
			</tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr>
				<td>Reviewed by:</td>
				<td>Noted:</td>
			</tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr>
				<td><b><?php echo strtoupper(trim($row_default[2]['name'])); ?></b></td>
				<td><b><?php echo strtoupper(trim($row_default[1]['name'])); ?></b></td>
			</tr>
			<tr>
				<td><b>Dean of the College</b></td>
				<td><b>VP for Academic Affairs</b></td>
			</tr>
			<!-- --------------------------- -->
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr style="width:100%">
				<td align="center" colspan="2">Conforme:</td>
			</tr>
			<tr style="width:100%"><td></td></tr>
			<tr style="width:100%"><td></td></tr>
			<tr style="width:100%"><td></td></tr>
			<tr style="width:50%">
				<td align="center" colspan="2"><b><?php echo strtoupper(trim($row_default[0]['name'])); ?></b></td>
			</tr>
			<tr style="width:50%">
				<td align="center" colspan="2"><b><?php echo trim($row_default[0]['position']); ?></b></td>
			</tr>
			
		</table>
		
		
	</body>
</html>
<?php
unset($_SESSION['result_form1_student']);
unset($_SESSION['result_form2_student']);
unset($_SESSION['result_form3_student']);
unset($_SESSION['result_form4_student']);
unset($_SESSION['student_t']);
unset($_SESSION['student_w']);
unset($_SESSION['result_form1_peer']);
unset($_SESSION['result_form2_peer']);
unset($_SESSION['result_form3_peer']);
unset($_SESSION['result_form4_peer']);
unset($_SESSION['peer_t']);
unset($_SESSION['peer_w']);
unset($_SESSION['result_form1_super']);
unset($_SESSION['result_form2_super']);
unset($_SESSION['result_form3_super']);
unset($_SESSION['result_form4_super']);
unset($_SESSION['super_t']);
unset($_SESSION['super_w']);
unset($_SESSION['result_form1_self']);
unset($_SESSION['result_form2_self']);
unset($_SESSION['result_form3_self']);
unset($_SESSION['result_form4_self']);
unset($_SESSION['self_t']);
unset($_SESSION['self_w']);
unset($_SESSION['total_evaluated']);
?>
<?php require_once("footer.php"); ?>