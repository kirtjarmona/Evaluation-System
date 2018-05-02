<!DOCTYPE html>
<?php session_start(); ?>
<?php if (!isset($_SESSION['admin'])) { header('location: login.php'); } ?>
<?php require_once("../Connection/connection.php"); ?>
<?php require_once("Inactive.php"); ?>
<?php $Sched="active"; ?>
<?php
if (isset($_POST['stopped'])) {
$update_sched = "UPDATE fes.sched SET status='Stopped' WHERE primary_id=1";
$result_update_sched = pg_query($conn, $update_sched);
}elseif (isset($_POST['started'])) {
$update_sched = "UPDATE fes.sched SET status='Started' WHERE primary_id=1";
$result_update_sched = pg_query($conn, $update_sched);
}
$query_sy_sem_sched = "SELECT * FROM srgb.semester ORDER BY sy DESC, sem DESC LIMIT 1";
$result_sy_sem_sched = pg_query($conn, $query_sy_sem_sched);
$query_sched = "SELECT FS.primary_id, FS.status FROM fes.sched FS ORDER BY status DESC LIMIT 1";
$result_sched = pg_query($conn, $query_sched);
#failed: ERROR: syntax error at or near &quot;primary&quot; LINE 1: SELECT primary, status FROM fes.sched LIMIT 1 ^ in D:\site\FES\Admin\sched.php on line 11
?>
<html>
	<?php require_once("header.php"); ?>
	<body class="container-fluid " style="background-color: #3cb371;">
		<?php require_once("navigation.php"); ?>
		<div class="row" style="margin-top: 40px;    padding-top: 15px;">
			<?php require_once("sidebar.php"); ?>
			<div class="col-8 text-center">
				<div class="jumbotron">
			<!-- CONTENT HERE ------------ -->
					<?php if ($_SESSION['admin']['id']==2){ ?>
					<div class="row ">
						<p class="lead text-center">You're not allowed to access this content. Please switch to <u>Admin</u> account!</p>
					</div>
					<?php } ?>
					<br>
					<?php if ($_SESSION['admin']['id']==1) {  ?>
					<div class="">
						<?php $row1_sy_sem_sched = pg_fetch_assoc($result_sy_sem_sched); ?>
						<h1 class="display-5">SY: <?php echo $row1_sy_sem_sched['sy']." | Sem: ".$row1_sy_sem_sched['sem']; ?></h1>
						<form action="sched" method="POST" accept-charset="utf-8">
							<?php $row1_sched = pg_fetch_assoc($result_sched); ?>
							<?php if (trim($row1_sched['status'])=="Started") {  ?>
							<p class="lead alert alert-success">The Faculty Evaluation is now open.</p>
							<hr class="my-4">
							<input name="stopped" type="submit" <?php echo $started = (trim($row1_sched['status'])=="Stopped") ? "value=\"Stopped\" class=\"login-button btn btn-danger btn-lg active\"" : "value=\"Stop Evaluation\" class=\"login-button btn btn-danger btn-lg\"" ; ?>>
							<?php } else {  ?>
							<p class="lead alert alert-danger">The Faculty Evaluation is closed.</p>
							<hr class="my-4">
							<input name="started" type="submit" <?php echo $started = (trim($row1_sched['status'])=="Started") ? "value=\"Started\" class=\"login-button btn btn-success btn-lg active\"" : "value=\"Enable Evaluation\" class=\"login-button btn btn-success btn-lg\"" ; ?>>
							<?php } ?>
						</form>
					</div>
					<?php } ?>
				</div>
			</div>
			<!-- END CONTENT HERE ------------ -->
			<!-- </div> -->
			<?php require_once("sidebar_left.php"); ?>
		</div>
		<div class="clearfix" style="display: block;content: "";clear: both;"></div>
		<script type="text/javascript">
		$(document).ready(function(){
		$(document).on("click",".login-button",function(){
		var form = $(this).closest("form");
		//console.log(form);
		form.submit();
		});
		});
		</script>
	</body>
	<?php require_once("footer.php"); ?>