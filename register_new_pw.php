<!DOCTYPE html>
<?php session_start(); ?>
<?php require_once("Connection/connection.php"); ?>
<html>
<?php require_once("header.php"); ?>
<body class="demo-bootstrap">
<div class="container">
<?php if ((!isset($_SESSION['id'])) || ($_SESSION['success']==false) || empty($_SESSION['success']) ){
  header('location: index.php');
} ?>
<?php 
      $query = "SELECT FS.ev_id, FS.ev_pw
                FROM fes.evaluator FS 
                WHERE FS.ev_id='".trim($_SESSION['id'], " ")."'";
                  $result = pg_query($conn, $query) or die(pg_last_error($conn));
                  $count = pg_num_rows($result);
      if ($count == 1){
        $level_msg = '<div id= "confirmMessage"class="alert alert-info">Hi ' . $_SESSION['name'] . ', Please reset your password</div> ';
      } else {
        $level_msg = '<div id= "confirmMessage"class="alert alert-danger">Hi ' . $_SESSION['name'] . ', Please set your password</div> ';
      }
 ?>
<?php 
    if (isset($_POST['password']) && isset($_POST['confirm_password']) && $_SERVER['REQUEST_METHOD'] == "POST"){

      if (strlen($_POST['password'])<4) {
        $level_msg = '<div id= "confirmMessage"class="alert alert-danger">Minimum of 4 character for password. Please try again!</div>';
      } else {
        if ($_POST['password'] === $_POST['confirm_password']) {
          if ($count == 1){
              $update_data = "UPDATE fes.evaluator SET ev_pw = '". $_POST['confirm_password']."' WHERE ev_id = '".trim($_SESSION['id']," ")."'";
              pg_query($conn, $update_data) or die(pg_last_error($conn));
              $_SESSION['error_msg'] = "<div class=\"alert alert-success\">Success! Password has been updated</div>";

              header('location: index.php');
              $_SESSION['password'] = $_POST['password'];
              $_SESSION['success'] = false;

          } else {
              $insert_data = "INSERT INTO fes.evaluator (ev_id, ev_pw) VALUES ('" . trim($_SESSION['id']," ") . "' , '" . $_POST['confirm_password'] . "')";
              pg_query($conn, $insert_data) or die(pg_last_error($conn));
              $_SESSION['error_msg'] = "<div class=\"alert alert-success\">Success! Password has been set</div>";

              header('location: index.php');
              $_SESSION['password'] = $_POST['password'];
              $_SESSION['success'] = false;

          } 
        } else {
          $level_msg = '<div id= "confirmMessage"class="alert alert-danger">Password don\'t match. Please try again!</div>';
        }
      }

      

      header('location: index.php');
      $_SESSION['password'] = $_POST['password'];
      $_SESSION['success'] = false;
      

    } 


 ?>
<div class="jumbotron text-center">
      <h2 class="form-signin-heading text-center">User ID: <u><?php echo $_SESSION['id']; ?></u></h2>

      <?php echo $level_msg; ?>

      <p class="lead text-center"></p>
      <hr class="my-4">
      <p></p>

      <div class="col-xs-12" id="demoContainer" style="height: auto">
      
          <form id="identicalFormx" class="form-signin has-success has-feedback" method="POST">
          <div class="input-group">
          <input id = "password" minlength="4"  maxlength="15" type="password" name="password" class="form-control text-center" placeholder="New Password" required>
          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
          </div>
          <br>

          <div class="input-group">
          <input id = "confirm_password" type="password" name="confirm_password" class="form-control text-center" placeholder="Retype Password" required >
          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
          </div>
          <br>
          <button class="btn btn-md btn-success btn-block" type="submit">Reset</button>
          <br>
          <!-- <button class="btn btn-md btn-primary btn-block" type="cancel" onclick=" relocate_home()">Cancel</button> -->
          <a href="index.php" title="Cancel" class="btn btn-md btn-primary btn-block">Cancel</a>

          <?php 
          // if ($_SESSION['cancel'] == true) {
          //     $cancel = "index.php";
          // } else {
          //     $cancel = "logout.php";
          // }
          ?>
          <!-- <script>function relocate_home(){location.href = "index.php";} </script> -->
          </form>
          
       

</div>
</div>

</div>

<script>
  var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirm_password");

  function validatePassword(){
  if(password.value != confirm_password.value) {
  confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
  confirm_password.setCustomValidity('');
  }
  }

  password.onchange = validatePassword;
  confirm_password.onkeyup = validatePassword;
</script>



<?php require_once("footer.php"); ?>