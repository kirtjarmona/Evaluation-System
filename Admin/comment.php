<!DOCTYPE html>
<?php session_start(); ?>
<?php if (!isset($_SESSION['admin'])) { header('location: login.php'); } ?>
<?php require_once("../Connection/connection.php"); ?>
<?php


$query_comments = "	SELECT evaluator_type, comment 
							FROM fes.ratings
							WHERE faculty_id = '".$_GET['id']."'
							AND sy = '".$_SESSION['sy']."'
							AND sem = '".$_SESSION['sem']."'
							GROUP BY evaluator_type, comment
							ORDER BY evaluator_type DESC
							LIMIT 20";
			$result_comments = pg_query($conn, $query_comments) or die(pg_last_error($conn));
			#$count_comments = pg_num_rows($result_comments);
			#$row_default = pg_fetch_all($result_comments);

?>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Comments</title>
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
		li{
			list-style:none;
			margin-left: 10px;
			font-style: normal;
			font-size: 20px
		}
		</style>
	</head>
	<body>
			<table style="width:100%" class="t1">
			<caption style="margin-bottom:20px;"><u>Comments</u></caption>
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
		<hr>

		<ul>
			<?php while ($stud_comments = pg_fetch_assoc($result_comments)) {  ?>
			<?php #if (trim($stud_comments['evaluator_type'])=='Student') { ?>
				<caption><u><b><?php echo $stud_comments['evaluator_type'] ;?></b></u></caption>
					<li><?php echo $stud_comments['comment'] ;?></li>
			<?php #} ?>
			<?php } ?>
		</ul>
			


		
	</body>
</html>
<?php require_once("footer.php"); ?>