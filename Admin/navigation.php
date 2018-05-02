<?php
$query_sy_sem = "SELECT sy, sem FROM srgb.semester order by sy DESC, sem DESC LIMIT 5";
$result1 = pg_query($conn, $query_sy_sem) or die(pg_last_error($conn));
$result_default_sy_sem = pg_query($conn, $query_sy_sem) or die(pg_last_error($conn));
$count1 = pg_num_rows($result1);


if (!isset($_SESSION['sy']) && !isset($_SESSION['sem']) ) {

$default_session_sy_sem = pg_fetch_assoc($result_default_sy_sem);
$_SESSION['sy'] =  $default_session_sy_sem['sy'];
$_SESSION['sem'] =  $default_session_sy_sem['sem'];
  # code...
}


if (!isset($_GET['sy'])&&isset($_GET['sem'])) {
  $_SESSION['sy']=$_GET['sy']; 
  $_SESSION['sem']=$_GET['sem'];
} elseif (isset($_GET['sy'])&&isset($_GET['sem'])) {
  $_SESSION['sy']=$_GET['sy']; 
  $_SESSION['sem']=$_GET['sem'];
}

?>
<div class="container">
  <div class="row ">
    <nav class=" fixed-top  navbar navbar-expand-lg navbar-light bg-light">
      <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="index.php">
          <img src="../images/sp_logo.png" width="50" height="50" class="d-inline-block align-center" alt="">
          <span class="small badge badge-success" style="">Faculty Evaluation System</span>
        </a>
      </nav>
      <div class=" collapse navbar-collapse navbar-right" id="navbarSupportedContent">
        <ul class="navbar-nav navbar-left justify-content-end">
          
          <li class="nav-item dropdown">
            <a class="btn btn-outline-success nav-link dropdown-toggle btn btn-outline-success" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo $retVal = (isset($_SESSION['sy'])&&isset($_SESSION['sem'])) ? $_SESSION['sy']." | Sem-".$_SESSION['sem'] : "SY | Semester" ; ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <?php
              while ($row = pg_fetch_assoc($result1)){
              echo "<a class=\"dropdown-item  \" href=\"index.php?sy=".$row['sy']."&sem=".$row['sem']."\">".$row['sy']." | Sem-".$row['sem']."</a>";

              ?>
              <div class="dropdown-divider"></div>
              <?php } ?>
            </div>
          </li>
        </ul>
      </div>
      <ul class="nav collapse navbar-collapse justify-content-center">
        <li class="nav-item">
          <a class="nav-link btn btn-outline-success" href="logout.php"> <span class="fa fa-sign-out fa-fw"></span>Logout</a>
        </li>
      </ul>
    </nav>
  </div>
</div>