<!DOCTYPE html>
<?php session_start(); ?>
<?php if (!isset($_SESSION['admin'])) { header('location: login.php'); } ?>
<?php require_once("../Connection/connection.php"); ?>
<?php require_once("Inactive.php"); ?>
<?php $admin_setting="active"; ?>
<?php
	// $query_admin_user = "SELECT username FROM fes.admin ORDER BY id DESC LIMIT 5";
	// $result_admin = pg_query($conn, $query_admin_user) or die(pg_last_error($conn));
	// $count_admin = pg_num_rows($result_admin);
	// $admin_id = pg_fetch_assoc($result_admin)
	$error_msg = "";
?>
<?php
	if (isset($_POST['FES_submit']) && isset($_POST['username']) && isset($_POST['password']) && $_SERVER['REQUEST_METHOD'] == "POST"){
		if ($_POST['pos']==2) {
			#$query_admin_user = "SELECT username, password FROM fes.admin WHERE username = '". $_POST['username']."' AND password = '". $_POST['password']."'";
			$update_data_admin = "UPDATE fes.admin SET username = '". $_POST['username']."' , password = '". $_POST['password']."' WHERE id = 1";
			$result_admin = pg_query($conn, $update_data_admin) or die(pg_last_error($conn));
			$count_admin = pg_num_rows($result_admin);
			
			$error_msg = "(Updated!)";
			
		}
		if ($_POST['pos']==1) {
			#$query_admin_user = "SELECT username, password FROM fes.admin WHERE username = '". $_POST['username']."' AND password = '". $_POST['password']."'";
			$update_data_admin = "UPDATE fes.admin SET username = '". $_POST['username']."' , password = '". $_POST['password']."' WHERE id = 2";
			$result_admin = pg_query($conn, $update_data_admin) or die(pg_last_error($conn));
			$count_admin = pg_num_rows($result_admin);
			
			$error_msg = "(Updated!)";
			
		}
	} elseif (isset($_POST['signatories_submit']) && $_SERVER['REQUEST_METHOD'] == "POST") {
		$signatory_msg = "(Updated!)";

		#"SELECT id, position, name FROM fes.signatory ORDER BY id DESC";
		$update_data_signatories = "UPDATE fes.signatory SET name = '". $_POST['4']."' WHERE id = 4;
									UPDATE fes.signatory SET name = '". $_POST['3']."' WHERE id = 3;
									UPDATE fes.signatory SET name = '". $_POST['2']."' WHERE id = 2;
									UPDATE fes.signatory SET name = '". $_POST['1']."' WHERE id = 1;";

		$result_signatories = pg_query($conn, $update_data_signatories) or die(pg_last_error($conn));
		$count_signatories = pg_num_rows($result_signatories);
		#
	}
?>


<html>
	<?php require_once("header.php"); ?>
	<body class="container-fluid " style="background-color: #3cb371;">
		<?php require_once("navigation.php"); ?>
		<div class="row" style="margin-top: 40px ;    padding-top: 15px;     background-color: #3cb371;">
			<?php require_once("sidebar.php"); ?>
			<div class="col-8 text-left text-center">
				<!-- CONTENT HERE ------------ -->
				<div class="jumbotron text-center">
					<!-- <h2 class="form-signin-heading text-center">Please Login</h2> -->
					<div class="row <?php if ($_SESSION['admin']['id']==1){ echo "d-none";} ?>">
						<p class="lead text-center">You're not allowed to access this content. Please switch to <u>Admin</u> account!</p>
					</div>
					<div class="row <?php if ($_SESSION['admin']['id']==2){ echo "d-none";} ?>">
						<div class="col-4 text-right" style="border-right: 1px solid #959595;">
							<p class="lead text-center">FES Accounts <b><?php echo $error_msg; ?></b></p>
							<hr class="my-4">
							<div class="col-xs-12" id="demoContainer" style="height: auto">
								
								<form id="identicalFormx" class="form-signin has-success has-feedback" method="POST">
									<div class="custom-control custom-radio border rounded text-left">
										<input type="radio" id="staff" name="pos" class="custom-control-input"  <?php if ($_SESSION['admin']['id']==2){ echo "checked";} ?> value="1">
										<label class="custom-control-label" for="staff">Staff</label>
									</div>
									<div class="custom-control custom-radio border rounded text-left">
										<input type="radio" id="admin" name="pos" class="custom-control-input" <?php if ($_SESSION['admin']['id']==1){ echo "checked";} ?> value="2">
										<label class="custom-control-label" for="admin">Admin</label>
									</div>
									<br>
									<div class="input-group">
										<?php 
										// if (isset($_POST['username'])) {
										// 	$username_place = $_POST['username'];
										// } else {
										// 	$username_place = trim($_SESSION['admin']['username']);
										// }  
										?>
										<input value= "<?php echo $username_place; ?>" id = "username" minlength="4"  maxlength="15" type="text" name="username" class="form-control text-center" placeholder="Username" required>
										<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
									</div>
									<br>
									<div class="input-group">
										<input id = "confirm_password" minlength="4"  maxlength="15" type="password" name="password" class="form-control text-center" placeholder="New Password" required >
										<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
									</div>
									<br>
									
									
									<button class="btn btn-md btn-success btn-block" type="submit" name="FES_submit" value="FES_submit">Reset</button>
									<br>
								</form>
								
							</div>
							<hr class="my-4">
							<div class="col-xs-12" id="demoContainer" style="height: auto">
								
								
								
							</div>
						</div>
						<div class="col-8 text-center">
							<p class="lead text-center">Signatories <b><?php echo $signatory_msg; ?></b></p>
							<hr class="my-4">
							<div class="col-xs-12" id="demoContainer" style="height: auto">
								<?php
										$query_chairperson_name = "	SELECT id, position, name
																FROM fes.signatory ORDER BY id DESC";
											$result_signatories = pg_query($conn, $query_chairperson_name) or die(pg_last_error($conn));
											$count_chairperson_name = pg_num_rows($result_signatories);
											#$row_name = pg_fetch_assoc($result_signatories);
								?>
								
								<form id="identicalFormxx" class="form-signin has-success has-feedback" method="POST">
									<?php
									while ($row_default = pg_fetch_assoc($result_signatories)) {
									?>
									<div class="input-group">
										
										<input id = "1<?php echo trim($row_default['id']); ?>" type="text" name="<?php echo trim($row_default['id']); ?>" class="form-control text-center" value="<?php echo trim($row_default['name']); ?>" required >
										<span class="input-group-addon"></span>
									</div>
									<label class="" for="1<?php echo trim($row_default['id']); ?>"><small><?php echo trim($row_default['position']); ?></small></label><br>
									
									<?php } ?>
									<br>
									<button class="btn btn-md btn-success btn-block" type="submit" name="signatories_submit" value="signatories_submit">Update</button>
									<br>
								</form>
								<?php echo $update_data_signatories; ?>
							</div>


						</div>
					</div>
				</div>
				<!-- END CONTENT HERE ------------ -->
			</div>
			<?php require_once("sidebar_left.php"); ?>
		</div>
		<div class="clearfix" style="display: block;content: "";clear: both;"></div>
	</body>
	<?php require_once("footer.php"); ?>