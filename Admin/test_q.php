<!DOCTYPE html>
<?php session_start(); ?>
<?php require_once("../Connection/connection.php"); ?>
<?php 

$query_ratings_result = "SELECT COUNT(faculty_id) AS FF, SUM(total_form1), SUM(total_form2),SUM(total_form3),SUM(total_form4),evaluator_type
						FROM fes.ratings
						WHERE sem = '2'
						AND sy = '2017-2018'
						AND faculty_id = '74-3203-1'
						GROUP BY evaluator_type
						ORDER BY FF DESC";


$query_ratings_result_2 = "SELECT empid, deptcode FROM fes.faculty ORDER BY deptcode";


$query_superior = "SELECT deptchairman FROM srgb.department
									WHERE deptchairman = '74-3203-1'";
		$result_superior = pg_query($conn, $query_superior) or die(pg_last_error($conn));
		$row_superior = pg_fetch_array($result_superior);


// "SELECT DISTINCT(FF.empid), PE.firstname, PE.lastname, SD.deptcoll, SD.deptcode
// FROM srgb.department SD, fes.faculty FF, pis.employee PE, srgb.semsubject SS
// WHERE FF.empid = PE.empid
// AND FF.deptcode = 'IT'
// AND FF.deptcode = SD.deptcode
// AND PE.empid = SS.facultyid
// AND SS.sy = '2017-2018'
// AND SS.sem = '2'
// ORDER BY PE.lastname ASC";
$result_ratings_result_X = pg_query($conn, $query_ratings_result) or die(pg_last_error($conn));

$result_ratings_result_X_2 = pg_query($conn, $query_ratings_result_2) or die(pg_last_error($conn));

$count_ratings_result = pg_num_rows($result_ratings_result);

 ?>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>






<?php 

while ($row_ratings_result = pg_fetch_array($result_ratings_result_X_2)) { 

echo "X||".$row_ratings_result[0]."X|X".$row_ratings_result[1]."||X";
echo"<br>";


	}


 ?>


<hr>
<?php 
//function XXX(){
// 	global $conn;
// 	$id_target = '74-3202-6';
// 	$query_ratings_result_2 = "SELECT COUNT(faculty_id) AS FF, SUM(total_form1)+SUM(total_form2)+SUM(total_form3)+SUM(total_form4),evaluator_type 
// 							FROM fes.ratings 
// 							WHERE sem = '2' 
// 							AND sy = '2017-2018' 
// 							AND faculty_id = '".$id_target."' 
// 							GROUP BY evaluator_type 
// 							ORDER BY evaluator_type DESC";
// 	$query_superior = "SELECT deptchairman FROM srgb.department
// 										WHERE deptchairman = '".$id_target."'";
// 		$result_ratings_result_X_2 = pg_query($conn, $query_ratings_result_2) or die(pg_last_error($conn));
// 		$result_superior = pg_query($conn, $query_superior) or die(pg_last_error($conn));
// 		$row_superior = pg_fetch_array($result_superior);
// 	while ($row_ratings_result = pg_fetch_array($result_ratings_result_X_2)) { 						
// 								if (trim($row_ratings_result[2])=='Student') {
// 									$Student_RR = ($row_ratings_result[1]/$row_ratings_result[0])*.30;
// 								} elseif (trim($row_ratings_result[2])=='Peer') {
// 									$Peer_RR = ($row_ratings_result[1]/$row_ratings_result[0])*.20;
// 								}elseif (trim($row_ratings_result[2])=='Superior') {
// 									$Superior_RR = ($row_ratings_result[1]/$row_ratings_result[0])*.30;
// 								}elseif (trim($row_ratings_result[2])=='Self') {
// 									$Self_RR = ($row_ratings_result[1]/$row_ratings_result[0])*.20;
// 								}
// 								} 
		
// 		if (isset($row_superior[0])) {
// 			$Total_SCORE = ($Student_RR+$Peer_RR+$Superior_RR+$Self_RR); 
// 			return $Total_SCORE+=30;
// 		} else {
// 			return $Total_SCORE = ($Student_RR+$Peer_RR+$Superior_RR+$Self_RR); 
// 		}


// } 

?>

<?php echo XXX(); ?>
	

<hr>
<hr>
	
<hr>
	<?php
	# while ($row_ratings_result = pg_fetch_array($result_ratings_result_X)) { ?>
							<?php #echo($row_ratings_result[0]); ?>
							|
							<?php #echo($row_ratings_result[5]); ?>
							|
							<?php #echo(($row_ratings_result[1]/$row_ratings_result[0])+($row_ratings_result[2]/$row_ratings_result[0])+($row_ratings_result[3]/$row_ratings_result[0])+($row_ratings_result[4]/$row_ratings_result[0]))*.30; ?>
							
							<br>

							<?php #} ?>

<pre>
	<?php #var_dump(pg_fetch_array($result_ratings_result_X_2)[1]); ?>
</pre>
							

</body>
<?php pg_close($conn);  ?>
</html>