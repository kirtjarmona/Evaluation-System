<!DOCTYPE html>
<?php session_start(); ?>
<?php if (!isset($_SESSION['admin'])) { header('location: login.php'); } ?>
<?php require_once("../Connection/connection.php"); ?>
<?php require_once("Inactive.php"); ?>
<?php $Questionnaires="active"; ?>
<?php
	if (isset($_POST['form1q1']) && isset($_POST['form1q2']) && isset($_POST['form1q3']) && isset($_POST['form1q4']) && isset($_POST['form1q5']) &&
		isset($_POST['form2q1']) && isset($_POST['form2q2']) && isset($_POST['form2q3']) && isset($_POST['form2q4']) && isset($_POST['form2q5']) &&
		isset($_POST['form3q1']) && isset($_POST['form3q2']) && isset($_POST['form3q3']) && isset($_POST['form3q4']) && isset($_POST['form3q5']) &&
		isset($_POST['form4q1']) && isset($_POST['form4q2']) && isset($_POST['form4q3']) && isset($_POST['form4q4']) && isset($_POST['form4q5'])) {
		
		$update_data = "UPDATE fes.questionnaires SET q_question = '". pg_escape_string($_POST['form1q1'])."' WHERE q_id = 1;";
		$update_data .= "UPDATE fes.questionnaires SET q_question = '". pg_escape_string($_POST['form1q2'])."' WHERE q_id = 2;";
		$update_data .= "UPDATE fes.questionnaires SET q_question = '". pg_escape_string($_POST['form1q3'])."' WHERE q_id = 3;";
		$update_data .= "UPDATE fes.questionnaires SET q_question = '". pg_escape_string($_POST['form1q4'])."' WHERE q_id = 4;";
		$update_data .= "UPDATE fes.questionnaires SET q_question = '". pg_escape_string($_POST['form1q5'])."' WHERE q_id = 5;";
		$update_data .= "UPDATE fes.questionnaires SET q_question = '". pg_escape_string($_POST['form2q1'])."' WHERE q_id = 6;";
		$update_data .= "UPDATE fes.questionnaires SET q_question = '". pg_escape_string($_POST['form2q2'])."' WHERE q_id = 7;";
		$update_data .= "UPDATE fes.questionnaires SET q_question = '". pg_escape_string($_POST['form2q3'])."' WHERE q_id = 8;";
		$update_data .= "UPDATE fes.questionnaires SET q_question = '". pg_escape_string($_POST['form2q4'])."' WHERE q_id = 9;";
		$update_data .= "UPDATE fes.questionnaires SET q_question = '". pg_escape_string($_POST['form2q5'])."' WHERE q_id = 10;";
		$update_data .= "UPDATE fes.questionnaires SET q_question = '". pg_escape_string($_POST['form3q1'])."' WHERE q_id = 11;";
		$update_data .= "UPDATE fes.questionnaires SET q_question = '". pg_escape_string($_POST['form3q2'])."' WHERE q_id = 12;";
		$update_data .= "UPDATE fes.questionnaires SET q_question = '". pg_escape_string($_POST['form3q3'])."' WHERE q_id = 13;";
		$update_data .= "UPDATE fes.questionnaires SET q_question = '". pg_escape_string($_POST['form3q4'])."' WHERE q_id = 14;";
		$update_data .= "UPDATE fes.questionnaires SET q_question = '". pg_escape_string($_POST['form3q5'])."' WHERE q_id = 15;";
		$update_data .= "UPDATE fes.questionnaires SET q_question = '". pg_escape_string($_POST['form4q1'])."' WHERE q_id = 16;";
		$update_data .= "UPDATE fes.questionnaires SET q_question = '". pg_escape_string($_POST['form4q2'])."' WHERE q_id = 17;";
		$update_data .= "UPDATE fes.questionnaires SET q_question = '". pg_escape_string($_POST['form4q3'])."' WHERE q_id = 18;";
		$update_data .= "UPDATE fes.questionnaires SET q_question = '". pg_escape_string($_POST['form4q4'])."' WHERE q_id = 19;";
		$update_data .= "UPDATE fes.questionnaires SET q_question = '". pg_escape_string($_POST['form4q5'])."' WHERE q_id = 20;";

		pg_query($conn, $update_data) or die(pg_last_error($conn));
		$confirm_Q_message = "<p class=\"alert alert-success\">Questionnaires has been updated!</p>";
	} else {
		$confirm_Q_message = "<p class=\"alert alert-info\">Click and edit the Questions</p>";
	}

?>
<?php
// Questionnaires
	function question($Form_Q, $q_number){
	global $conn;
	$query_questionnaires = "SELECT q_id, q_category, q_question FROM fes.questionnaires ORDER BY q_id ASC";
	$result_questionnaires = pg_query($conn, $query_questionnaires);
	if ($result_questionnaires>1) {
	while ($row_question = pg_fetch_assoc($result_questionnaires)) {
	if (trim($row_question['q_category'])==$Form_Q) {
	$form1_questions[] = $row_question;
		}
	}
	foreach ($form1_questions as $row_question) {
	$form1_question[] = $row_question;
		}
	}
	$q_number-=1;
	echo $form1_question[$q_number]['q_question'];
	}
?>
<html>
	<?php require_once("header.php"); ?>
	<body class="container-fluid " style="background-color: #3cb371;">
		<?php require_once("navigation.php"); ?>
		<div class="row" style="margin-top: 40px;    padding-top: 15px;">
			<?php require_once("sidebar.php"); ?>
			<div class="col-8 text-left text-center">
				<!-- CONTENT HERE ------------ -->
				<div class="jumbotron">
					
					<form action="questionnaires" method="post" accept-charset="utf-8">
						<nav>
							<div class="nav nav-tabs" id="nav-tab" role="tablist">
								<a class="nav-item nav-link" id="nav-form1-tab" data-toggle="tab" href="#nav-form1" role="tab" aria-controls="nav-form1" aria-selected="true">QCE Form 1</a>
								<a class="nav-item nav-link" id="nav-form2-tab" data-toggle="tab" href="#nav-form2" role="tab" aria-controls="nav-form2" aria-selected="false">QCE Form 2</a>
								<a class="nav-item nav-link" id="nav-form3-tab" data-toggle="tab" href="#nav-form3" role="tab" aria-controls="nav-form3" aria-selected="false">QCE Form 3</a>
								<a class="nav-item nav-link" id="nav-form4-tab" data-toggle="tab" href="#nav-form4" role="tab" aria-controls="nav-form4" aria-selected="false">QCE Form 4</a>
								
								<a href="javascript:void(0)" title="" name="submit" type="button" value="submit" class="login-button btn btn-outline-success btn-md">Update</a>
								
							</div>
						</nav>
						<div class="tab-content" id="nav-tabContent">
							
							<div class="tab-pane fade show active" id="nav-form1" role="tabpanel" aria-labelledby="nav-form1-tab">
								<!-- FORM 1 Content --><br>
								<p class="h4 text-muted">Commitment</p>
								<br>
								<!-- ---- -->
								<div class="input-group mb-3">
									<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Q1</span></div>
									<input name="form1q1" value="<?php question('Form 1',1); ?>"type="text" class="form-control" placeholder="Question" aria-label="Question" aria-describedby="basic-addon1">
								</div>
								<div class="input-group mb-3">
									<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Q2</span></div>
									<input name="form1q2" value="<?php question('Form 1',2); ?>"type="text" class="form-control" placeholder="Question" aria-label="Question" aria-describedby="basic-addon1">
								</div>
								<div class="input-group mb-3">
									<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Q3</span></div>
									<input name="form1q3" value="<?php question('Form 1',3); ?>"type="text" class="form-control" placeholder="Question" aria-label="Question" aria-describedby="basic-addon1">
								</div>
								<div class="input-group mb-3">
									<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Q4</span></div>
									<input name="form1q4" value="<?php question('Form 1',4); ?>"type="text" class="form-control" placeholder="Question" aria-label="Question" aria-describedby="basic-addon1">
								</div>
								<div class="input-group mb-3">
									<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Q5</span></div>
									<input name="form1q5" value="<?php question('Form 1',5); ?>"type="text" class="form-control" placeholder="Question" aria-label="Question" aria-describedby="basic-addon1">
								</div>
								
							</div>
							<div class="tab-pane fade" id="nav-form2" role="tabpanel" aria-labelledby="nav-form2-tab">
								<!-- FORM 2 Content --><br>
								<p class="h4 text-muted">Knowledge of the Subject Matter</p><br>
								<!-- ---- -->
								<div class="input-group mb-3">
									<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Q1</span></div>
									<input name="form2q1" value="<?php question('Form 2',1); ?>"type="text" class="form-control" placeholder="Question" aria-label="Question" aria-describedby="basic-addon1">
								</div>
								<div class="input-group mb-3">
									<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Q2</span></div>
									<input name="form2q2" value="<?php question('Form 2',2); ?>"type="text" class="form-control" placeholder="Question" aria-label="Question" aria-describedby="basic-addon1">
								</div>
								<div class="input-group mb-3">
									<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Q3</span></div>
									<input name="form2q3" value="<?php question('Form 2',3); ?>"type="text" class="form-control" placeholder="Question" aria-label="Question" aria-describedby="basic-addon1">
								</div>
								<div class="input-group mb-3">
									<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Q4</span></div>
									<input name="form2q4" value="<?php question('Form 2',4); ?>"type="text" class="form-control" placeholder="Question" aria-label="Question" aria-describedby="basic-addon1">
								</div>
								<div class="input-group mb-3">
									<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Q5</span></div>
									<input name="form2q5" value="<?php question('Form 2',5); ?>"type="text" class="form-control" placeholder="Question" aria-label="Question" aria-describedby="basic-addon1">
								</div>
							</div>
							<div class="tab-pane fade" id="nav-form3" role="tabpanel" aria-labelledby="nav-form3-tab">
								<!-- FORM 3 Content --><br>
								<p class="h4 text-muted">Teaching for Independent Learning</p><br>
								<!-- ---- -->
								<div class="input-group mb-3">
									<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Q1</span></div>
									<input name="form3q1" value="<?php question('Form 3',1); ?>"type="text" class="form-control" placeholder="Question" aria-label="Question" aria-describedby="basic-addon1">
								</div>
								<div class="input-group mb-3">
									<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Q2</span></div>
									<input name="form3q2" value="<?php question('Form 3',2); ?>"type="text" class="form-control" placeholder="Question" aria-label="Question" aria-describedby="basic-addon1">
								</div>
								<div class="input-group mb-3">
									<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Q3</span></div>
									<input name="form3q3" value="<?php question('Form 3',3); ?>"type="text" class="form-control" placeholder="Question" aria-label="Question" aria-describedby="basic-addon1">
								</div>
								<div class="input-group mb-3">
									<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Q4</span></div>
									<input name="form3q4" value="<?php question('Form 3',4); ?>"type="text" class="form-control" placeholder="Question" aria-label="Question" aria-describedby="basic-addon1">
								</div>
								<div class="input-group mb-3">
									<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Q5</span></div>
									<input name="form3q5" value="<?php question('Form 3',5); ?>"type="text" class="form-control" placeholder="Question" aria-label="Question" aria-describedby="basic-addon1">
								</div>
							</div>
							<div class="tab-pane fade" id="nav-form4" role="tabpanel" aria-labelledby="nav-form4-tab">
								<!-- FORM 4 Content --><br>
								<p class="h4 text-muted">Management of Learning</p><br>
								<!-- ---- -->
								<div class="input-group mb-3">
									<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Q1</span></div>
									<input name="form4q1" value="<?php question('Form 4',1); ?>"type="text" class="form-control" placeholder="Question" aria-label="Question" aria-describedby="basic-addon1">
								</div>
								<div class="input-group mb-3">
									<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Q2</span></div>
									<input name="form4q2" value="<?php question('Form 4',2); ?>"type="text" class="form-control" placeholder="Question" aria-label="Question" aria-describedby="basic-addon1">
								</div>
								<div class="input-group mb-3">
									<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Q3</span></div>
									<input name="form4q3" value="<?php question('Form 4',3); ?>"type="text" class="form-control" placeholder="Question" aria-label="Question" aria-describedby="basic-addon1">
								</div>
								<div class="input-group mb-3">
									<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Q4</span></div>
									<input name="form4q4" value="<?php question('Form 4',4); ?>"type="text" class="form-control" placeholder="Question" aria-label="Question" aria-describedby="basic-addon1">
								</div>
								<div class="input-group mb-3">
									<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Q5</span></div>
									<input name="form4q5" value="<?php question('Form 4',5); ?>"type="text" class="form-control" placeholder="Question" aria-label="Question" aria-describedby="basic-addon1">
								</div>
							</div>
						</div>
					</form>
					<?php echo $confirm_Q_message; ?>
				</div>
				
			</div>



			<?php require_once("sidebar_left.php"); ?>


		</div>

		<?php  
				##echo $update_data; 

?>

		<div class="clearfix" style="display: block;content: "";clear: both;"></div>
	</body>
	<script type="text/javascript">
	$(document).ready(function(){
	$(document).on("click",".login-button",function(){
	var form = $(this).closest("form");
	//console.log(form);
	form.submit();
	});
	});
	</script>
	<?php require_once("footer.php"); ?>