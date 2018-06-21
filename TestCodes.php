<!DOCTYPE html>
<html>
<head>

	
	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Faculty Evaluation System</title>

<!-- 	<link rel="stylesheet" href="css/bootstrap2.min.css" >
   	<script src="js/jquery.min.js"></script>
   	<script src="js/bootstrap.min.js"></script> -->
    			<!-- <script src="js/myjs.js"></script> -->

	<!-- ------------- TEST-->
	<link rel="stylesheet" href="css/bootstrap.min.css" >
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" >


  <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>

	<!-- ------------- -->
	
	<link rel="stylesheet" href="style.css">


    <link rel="stylesheet" href="dist/css/bootstrap.css" >
  <link rel="stylesheet" href="dist/css/bootstrap.min.css" >
  <link rel="stylesheet" href="fontawesome/web-fonts-with-css/css/font-awesome.css">
    <script src="dist/js/jquery.min.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
	  <title></title>


</head>

<body>


<span class="iconic iconic-star" title="star" aria-hidden="true"></span>
<div class="container">
  <!-- Content here -->
<!-- ------------------------------------ -->


<!-- 
<form action="TestCodes_submit" method="get" accept-charset="utf-8">
 -->
<div id="accordion">
  
<p>
  <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="true" aria-controls="collapseExample">
    Form 1
  </a>
  <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample2">
    Form 2
  </a>
    <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample3">
    Form 3
  </a>
  <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample4" role="button" aria-expanded="false" aria-controls="collapseExample4">
    Form 4
  </a>
</p>



<div class="collapse" id="collapseExample" data-parent="#accordion">
  <div class="card card-body" style="display: inline-block;">
    
  <div class="custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem;">
      <input type="radio" id="form1" name="gender" class="custom-control-input" <?php if (isset($gender) && $gender=="Outstanding") echo "checked";?> value="Outstanding">
      <label class="custom-control-label" for="form1">Outstanding</label>
  </div>
  <div class="custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem;">
      <input type="radio" id="form2" name="gender" class="custom-control-input" <?php if (isset($gender) && $gender=="Very Satisfactory") echo "checked";?> value="Very Satisfactory">
      <label class="custom-control-label" for="form2">Very Satisfactory</label>
  </div>
  <div class="custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem;">
      <input type="radio" id="form3" name="gender" class="custom-control-input" <?php if (isset($gender) && $gender=="Satisfactory") echo "checked";?> value="Satisfactory">
      <label class="custom-control-label" for="form3">Satisfactory</label>
  </div>
  <div class="custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem;">
      <input type="radio" id="form4" name="gender" class="custom-control-input" <?php if (isset($gender) && $gender=="Fair") echo "checked";?> value="Fair">
      <label class="custom-control-label" for="form4">Fair</label>
  </div>
  <div class="custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem;">
      <input type="radio" id="form5" name="gender" class="custom-control-input" <?php if (isset($gender) && $gender=="Poor") echo "checked";?> value="Poor">
      <label class="custom-control-label" for="form5">Poor</label>
  </div>


  </div>
</div>


<div class="collapse" id="collapseExample2" data-parent="#accordion">
  <div class="card card-body">
    22 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
  </div>
</div>
<div class="collapse" id="collapseExample3" data-parent="#accordion">
  <div class="card card-body">
    33 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
  </div>
</div>
<div class="collapse" id="collapseExample4" data-parent="#accordion">
  <div class="card card-body">
    44 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
  </div>
</div>
</div>
<!-- 
</form> -->


















<?php
// define variables and set to empty values
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$name = $email = $gender = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if (empty($_POST["comment"])) {
    $comment = "";
  } else {
    $comment = test_input($_POST["comment"]);
  }

  if (empty($_POST["gender"])) {
    $genderErr = "Gender is required";
  } else {
    $gender = test_input($_POST["gender"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>PHP Form Validation Example</h2>
<p><span class="error">* required field.</span></p>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Name: <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  E-mail: <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br>
  Website: <input type="text" name="website" value="<?php echo $website;?>">
  <span class="error"><?php echo $websiteErr;?></span>
  <br><br>
  Comment: <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
  <br><br>
  Gender:
  


<!--   <input type="radio" name="gender" <?php #if (isset($gender) && $gender=="female") echo "checked";?> value="female">Female

  <input type="radio" name="gender" <?php #if (isset($gender) && $gender=="male") echo "checked";?> value="male">Male -->

  <span class="error">* <?php echo $genderErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>

<?php
echo "<h2>Your Input:</h2>";
echo $name;
echo "<br>";
echo $email;
echo "<br>";
echo $website;
echo "<br>";
echo $comment;
echo "<br>";
echo $gender;
?>














<hr>


  <div id="XXaccordion">
  <div class="card">

    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Collapsible Group Item #1
        </button>
      </h5>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
        <div class="custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem;">
          <input type="radio" id="form1" name="gender" class="custom-control-input" <?php if (isset($gender) && $gender=="Outstanding") echo "checked";?> value="Outstanding">
          <label class="custom-control-label" for="form1">Outstanding</label>
        </div>
      <div class="custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem;">
          <input type="radio" id="form2" name="gender" class="custom-control-input" <?php if (isset($gender) && $gender=="Very Satisfactory") echo "checked";?> value="Very Satisfactory">
          <label class="custom-control-label" for="form2">Very Satisfactory</label>
      </div>
      <div class="custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem;">
          <input type="radio" id="form3" name="gender" class="custom-control-input" <?php if (isset($gender) && $gender=="Satisfactory") echo "checked";?> value="Satisfactory">
          <label class="custom-control-label" for="form3">Satisfactory</label>
      </div>
      <div class="custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem;">
          <input type="radio" id="form4" name="gender" class="custom-control-input" <?php if (isset($gender) && $gender=="Fair") echo "checked";?> value="Fair">
          <label class="custom-control-label" for="form4">Fair</label>
      </div>
      <div class="custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem;">
          <input type="radio" id="form5" name="gender" class="custom-control-input" <?php if (isset($gender) && $gender=="Poor") echo "checked";?> value="Poor">
          <label class="custom-control-label" for="form5">Poor</label>
      </div>


      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Collapsible Group Item #2
        </button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Collapsible Group Item #3
        </button>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
          Collapsible Group Item #3
        </button>
      </h5>
    </div>
    <div id="collapsefour" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
</div>

























<hr>
<div class="btn-group" role="group" aria-label="Basic example">
  <button type="button" class="btn btn-danger">   5   </button>
  <button type="button" class="btn btn-secondary">Middle</button>
  <button type="button" class="btn btn-secondary">Right</button>
</div>


<div class="btn-group" role="group" aria-label="Basic example">
  <button type="button" class="btn btn-secondary">Left</button>
  <button type="button" class="btn btn-secondary">Middle</button>
  <button type="button" class="btn btn-secondary">Right</button>
</div>

<button type="button" class="btn btn-outline-primary">Primary</button>
<button type="button" class="btn btn-outline-secondary">Secondary</button>
<button type="button" class="btn btn-outline-success">Success</button>
<button type="button" class="btn btn-outline-danger">Danger</button>
<button type="button" class="btn btn-outline-warning">Warning</button>
<button type="button" class="btn btn-outline-info">Info</button>
<button type="button" class="btn btn-outline-light">Light</button>
<button type="button" class="btn btn-outline-dark">Dark</button>

  <h2>Bootstrap star rating example</h2>


    <br/>
    <label for="input-1" class="control-label">Give a rating for Skill:</label>
    <input id="input-1" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="1" value="2">


    <br/>
    <label for="input-2" class="control-label">Give a rating for Knowledge:</label>
    <input id="input-2" name="input-2" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="4">


    <br/>
    <label for="input-3" class="control-label">Give a rating for PHP:</label>
    <input id="input-3" name="input-3" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="5">



<script>
  $("#input-id").rating();
</script>

<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
  <div class="btn-group mr-2" role="group" aria-label="First group">
    <button type="button" class="btn btn-secondary">1</button>
    <button type="button" class="btn btn-secondary">2</button>
    <button type="button" class="btn btn-secondary">3</button>
    <button type="button" class="btn btn-secondary">4</button>
  </div>
  <div class="btn-group mr-2" role="group" aria-label="Second group">
    <button type="button" class="btn btn-secondary">5</button>
    <button type="button" class="btn btn-secondary">6</button>
    <button type="button" class="btn btn-secondary">7</button>
  </div>
  <div class="btn-group" role="group" aria-label="Third group">
    <button type="button" class="btn btn-secondary">8</button>
  </div>
</div>


 <!--  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 -->


<!-- ------------------------------------ -->
</div>

</body>
</html>