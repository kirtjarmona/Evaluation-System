<?php
$query_count_voters = "SELECT COUNT(evaluateid) AS eva, evaluator_type
						FROM fes.ratings
						WHERE sem = '".$_SESSION['sem']."'
						AND sy = '".$_SESSION['sy']."'
						GROUP BY evaluator_type
						ORDER BY eva DESC";
$result_count_voters = pg_query($conn, $query_count_voters) or die(pg_last_error($conn));
$count_count_voters = pg_num_rows($result_count_voters);
// 
$query_count_student_voters = "SELECT COUNT(studid) FROM srgb.semstudent
								WHERE sem = '".$_SESSION['sem']."'
								AND sy = '".$_SESSION['sy']."'";
$result_count_student_voters = pg_query($conn, $query_count_student_voters) or die(pg_last_error($conn));
$row_count_student_voters = pg_fetch_array($result_count_student_voters);


//

$query_count_student_voted = "SELECT COUNT(DISTINCT student_id) FROM fes.ratings
								WHERE evaluator_type = 'Student'
								AND sy = '".$_SESSION['sy']."'
								AND sem = '".$_SESSION['sem']."'";
$result_count_student_voted = pg_query($conn, $query_count_student_voted) or die(pg_last_error($conn));
$row_count_student_voted = pg_fetch_array($result_count_student_voted);
//
	$query_count_faculties = "SELECT facultyid, COUNT(DISTINCT facultyid) FROM srgb.semsubject
								WHERE sy = '".$_SESSION['sy']."'
								AND sem = '".$_SESSION['sem']."'
								AND facultyid IS NOT null
								GROUP BY facultyid";
	$result_count_faculties = pg_query($conn, $query_count_faculties) or die(pg_last_error($conn));
	while ($row_count_faculties = pg_fetch_array($result_count_faculties)) {
		$value_count_faculties +=1;
	}
	//
	$query_count_faculties_voted = "SELECT COUNT(DISTINCT student_id)
									FROM fes.ratings
									WHERE evaluator_type IN ('Peer', 'Superior', 'Self')
									AND sy = '".$_SESSION['sy']."'
									AND sem = '".$_SESSION['sem']."';";
	$result_count_faculties_voted = pg_query($conn, $query_count_faculties_voted) or die(pg_last_error($conn));
	$row_count_faculties_voted = pg_fetch_array($result_count_faculties_voted);
?>
<div class="col sidenav  text-center">
	<h4>FES Voters</h4>
	
	<div class="well">
		<br>
		<small><b>Faculty:</b></small>
		<a class="text-center btn btn-sm btn-outline-success my-0 my-sm-2 mr-sm-1 pr-sm-2" href=""><?php echo $row_count_faculties_voted[0]."/".$value_count_faculties; ?></a>
		<br>
		<small><b>Students:</b></small>
		<a class="text-center btn btn-sm btn-outline-success my-0 my-sm-2 mr-sm-1 pr-sm-2" href=""><?php echo $row_count_student_voted[0]."/".$row_count_student_voters[0]; ?></a>
		

		
	</div>
	<!-- 	<div class="well">
			<p>ADS</p>
	</div> -->
	<hr class="my-4">
	<div class="well">
		<p style="margin-top: 10px; margin-bottom: 0px;"><b><u><?php echo strtoupper($_SESSION['sy']) ?></u></b></p>
		<small>School Year</small>
		<hr class="my-4">
		<p style="margin-top: 15px; margin-bottom: 0px;"><b><u><?php echo strtoupper($_SESSION['sem']) ?></u></b></p>
		<small>Semester</small>
	</div>
</div>