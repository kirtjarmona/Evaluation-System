<nav class="navbar navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
  <button class="navbar-toggler btn-sm" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

<!-- <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark"> -->
  <!-- <div class="container-fluid"> -->
    <!-- <div class="navbar-header"> -->
      <a class="fulltext navbar-brand" href="#" style="@media only and screen(max-device-width: 720px) a {font-size: 1px;}">Faculty Evaluation System |  
      <span style="font-size:80%;" class="btn btn-sm btn-success mr-sm-3" disabled>
      <?php 
        navigation_content();
      ?>
      </span></a>
      <a class="shorttext navbar-brand" href="#" style="@media only and screen(max-device-width: 720px) a {font-size: 1px;}">FES System |  
      <span style="font-size:80%;" class="btn btn-sm btn-success mr-sm-3" disabled>
      <?php 
        navigation_content();
      ?>
      </span></a>
      
      
    <!-- </div> -->
    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
<!--     <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link" href="#"><span style="color:#6eb961;"></span><span class="sr-only">(current)</span></a>
      </li>
      <li class="active"><a href="#">Home</a></li>
      <li><a href="#">Page 1</a></li> 
      <li><a href="#">Page 2</a></li> 
    </ul> -->

    

    <form class="form-inline my-2 my-lg-0 row justify-content-around">


        <!-- <button type="button" class="btn btn-outline-primary my-2 my-sm-0"> -->
        <?php echo $retVal = (isset($_GET["id"])) ? "<a href=\"index.php\" class=\"btn btn-sm btn-outline-success mr-sm-3\">Back</a>" : "" ; ?>
       
        <a href="register_new_pw.php" class="btn btn-sm btn-outline-primary mr-sm-3">Reset Password</a>
       
        <a href="logout.php" class="btn btn-sm btn-outline-primary my-2 my-sm-0">Sign Out</a>
    </form>
</div>
  <!-- </div> -->
</nav>



<!-- 
        <img src="http://spamast.edu.ph/images/template/icet_button.jpg" class="pull-right img-responsive img-thumbnail"> -->
