<!DOCTYPE html>
<?php session_start(); ?>
<?php if (!isset($_SESSION['admin'])) { header('location: login.php'); } ?>
<?php require_once("../Connection/connection.php"); ?>
<?php require_once("Inactive.php"); ?>
<?php $Index="active"; ?>

<?php
	$query_admin_user = "SELECT username FROM fes.admin ORDER BY id DESC LIMIT 5";
	$result_admin = pg_query($conn, $query_admin_user) or die(pg_last_error($conn));
	$count_admin = pg_num_rows($result_admin);

	$admin_id = pg_fetch_assoc($result_admin)
?>

<html>
	<?php require_once("header.php"); ?>
	<body class="container-fluid " style="background-color: #3cb371;">
		<?php require_once("navigation.php"); ?>
		<div class="row" style="margin-top: 40px ;    padding-top: 15px;     background-color: #3cb371;">
			<?php require_once("sidebar.php"); ?>
			<div class="col-8 text-left text-center">
				<!-- CONTENT HERE ------------ -->
				<div class="jumbotron">
					<h1 class="display-4">Welcome <b><?php echo ucfirst($_SESSION['admin']['username']);?>!</b></h1>
					<p class="lead">Good day <?php echo ucfirst($_SESSION['admin']['username']);?>. Check out the result now!</p>
					<hr class="my-4">
					<!-- <p></p> -->
					<p class="lead">
					<a class="btn btn-primary btn-lg" href="result.php?college=ICET&department=IT" role="button">See Result</a>
					</p>
				</div>
				<!-- END CONTENT HERE ------------ -->
			</div>
			<?php require_once("sidebar_left.php"); ?>
		</div>
		<div class="clearfix" style="display: block;content: "";clear: both;"></div>
	</body>
	<?php require_once("footer.php"); ?>