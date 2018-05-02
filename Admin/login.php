<!DOCTYPE html>
<?php session_start(); ?>
<?php require_once("../Connection/connection.php"); ?>
<?php $error_msg = "Please Login."; ?>
<?php
if (isset($_SESSION['admin'])) {
  header('location: index.php');
}
if (isset($_POST['username']) && isset($_POST['password']) && $_SERVER['REQUEST_METHOD'] == "POST"){
  $query_admin_user = "SELECT id, username, password FROM fes.admin WHERE username = '". $_POST['username']."' AND password = '". $_POST['password']."'";
  $result_admin = pg_query($conn, $query_admin_user) or die(pg_last_error($conn));
  $count_admin = pg_num_rows($result_admin);
  
    if ($count_admin==1) {
      $_SESSION ['admin'] = pg_fetch_assoc($result_admin);
      header('location: index.php');
    } else {
      $error_msg="Login Failed. Please try again.";
    }
  }
?>
<html>
  <?php require_once("header.php"); ?>
  <body class="container-fluid " style="background-color: #3cb371;">
    <div class="jumbotron text-center">
      <!-- <h2 class="form-signin-heading text-center">Please Login</h2> -->
      <p class="lead text-center"><?php echo $error_msg; ?></p>
      <hr class="my-4">
      <div class="col-xs-12" id="demoContainer" style="height: auto">
        
        <form id="identicalFormx" class="form-signin has-success has-feedback" method="POST">
          <div class="input-group">
            <input id = "username" minlength="4"  maxlength="15" type="text" name="username" class="form-control text-center" placeholder="Username" required>
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
          </div>
          <br>
          <div class="input-group">
            <input id = "confirm_password" type="password" name="password" class="form-control text-center" placeholder="Password" required >
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
          </div>
          <br>
          <button class="btn btn-md btn-success btn-block" type="submit">Login</button>
          <br>
        </form>
        
        
      </div>
    </div>
  </body>
  <?php require_once("footer.php"); ?>