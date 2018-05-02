<!DOCTYPE html>
<?php session_start(); ?>
<?php require_once("Connection/connection.php"); ?>
<?php if (trim($_SESSION['id'])==trim($_GET['id'])) {
  $_SESSION['evaluator_type'] = 'Self';
} 
?>
<?php 
 if (isset($_SESSION['student_info'])) {
    $complete_evaluateID = str_replace("-", "", $_GET['EvaluateID'].$_SESSION['present_sy'].$_SESSION['present_sem'].str_replace(" ", "", $_GET['subjcode']));
  }else{
    $complete_evaluateID = str_replace("-", "", $_GET['EvaluateID'].$_SESSION['present_sy'].$_SESSION['present_sem']);
  } 
 ?>

<?php 
function question($Form_Q = 'Form 1', $q_number){
  global $conn;
  $query_questionnaires = "SELECT q_category, q_question FROM fes.questionnaires ORDER BY q_category ASC";
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
  echo $form1_question[$q_number]['q_question'];
}


function query_method() {
  global $conn, $complete_evaluateID;
        if (isset($_GET['subjcode'])) {

          $subjcode_stud = $_GET['subjcode'];
          $sy_stud_fac = $_GET['sy'];
          $sem_stud_fac = $_GET['sem'];

        } else {
  $q_number-=1;
          
          $subjcode_stud = "No";
          $sy_stud_fac = $_SESSION['sy'];
          $sem_stud_fac = $_SESSION['sem'];
        }
  if (isset($_GET['EvaluateID'])) {
    $query_check_evaluateid = "SELECT evaluateid, form1q1, form1q2, form1q3, form1q4, form1q5, form2q1, form2q2, form2q3, form2q4, form2q5, form3q1, form3q2, form3q3, form3q4, form3q5, form4q1, form4q2, form4q3, form4q4, form4q5, comment 
    FROM fes.ratings 
    WHERE evaluateid = '".$complete_evaluateID."' 
      AND subjcode = '".$subjcode_stud."'
      AND sy = '".$sy_stud_fac."'
      AND sem = '".$sem_stud_fac."'";
    $result_check_evaluateid = pg_query($conn, $query_check_evaluateid);
    $row_check_evaluateid = pg_fetch_assoc($result_check_evaluateid);
    if ($row_check_evaluateid>1) {

      $form1q1=$row_check_evaluateid['form1q1'];  
      $form1q2=$row_check_evaluateid['form1q2'];  
      $form1q3=$row_check_evaluateid['form1q3'];  
      $form1q4=$row_check_evaluateid['form1q4'];  
      $form1q5=$row_check_evaluateid['form1q5'];  
      $form2q1=$row_check_evaluateid['form2q1'];  
      $form2q2=$row_check_evaluateid['form2q2'];  
      $form2q3=$row_check_evaluateid['form2q3'];  
      $form2q4=$row_check_evaluateid['form2q4'];  
      $form2q5=$row_check_evaluateid['form2q5'];  
      $form3q1=$row_check_evaluateid['form3q1'];  
      $form3q2=$row_check_evaluateid['form3q2'];  
      $form3q3=$row_check_evaluateid['form3q3'];  
      $form3q4=$row_check_evaluateid['form3q4'];  
      $form3q5=$row_check_evaluateid['form3q5'];  
      $form4q1=$row_check_evaluateid['form4q1'];  
      $form4q2=$row_check_evaluateid['form4q2'];  
      $form4q3=$row_check_evaluateid['form4q3'];  
      $form4q4=$row_check_evaluateid['form4q4'];  
      $form4q5=$row_check_evaluateid['form4q5'];
      $comment=$row_check_evaluateid['comment'];

      return array(true, $form1q1, $form1q2, $form1q3, $form1q4, $form1q5, $form2q1, $form2q2, $form2q3, $form2q4, $form2q5, $form3q1, $form3q2, $form3q3, $form3q4, $form3q5, $form4q1, $form4q2, $form4q3, $form4q4, $form4q5, $comment);

    } else {

      return array(false);
    
    }
  }
 
}


function navigation_content(){
        if (isset($_SESSION['evaluator_type'])) {
            if (isset($_GET['id'])) {
              if (trim($_GET['id'])==trim($_SESSION['id'])) {
                echo "Self";
              } elseif (isset($_SESSION['facluty_info'])) {
                echo $_SESSION['evaluator_type'];
              } elseif (isset($_SESSION['student_info'])) {
                echo "Student";
              }
            }else {
                echo $_SESSION['evaluator_type'];
              }

        
      } elseif (isset($_SESSION['evaluator_type'])) {
        navigation_content();
      }  else {
       header("Location: logout.php"); 
      }
}
 ?>

 <?php 
    if (!isset($_GET['id'])) {
      header("Location: index.php"); 
    }
  ?>

<html>
<?php require_once("header.php"); ?>
<!-- CONTENT -->
<body>

  
  <!-- Content here -->
<!-- ------------------------------------ -->
<div class="container">
<?php require_once("navigation.php"); ?>


<?php #echo htmlspecialchars($_GET["id"]); ?>
<br>
<br>

<h1 class="h6 alert alert-success"><a href="index.php" title="Back to List">
                <?php 
                      if (isset($_SESSION['student_info'])) {
                        echo ucwords(strtolower($_SESSION['student_info'][0]['studfullname']));
                      } elseif (isset($_SESSION['facluty_info'])) {
                          foreach ($_SESSION['facluty_info'] as $key => $value1) {
                              foreach ($value1 as $key1 => $value2){
                                    echo $bread2 = ($_SESSION['id']==trim($value2)) ? trim($value1['firstname']) . " " .trim($value1['lastname']) : "" ;

// GET HERE ==========++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                              }
                          } 
                      }
                       
                ?></a> <i class="" style="">|</i>
                      
<?php 

evaluated_person();

function evaluated_person(){
  if (isset($_SESSION['student_info'])) {
  foreach ($_SESSION['student_info'] as $key => $value1) {
      foreach ($value1 as $key1 => $value2){
            echo $bread2 = ($_GET['subjcode']==trim($value2)) ? trim($value1['name']) . " <i class=\"\">|</i> ": "" ;
            echo $bread3 = ($_GET['subjcode']==trim($value2)) ? trim($value1['subjcode']) : "" ;


    }
  } 
} elseif (isset($_SESSION['facluty_info'])) {
    foreach ($_SESSION['facluty_info'] as $key => $value1) {
      foreach ($value1 as $key1 => $value2){
            echo $bread2 = ($_GET['id']==trim($value2)) ? trim($value1['firstname']) . " " . trim($value1['lastname']) : "" ;
    }
  } 
} 
}
?>
</h1>


<?php 

if (query_method()[0]==true) {
  $form1q1 = query_method()[1]; 
  $form1q2 = query_method()[2]; 
  $form1q3 = query_method()[3]; 
  $form1q4 = query_method()[4]; 
  $form1q5 = query_method()[5];
  $form2q1 = query_method()[6]; 
  $form2q2 = query_method()[7]; 
  $form2q3 = query_method()[8]; 
  $form2q4 = query_method()[9]; 
  $form2q5 = query_method()[10];
  $form3q1 = query_method()[11]; 
  $form3q2 = query_method()[12]; 
  $form3q3 = query_method()[13]; 
  $form3q4 = query_method()[14]; 
  $form3q5 = query_method()[15];
  $form4q1 = query_method()[16]; 
  $form4q2 = query_method()[17]; 
  $form4q3 = query_method()[18]; 
  $form4q4 = query_method()[19]; 
  $form4q5 = query_method()[20];
  $comment = query_method()[21];
} else {
    // USE DATA OF STUDENT IF EXIST
  $form1q1 = $form1q2 = $form1q3 = $form1q4 = $form1q5 ="";
  $form2q1 = $form2q2 = $form2q3 = $form2q4 = $form2q5 ="";
  $form3q1 = $form3q2 = $form3q3 = $form3q4 = $form3q5 ="";
  $form4q1 = $form4q2 = $form4q3 = $form4q4 = $form4q5 ="";
  $comment = "";
}



  #form errors
  $form1_error = $form2_error = $form3_error = $form4_error = "";
  $form_error_msg = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["form1q1"]) || empty($_POST["form1q2"]) || empty($_POST["form1q3"]) || empty($_POST["form1q4"]) || empty($_POST["form1q5"])) {

      $form1_error = true;
        $form1q1 = (!empty($_POST["form1q1"])) ? $_POST["form1q1"] : "" ;
        $form1q2 = (!empty($_POST["form1q2"])) ? $_POST["form1q2"] : "" ;
        $form1q3 = (!empty($_POST["form1q3"])) ? $_POST["form1q3"] : "" ;
        $form1q4 = (!empty($_POST["form1q4"])) ? $_POST["form1q4"] : "" ;
        $form1q5 = (!empty($_POST["form1q5"])) ? $_POST["form1q5"] : "" ;

      } else {
        $form1_error = false;
        $form1_ready = true;
        $form1q1 = test_input($_POST["form1q1"]);
        $form1q2 = test_input($_POST["form1q2"]);
        $form1q3 = test_input($_POST["form1q3"]);
        $form1q4 = test_input($_POST["form1q4"]);
        $form1q5 = test_input($_POST["form1q5"]);
        $form1_total = $form1q1 + $form1q2 + $form1q3 + $form1q4 + $form1q5;
      }
  

    if (empty($_POST["form2q1"]) || empty($_POST["form2q2"]) || empty($_POST["form2q3"]) || empty($_POST["form2q4"]) || empty($_POST["form2q5"])) {

      $form2_error = true;
        $form2q1 = (!empty($_POST["form2q1"])) ? $_POST["form2q1"] : "" ;
        $form2q2 = (!empty($_POST["form2q2"])) ? $_POST["form2q2"] : "" ;
        $form2q3 = (!empty($_POST["form2q3"])) ? $_POST["form2q3"] : "" ;
        $form2q4 = (!empty($_POST["form2q4"])) ? $_POST["form2q4"] : "" ;
        $form2q5 = (!empty($_POST["form2q5"])) ? $_POST["form2q5"] : "" ;        
      
      } else {
        $form2_error = false;
        $form2q1 = test_input($_POST["form2q1"]);
        $form2q2 = test_input($_POST["form2q2"]);
        $form2q3 = test_input($_POST["form2q3"]);
        $form2q4 = test_input($_POST["form2q4"]);
        $form2q5 = test_input($_POST["form2q5"]);
        $form2_ready = true;
        $form2_total = $form2q1 + $form2q2 + $form2q3 + $form2q4 + $form2q5;
      }

      if (empty($_POST["form3q1"]) || empty($_POST["form3q2"]) || empty($_POST["form3q3"]) || empty($_POST["form3q4"]) || empty($_POST["form3q5"])) {

        $form3_error = true;
        $form3q1 = (!empty($_POST["form3q1"])) ? $_POST["form3q1"] : "" ;
        $form3q2 = (!empty($_POST["form3q2"])) ? $_POST["form3q2"] : "" ;
        $form3q3 = (!empty($_POST["form3q3"])) ? $_POST["form3q3"] : "" ;
        $form3q4 = (!empty($_POST["form3q4"])) ? $_POST["form3q4"] : "" ;
        $form3q5 = (!empty($_POST["form3q5"])) ? $_POST["form3q5"] : "" ;        
      
      } else {
        $form3_error = false;
        $form3q1 = test_input($_POST["form3q1"]);
        $form3q2 = test_input($_POST["form3q2"]);
        $form3q3 = test_input($_POST["form3q3"]);
        $form3q4 = test_input($_POST["form3q4"]);
        $form3q5 = test_input($_POST["form3q5"]);
        $form3_ready = true;
        $form3_total = $form3q1 + $form3q2 + $form3q3 + $form3q4 + $form3q5;
      }

      if (empty($_POST["form4q1"]) || empty($_POST["form4q2"]) || empty($_POST["form4q3"]) || empty($_POST["form4q4"]) || empty($_POST["form4q5"])) {

        $form4_error = true;
        $form4q1 = (!empty($_POST["form4q1"])) ? $_POST["form4q1"] : "" ;
        $form4q2 = (!empty($_POST["form4q2"])) ? $_POST["form4q2"] : "" ;
        $form4q3 = (!empty($_POST["form4q3"])) ? $_POST["form4q3"] : "" ;
        $form4q4 = (!empty($_POST["form4q4"])) ? $_POST["form4q4"] : "" ;
        $form4q5 = (!empty($_POST["form4q5"])) ? $_POST["form4q5"] : "" ;        
      
      } else {
        $form4_error = false;
        $form4q1 = test_input($_POST["form4q1"]);
        $form4q2 = test_input($_POST["form4q2"]);
        $form4q3 = test_input($_POST["form4q3"]);
        $form4q4 = test_input($_POST["form4q4"]);
        $form4q5 = test_input($_POST["form4q5"]);
        $form4_ready = true;
        $form4_total = $form4q1 + $form4q2 + $form4q3 + $form4q4 + $form4q5;
      }


      if (empty($_POST["comment"])) {
        $comment = "";
        $form5_error = true;
      } else {
        $comment = test_input($_POST["comment"]);
        $form5_error = false;
        $form5_ready = true;
      }

      if ($form1_error == true) {
        $form_error_msg = "<div class=\"text-left alert alert-danger\"><b>Please rate all the items in <u>QCE form 1 </u></b></div>";
        $form1_show = true;
      } else {
        $form1_error =false;
              if ($form2_error == true) {
                  $form_error_msg = "<div class=\"text-left alert alert-danger\"><b>Please rate all the items in <u>QCE form 2 </u></b></div>";
                  $form2_show = true;
              } else {
                $form2_error = false;
                  if ($form3_error == true) {
                    $form_error_msg = "<div class=\"text-left alert alert-danger\"><b>Please rate all the items in <u>QCE form 3 </u></b></div>";
                    $form3_show = true;
                  } else {
                    $form3_error =false;
                      if ($form4_error == true) {
                        $form_error_msg = "<div class=\"text-left alert alert-danger\"><b>Please rate all the items in <u>QCE form 4 </u></b></div>";
                        $form4_show = true;
                      } else {
                        $form4_error =false;
                          if ($form5_error == true) {
                          $form_error_msg = "<div class=\"text-left alert alert-danger\"><b>Please leave a <u>Comment </u></b></div>";
                          $form5_show = true;
                          } else {
                            $form5_error = false;
                            // if ($form6_error == true) {
                            //     $form_error_msg = "<div class=\"text-left alert alert-danger\"><b>Please leave a <u>Comment </u></b></div>";
                            //     $form6_show = true;
                            //   } else {
                            //     $form6_error = false;
                            //   }
                          }
                      }
                  }
          }
      }

      if (isset($form1_ready) && isset($form2_ready) && isset($form3_ready) && isset($form4_ready) && isset($form5_ready)) {

        if (isset($_GET['subjcode'])) {

          $subjcode_stud = $_GET['subjcode'];
          $sy_stud_fac = $_GET['sy'];
          $sem_stud_fac = $_GET['sem'];

        } else {
          
          $subjcode_stud = "No";
          $sy_stud_fac = $_SESSION['sy'];
          $sem_stud_fac = $_SESSION['sem'];
        }


$insert_ratings_info = "INSERT INTO fes.ratings(
  evaluateid, student_id, faculty_id, evaluator_type, subjcode, sy, sem, total_form1, total_form2, total_form3, total_form4, form1q1, form1q2, form1q3, form1q4, form1q5, form2q1, form2q2, form2q3, form2q4, form2q5, form3q1, form3q2, form3q3, form3q4, form3q5, form4q1, form4q2, form4q3, form4q4, form4q5, comment)
                        VALUES ('".$complete_evaluateID. "', 
                                '". $_SESSION['id']."', 
                                '". $_GET['id']. "', 
                                '". $_SESSION['evaluator_type']."', 
                                '". $subjcode_stud . "', 
                                '". $sy_stud_fac . "',  
                                '". $sem_stud_fac . "',  
                                ". $form1_total . ", 
                                ". $form2_total . ", 
                                ". $form3_total . ", 
                                ". $form4_total . ", 
                                ". $form1q1. ", ". $form1q2. ", ". $form1q3. ", ". $form1q4. ", ". $form1q5. ", 
                                ". $form2q1. ", ". $form2q2. ", ". $form2q3. ", ". $form2q4. ", ". $form2q5. ", 
                                ". $form3q1. ", ". $form3q2. ", ". $form3q3. ", ". $form3q4. ", ". $form3q5. ", 
                                ". $form4q1. ", ". $form4q2. ", ". $form4q3. ", ". $form4q4. ", ". $form4q5. ",
                                '". $comment . "'
                                );";

$update_ratings_info = "UPDATE fes.ratings
                       SET evaluateid='".$complete_evaluateID."', 
                           student_id='". $_SESSION['id']."',
                           faculty_id='". $_GET['id']. "',
                           evaluator_type='". $_SESSION['evaluator_type']."', 
                           subjcode='". $subjcode_stud . "', 
                           sy='". $sy_stud_fac . "', 
                           sem='". $sem_stud_fac . "',
                           total_form1=". $form1_total . ", 
                           total_form2=". $form2_total . ", 
                           total_form3=". $form3_total . ", 
                           total_form4=". $form4_total . ",
                           form1q1=". $form1q1. ", form1q2=". $form1q2. ", form1q3=". $form1q3. ", form1q4=". $form1q4. ", form1q5=". $form1q5. ", 
                           form2q1=". $form2q1. ", form2q2=". $form2q2. ", form2q3=". $form2q3. ", form2q4=". $form2q4. ", form2q5=". $form2q5. ", 
                           form3q1=". $form3q1. ", form3q2=". $form3q2. ", form3q3=". $form3q3. ", form3q4=". $form3q4. ", form3q5=". $form3q5. ", 
                           form4q1=". $form4q1. ", form4q2=". $form4q2. ", form4q3=". $form4q3. ", form4q4=". $form4q4. ", form4q5=". $form4q5. ",
                           comment='". $comment . "'
                           WHERE evaluateid='".$complete_evaluateID."'
                           AND sy = '".$_SESSION['present_sy']."' 
                           AND sem = '".$_SESSION['present_sem']."';";


        
        // echo $form1_total;
        // echo "<br>";
        // echo $form2_total;
        // echo "<br>";
        // echo $form3_total;
        // echo "<br>";
        // echo $form4_total;
        // echo "<br>";
        // echo "Percentage".((($form1q1+$form1q2+$form1q3+$form1q4+$form1q5)/25)*100);

        // echo "<br>";
        // echo query_method();
        // echo "<br>";


        if (query_method()[0]==true) {
          #echo $update_ratings_info;
          pg_query($conn, $update_ratings_info) or die(pg_last_error($conn));
          echo "<h4 class=\"h6 alert alert-info\"><a href=\"index.php\" title=\"Back to List\">Update! Thank you.</a></h4>";
        } elseif (query_method()[0]==false) {
          #echo $insert_ratings_info;
          pg_query($conn, $insert_ratings_info) or die(pg_last_error($conn));
          echo "<h4 class=\"h6 alert alert-info\"><a href=\"index.php\" title=\"Back to List\">Saved! Thank you</a></h4>";
        } else {
          #echo $insert_ratings_info;
          pg_query($conn, $insert_ratings_info) or die(pg_last_error($conn));
          echo "<h4 class=\"h6 alert alert-info\"><a href=\"index.php\" title=\"Back to List\">Saved! Thank you</a></h4>";
        }

    

      }
  }



function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

 ?>




<form method="post" action="<?php
              if (isset($_GET['subjcode'])) {
                 echo htmlspecialchars($_SERVER["PHP_SELF"])."?id=".$_GET['id']."&subjcode=".$_GET['subjcode']."&sy=".$_GET['sy']."&sem=".$_GET['sem']."&EvaluateID=".trim($_GET['EvaluateID']);
               } else {
                 echo htmlspecialchars($_SERVER["PHP_SELF"])."?id=".$_GET['id']."&EvaluateID=".trim($_GET['EvaluateID']);
               } 

              
?>">


<div id="accordion" class="text-center">
<p>
  <a class="btn <?php echo $retVal = (isset($form1_show) && $form1_show == true) ? "btn-success" : "btn-outline-success" ; ?>" data-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="false" aria-controls="collapseExample1" style="margin:2px;">
    QCE Form 1
  </a>
  <a class="btn <?php echo $retVal = (isset($form2_show) && $form2_show == true) ? "btn-success" : "btn-outline-success" ; ?>" data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample2" style="margin:2px;">
    QCE Form 2
  </a>
  <a class="btn <?php echo $retVal = (isset($form3_show) && $form3_show == true) ? "btn-success" : "btn-outline-success" ; ?>" data-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample3" style="margin:2px;">
    QCE Form 3
  </a>
  <a class="btn <?php echo $retVal = (isset($form4_show) && $form4_show == true) ? "btn-success" : "btn-outline-success" ; ?>" data-toggle="collapse" href="#collapseExample4" role="button" aria-expanded="false" aria-controls="collapseExample4" style="margin:2px;">
    QCE Form 4
  </a>
  <a class="btn <?php echo $retVal = (isset($form5_show) && $form5_show == true) ? "btn-success" : "btn-outline-success" ; ?>" data-toggle="collapse" href="#collapseExample5" role="button" aria-expanded="false" aria-controls="collapseExample5" style="margin:2px;">
    Comment
  </a>
  <a class="btn btn-outline-primary <?php #echo $retVal = (isset($form5_show) && $form5_show == true) ? "btn-success" : "btn-outline-primary" ; ?>" data-toggle="collapse" href="#collapseExample6" role="button" aria-expanded="false" aria-controls="collapseExample6" style="margin:2px;">
    Summary
  </a>
</p>





<?php echo $form_error_msg; ?>

<!-- FORM 1 -->
<div class="collapse <?php echo $retVal = ($form1_error === true) ? "show" : "" ; ?>" id="collapseExample1" data-parent="#accordion">
  <div class="card card-body" style="">
    <!-- <div class="card card-body" style="display: inline-block;"> -->
    <h6 class="text-left alert alert-info"><?php evaluated_person(); ?><i class=""> | </i>Commitment</h6>
    <!-- FORM 1 Q1 -->
    <hr>
    <p class="text-left"><b>1.</b> <?php question('Form 1',0); ?></p>
    <div class="row justify-content-center">
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q1_1" name="form1q1" class="custom-control-input" <?php if (isset($form1q1) && $form1q1=="5") echo "checked";?> value="5">
        <label class="custom-control-label" for="form1q1_1">Outstanding</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q1_2" name="form1q1" class="custom-control-input" <?php if (isset($form1q1) && $form1q1=="4") echo "checked";?> value="4">
        <label class="custom-control-label" for="form1q1_2">Very Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q1_3" name="form1q1" class="custom-control-input" <?php if (isset($form1q1) && $form1q1=="3") echo "checked";?> value="3">
        <label class="custom-control-label" for="form1q1_3">Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q1_4" name="form1q1" class="custom-control-input" <?php if (isset($form1q1) && $form1q1=="2") echo "checked";?> value="2">
        <label class="custom-control-label" for="form1q1_4">Fair</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q1_5" name="form1q1" class="custom-control-input" <?php if (isset($form1q1) && $form1q1=="1") echo "checked";?> value="1">
        <label class="custom-control-label" for="form1q1_5">Poor</label>
      </div>
    </div>
    <!-- FORM 1 Q2 -->
    <hr>
    <p class="text-left"><b>2.</b> <?php question('Form 1',1); ?></p>
    <div class="row justify-content-center">
      
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q2_1" name="form1q2" class="custom-control-input" <?php if (isset($form1q2) && $form1q2=="5") echo "checked";?> value="5">
        <label class="custom-control-label" for="form1q2_1">Outstanding</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q2_2" name="form1q2" class="custom-control-input" <?php if (isset($form1q2) && $form1q2=="4") echo "checked";?> value="4">
        <label class="custom-control-label" for="form1q2_2">Very Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q2_3" name="form1q2" class="custom-control-input" <?php if (isset($form1q2) && $form1q2=="3") echo "checked";?> value="3">
        <label class="custom-control-label" for="form1q2_3">Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q2_4" name="form1q2" class="custom-control-input" <?php if (isset($form1q2) && $form1q2=="2") echo "checked";?> value="2">
        <label class="custom-control-label" for="form1q2_4">Fair</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q2_5" name="form1q2" class="custom-control-input" <?php if (isset($form1q2) && $form1q2=="1") echo "checked";?> value="1">
        <label class="custom-control-label" for="form1q2_5">Poor</label>
      </div>
    </div>
    <!-- FORM 1 Q3 -->
    <hr>
    <p class="text-left"><b>3.</b> <?php question('Form 1',2); ?></p>
    <div class="row justify-content-center">
      
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q3_1" name="form1q3" class="custom-control-input" <?php if (isset($form1q3) && $form1q3=="5") echo "checked";?> value="5">
        <label class="custom-control-label" for="form1q3_1">Outstanding</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q3_2" name="form1q3" class="custom-control-input" <?php if (isset($form1q3) && $form1q3=="4") echo "checked";?> value="4">
        <label class="custom-control-label" for="form1q3_2">Very Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q3_3" name="form1q3" class="custom-control-input" <?php if (isset($form1q3) && $form1q3=="3") echo "checked";?> value="3">
        <label class="custom-control-label" for="form1q3_3">Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q3_4" name="form1q3" class="custom-control-input" <?php if (isset($form1q3) && $form1q3=="2") echo "checked";?> value="2">
        <label class="custom-control-label" for="form1q3_4">Fair</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q3_5" name="form1q3" class="custom-control-input" <?php if (isset($form1q3) && $form1q3=="1") echo "checked";?> value="1">
        <label class="custom-control-label" for="form1q3_5">Poor</label>
      </div>
    </div>
    <!-- FORM 1 Q4 -->
    <hr>
    <p class="text-left"><b>4.</b> <?php question('Form 1',3); ?></p>
    <div class="row justify-content-center">
      
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q4_1" name="form1q4" class="custom-control-input" <?php if (isset($form1q4) && $form1q4=="5") echo "checked";?> value="5">
        <label class="custom-control-label" for="form1q4_1">Outstanding</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q4_2" name="form1q4" class="custom-control-input" <?php if (isset($form1q4) && $form1q4=="4") echo "checked";?> value="4">
        <label class="custom-control-label" for="form1q4_2">Very Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q4_3" name="form1q4" class="custom-control-input" <?php if (isset($form1q4) && $form1q4=="3") echo "checked";?> value="3">
        <label class="custom-control-label" for="form1q4_3">Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q4_4" name="form1q4" class="custom-control-input" <?php if (isset($form1q4) && $form1q4=="2") echo "checked";?> value="2">
        <label class="custom-control-label" for="form1q4_4">Fair</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q4_5" name="form1q4" class="custom-control-input" <?php if (isset($form1q4) && $form1q4=="1") echo "checked";?> value="1">
        <label class="custom-control-label" for="form1q4_5">Poor</label>
      </div>
    </div>
    <!-- FORM 1 Q5 -->
    <hr>
    <p class="text-left"><b>5.</b> <?php question('Form 1',4); ?></p>
    <div class="row justify-content-center">
      
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q5_1" name="form1q5" class="custom-control-input" <?php if (isset($form1q5) && $form1q5=="5") echo "checked";?> value="5">
        <label class="custom-control-label" for="form1q5_1">Outstanding</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q5_2" name="form1q5" class="custom-control-input" <?php if (isset($form1q5) && $form1q5=="4") echo "checked";?> value="4">
        <label class="custom-control-label" for="form1q5_2">Very Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q5_3" name="form1q5" class="custom-control-input" <?php if (isset($form1q5) && $form1q5=="3") echo "checked";?> value="3">
        <label class="custom-control-label" for="form1q5_3">Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q5_4" name="form1q5" class="custom-control-input" <?php if (isset($form1q5) && $form1q5=="2") echo "checked";?> value="2">
        <label class="custom-control-label" for="form1q5_4">Fair</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form1q5_5" name="form1q5" class="custom-control-input" <?php if (isset($form1q5) && $form1q5=="1") echo "checked";?> value="1">
        <label class="custom-control-label" for="form1q5_5">Poor</label>
      </div>
    </div>
  </div>
</div>
<!-- END of FORM 1 -->

<!-- -------------- -->

<!-- FORM 2 -->
<div class="collapse <?php  echo $retVal = (isset($form2_show)) ? "show" : "" ; ?>" id="collapseExample2" data-parent="#accordion">
  <div class="card card-body">
    <h6 class="text-left alert alert-info"><?php evaluated_person(); ?><i class=""> | </i>Knowledge of the Subject Matter</h6>
    <!-- FORM 2 Q1 -->
    <hr>
    <p class="text-left"><b>1.</b> <?php question('Form 2',0); ?></p>
    <div class="row justify-content-center">
      
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q1_1" name="form2q1" class="custom-control-input" <?php if (isset($form2q1) && $form2q1=="5") echo "checked";?> value="5">
        <label class="custom-control-label" for="form2q1_1">Outstanding</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q1_2" name="form2q1" class="custom-control-input" <?php if (isset($form2q1) && $form2q1=="4") echo "checked";?> value="4">
        <label class="custom-control-label" for="form2q1_2">Very Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q1_3" name="form2q1" class="custom-control-input" <?php if (isset($form2q1) && $form2q1=="3") echo "checked";?> value="3">
        <label class="custom-control-label" for="form2q1_3">Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q1_4" name="form2q1" class="custom-control-input" <?php if (isset($form2q1) && $form2q1=="2") echo "checked";?> value="2">
        <label class="custom-control-label" for="form2q1_4">Fair</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q1_5" name="form2q1" class="custom-control-input" <?php if (isset($form2q1) && $form2q1=="1") echo "checked";?> value="1">
        <label class="custom-control-label" for="form2q1_5">Poor</label>
      </div>
    </div>
    <!-- FORM 1 Q2 -->
    <hr>
    <p class="text-left"><b>2.</b> <?php question('Form 2',1); ?></p>
    <div class="row justify-content-center">
      
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q2_1" name="form2q2" class="custom-control-input" <?php if (isset($form2q2) && $form2q2=="5") echo "checked";?> value="5">
        <label class="custom-control-label" for="form2q2_1">Outstanding</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q2_2" name="form2q2" class="custom-control-input" <?php if (isset($form2q2) && $form2q2=="4") echo "checked";?> value="4">
        <label class="custom-control-label" for="form2q2_2">Very Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q2_3" name="form2q2" class="custom-control-input" <?php if (isset($form2q2) && $form2q2=="3") echo "checked";?> value="3">
        <label class="custom-control-label" for="form2q2_3">Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q2_4" name="form2q2" class="custom-control-input" <?php if (isset($form2q2) && $form2q2=="2") echo "checked";?> value="2">
        <label class="custom-control-label" for="form2q2_4">Fair</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q2_5" name="form2q2" class="custom-control-input" <?php if (isset($form2q2) && $form2q2=="1") echo "checked";?> value="1">
        <label class="custom-control-label" for="form2q2_5">Poor</label>
      </div>
    </div>
    <!-- FORM 1 Q3 -->
    <hr>
    <p class="text-left"><b>3.</b> <?php question('Form 2',2); ?></p>
    <div class="row justify-content-center">
      
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q3_1" name="form2q3" class="custom-control-input" <?php if (isset($form2q3) && $form2q3=="5") echo "checked";?> value="5">
        <label class="custom-control-label" for="form2q3_1">Outstanding</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q3_2" name="form2q3" class="custom-control-input" <?php if (isset($form2q3) && $form2q3=="4") echo "checked";?> value="4">
        <label class="custom-control-label" for="form2q3_2">Very Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q3_3" name="form2q3" class="custom-control-input" <?php if (isset($form2q3) && $form2q3=="3") echo "checked";?> value="3">
        <label class="custom-control-label" for="form2q3_3">Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q3_4" name="form2q3" class="custom-control-input" <?php if (isset($form2q3) && $form2q3=="2") echo "checked";?> value="2">
        <label class="custom-control-label" for="form2q3_4">Fair</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q3_5" name="form2q3" class="custom-control-input" <?php if (isset($form2q3) && $form2q3=="1") echo "checked";?> value="1">
        <label class="custom-control-label" for="form2q3_5">Poor</label>
      </div>
    </div>
    <!-- FORM 1 Q4 -->
    <hr>
    <p class="text-left"><b>4.</b> <?php question('Form 2',3); ?></p>
    <div class="row justify-content-center">
      
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q4_1" name="form2q4" class="custom-control-input" <?php if (isset($form2q4) && $form2q4=="5") echo "checked";?> value="5">
        <label class="custom-control-label" for="form2q4_1">Outstanding</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q4_2" name="form2q4" class="custom-control-input" <?php if (isset($form2q4) && $form2q4=="4") echo "checked";?> value="4">
        <label class="custom-control-label" for="form2q4_2">Very Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q4_3" name="form2q4" class="custom-control-input" <?php if (isset($form2q4) && $form2q4=="3") echo "checked";?> value="3">
        <label class="custom-control-label" for="form2q4_3">Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q4_4" name="form2q4" class="custom-control-input" <?php if (isset($form2q4) && $form2q4=="2") echo "checked";?> value="2">
        <label class="custom-control-label" for="form2q4_4">Fair</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q4_5" name="form2q4" class="custom-control-input" <?php if (isset($form2q4) && $form2q4=="1") echo "checked";?> value="1">
        <label class="custom-control-label" for="form2q4_5">Poor</label>
      </div>
    </div>
    <!-- FORM 1 Q5 -->
    <hr>
    <p class="text-left"><b>5.</b> <?php question('Form 2',4); ?></p>
    <div class="row justify-content-center">
      
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q5_1" name="form2q5" class="custom-control-input" <?php if (isset($form2q5) && $form2q5=="5") echo "checked";?> value="5">
        <label class="custom-control-label" for="form2q5_1">Outstanding</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q5_2" name="form2q5" class="custom-control-input" <?php if (isset($form2q5) && $form2q5=="4") echo "checked";?> value="4">
        <label class="custom-control-label" for="form2q5_2">Very Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q5_3" name="form2q5" class="custom-control-input" <?php if (isset($form2q5) && $form2q5=="3") echo "checked";?> value="3">
        <label class="custom-control-label" for="form2q5_3">Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q5_4" name="form2q5" class="custom-control-input" <?php if (isset($form2q5) && $form2q5=="2") echo "checked";?> value="2">
        <label class="custom-control-label" for="form2q5_4">Fair</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form2q5_5" name="form2q5" class="custom-control-input" <?php if (isset($form2q5) && $form2q5=="1") echo "checked";?> value="1">
        <label class="custom-control-label" for="form2q5_5">Poor</label>
      </div>
    </div>
  </div>
</div>
<!-- END of FORM 2 -->

<!-- --------------- -->
<!-- FORM 3 -->
<div class="collapse <?php  echo $retVal = (isset($form3_show)) ? "show" : "" ; ?>" id="collapseExample3" data-parent="#accordion">
  <div class="card card-body">
    <h6 class="text-left alert alert-info"><?php evaluated_person(); ?><i class=""> | </i>Teaching for Independent Learning</h6>
    <!-- FORM 3 Q1 -->
    <hr>
    <p class="text-left"><b>1.</b> <?php question('Form 3',0); ?></p>
    <div class="row justify-content-center">
      
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q1_1" name="form3q1" class="custom-control-input" <?php if (isset($form3q1) && $form3q1=="5") echo "checked";?> value="5">
        <label class="custom-control-label" for="form3q1_1">Outstanding</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q1_2" name="form3q1" class="custom-control-input" <?php if (isset($form3q1) && $form3q1=="4") echo "checked";?> value="4">
        <label class="custom-control-label" for="form3q1_2">Very Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q1_3" name="form3q1" class="custom-control-input" <?php if (isset($form3q1) && $form3q1=="3") echo "checked";?> value="3">
        <label class="custom-control-label" for="form3q1_3">Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q1_4" name="form3q1" class="custom-control-input" <?php if (isset($form3q1) && $form3q1=="2") echo "checked";?> value="2">
        <label class="custom-control-label" for="form3q1_4">Fair</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q1_5" name="form3q1" class="custom-control-input" <?php if (isset($form3q1) && $form3q1=="1") echo "checked";?> value="1">
        <label class="custom-control-label" for="form3q1_5">Poor</label>
      </div>
    </div>
    <!-- FORM 3 Q2 -->
    <hr>
    <p class="text-left"><b>2.</b> <?php question('Form 3',1); ?></p>
    <div class="row justify-content-center">
      
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q2_1" name="form3q2" class="custom-control-input" <?php if (isset($form3q2) && $form3q2=="5") echo "checked";?> value="5">
        <label class="custom-control-label" for="form3q2_1">Outstanding</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q2_2" name="form3q2" class="custom-control-input" <?php if (isset($form3q2) && $form3q2=="4") echo "checked";?> value="4">
        <label class="custom-control-label" for="form3q2_2">Very Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q2_3" name="form3q2" class="custom-control-input" <?php if (isset($form3q2) && $form3q2=="3") echo "checked";?> value="3">
        <label class="custom-control-label" for="form3q2_3">Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q2_4" name="form3q2" class="custom-control-input" <?php if (isset($form3q2) && $form3q2=="2") echo "checked";?> value="2">
        <label class="custom-control-label" for="form3q2_4">Fair</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q2_5" name="form3q2" class="custom-control-input" <?php if (isset($form3q2) && $form3q2=="1") echo "checked";?> value="1">
        <label class="custom-control-label" for="form3q2_5">Poor</label>
      </div>
    </div>
    <!-- FORM 3 Q3 -->
    <hr>
    <p class="text-left"><b>3.</b> <?php question('Form 3',2); ?></p>
    <div class="row justify-content-center">
      
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q3_1" name="form3q3" class="custom-control-input" <?php if (isset($form3q3) && $form3q3=="5") echo "checked";?> value="5">
        <label class="custom-control-label" for="form3q3_1">Outstanding</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q3_2" name="form3q3" class="custom-control-input" <?php if (isset($form3q3) && $form3q3=="4") echo "checked";?> value="4">
        <label class="custom-control-label" for="form3q3_2">Very Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q3_3" name="form3q3" class="custom-control-input" <?php if (isset($form3q3) && $form3q3=="3") echo "checked";?> value="3">
        <label class="custom-control-label" for="form3q3_3">Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q3_4" name="form3q3" class="custom-control-input" <?php if (isset($form3q3) && $form3q3=="2") echo "checked";?> value="2">
        <label class="custom-control-label" for="form3q3_4">Fair</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q3_5" name="form3q3" class="custom-control-input" <?php if (isset($form3q3) && $form3q3=="1") echo "checked";?> value="1">
        <label class="custom-control-label" for="form3q3_5">Poor</label>
      </div>
    </div>
    <!-- FORM 3 Q4 -->
    <hr>
    <p class="text-left"><b>4.</b> <?php question('Form 3',3); ?></p>
    <div class="row justify-content-center">
      
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q4_1" name="form3q4" class="custom-control-input" <?php if (isset($form3q4) && $form3q4=="5") echo "checked";?> value="5">
        <label class="custom-control-label" for="form3q4_1">Outstanding</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q4_2" name="form3q4" class="custom-control-input" <?php if (isset($form3q4) && $form3q4=="4") echo "checked";?> value="4">
        <label class="custom-control-label" for="form3q4_2">Very Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q4_3" name="form3q4" class="custom-control-input" <?php if (isset($form3q4) && $form3q4=="3") echo "checked";?> value="3">
        <label class="custom-control-label" for="form3q4_3">Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q4_4" name="form3q4" class="custom-control-input" <?php if (isset($form3q4) && $form3q4=="2") echo "checked";?> value="2">
        <label class="custom-control-label" for="form3q4_4">Fair</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q4_5" name="form3q4" class="custom-control-input" <?php if (isset($form3q4) && $form3q4=="1") echo "checked";?> value="1">
        <label class="custom-control-label" for="form3q4_5">Poor</label>
      </div>
    </div>
    <!-- FORM 3 Q5 -->
    <hr>
    <p class="text-left"><b>5.</b> <?php question('Form 3',4); ?></p>
    <div class="row justify-content-center">
      
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q5_1" name="form3q5" class="custom-control-input" <?php if (isset($form3q5) && $form3q5=="5") echo "checked";?> value="5">
        <label class="custom-control-label" for="form3q5_1">Outstanding</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q5_2" name="form3q5" class="custom-control-input" <?php if (isset($form3q5) && $form3q5=="4") echo "checked";?> value="4">
        <label class="custom-control-label" for="form3q5_2">Very Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q5_3" name="form3q5" class="custom-control-input" <?php if (isset($form3q5) && $form3q5=="3") echo "checked";?> value="3">
        <label class="custom-control-label" for="form3q5_3">Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q5_4" name="form3q5" class="custom-control-input" <?php if (isset($form3q5) && $form3q5=="2") echo "checked";?> value="2">
        <label class="custom-control-label" for="form3q5_4">Fair</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form3q5_5" name="form3q5" class="custom-control-input" <?php if (isset($form3q5) && $form3q5=="1") echo "checked";?> value="1">
        <label class="custom-control-label" for="form3q5_5">Poor</label>
      </div>
    </div>
  </div>
</div>
<!-- END of FORM 3 -->
<!-- ---------------- -->

<!-- FORM 4 -->
<div class="collapse <?php  echo $retVal = (isset($form4_show)) ? "show" : "" ; ?>" id="collapseExample4" data-parent="#accordion">
  <div class="card card-body">
    <h6 class="text-left alert alert-info"><?php evaluated_person(); ?><i class=""> | </i>Management of Learning</h6>
    <!-- FORM 4 Q1 -->
    <hr>
    <p class="text-left"><b>1.</b> <?php question('Form 4',0); ?></p>
    <div class="row justify-content-center">
      
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q1_1" name="form4q1" class="custom-control-input" <?php if (isset($form4q1) && $form4q1=="5") echo "checked";?> value="5">
        <label class="custom-control-label" for="form4q1_1">Outstanding</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q1_2" name="form4q1" class="custom-control-input" <?php if (isset($form4q1) && $form4q1=="4") echo "checked";?> value="4">
        <label class="custom-control-label" for="form4q1_2">Very Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q1_3" name="form4q1" class="custom-control-input" <?php if (isset($form4q1) && $form4q1=="3") echo "checked";?> value="3">
        <label class="custom-control-label" for="form4q1_3">Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q1_4" name="form4q1" class="custom-control-input" <?php if (isset($form4q1) && $form4q1=="2") echo "checked";?> value="2">
        <label class="custom-control-label" for="form4q1_4">Fair</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q1_5" name="form4q1" class="custom-control-input" <?php if (isset($form4q1) && $form4q1=="1") echo "checked";?> value="1">
        <label class="custom-control-label" for="form4q1_5">Poor</label>
      </div>
    </div>
    <!-- FORM 4 Q2 -->
    <hr>
    <p class="text-left"><b>2.</b> <?php question('Form 4',1); ?></p>
    <div class="row justify-content-center">
      
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q2_1" name="form4q2" class="custom-control-input" <?php if (isset($form4q2) && $form4q2=="5") echo "checked";?> value="5">
        <label class="custom-control-label" for="form4q2_1">Outstanding</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q2_2" name="form4q2" class="custom-control-input" <?php if (isset($form4q2) && $form4q2=="4") echo "checked";?> value="4">
        <label class="custom-control-label" for="form4q2_2">Very Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q2_3" name="form4q2" class="custom-control-input" <?php if (isset($form4q2) && $form4q2=="3") echo "checked";?> value="3">
        <label class="custom-control-label" for="form4q2_3">Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q2_4" name="form4q2" class="custom-control-input" <?php if (isset($form4q2) && $form4q2=="2") echo "checked";?> value="2">
        <label class="custom-control-label" for="form4q2_4">Fair</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q2_5" name="form4q2" class="custom-control-input" <?php if (isset($form4q2) && $form4q2=="1") echo "checked";?> value="1">
        <label class="custom-control-label" for="form4q2_5">Poor</label>
      </div>
    </div>
    <!-- FORM 4 Q3 -->
    <hr>
    <p class="text-left"><b>3.</b> <?php question('Form 4',2); ?></p>
    <div class="row justify-content-center">
      
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q3_1" name="form4q3" class="custom-control-input" <?php if (isset($form4q3) && $form4q3=="5") echo "checked";?> value="5">
        <label class="custom-control-label" for="form4q3_1">Outstanding</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q3_2" name="form4q3" class="custom-control-input" <?php if (isset($form4q3) && $form4q3=="4") echo "checked";?> value="4">
        <label class="custom-control-label" for="form4q3_2">Very Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q3_3" name="form4q3" class="custom-control-input" <?php if (isset($form4q3) && $form4q3=="3") echo "checked";?> value="3">
        <label class="custom-control-label" for="form4q3_3">Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q3_4" name="form4q3" class="custom-control-input" <?php if (isset($form4q3) && $form4q3=="2") echo "checked";?> value="2">
        <label class="custom-control-label" for="form4q3_4">Fair</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q3_5" name="form4q3" class="custom-control-input" <?php if (isset($form4q3) && $form4q3=="1") echo "checked";?> value="1">
        <label class="custom-control-label" for="form4q3_5">Poor</label>
      </div>
    </div>
    <!-- FORM 4 Q4 -->
    <hr>
    <p class="text-left"><b>4.</b> <?php question('Form 4',3); ?></p>
    <div class="row justify-content-center">
      
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q4_1" name="form4q4" class="custom-control-input" <?php if (isset($form4q4) && $form4q4=="5") echo "checked";?> value="5">
        <label class="custom-control-label" for="form4q4_1">Outstanding</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q4_2" name="form4q4" class="custom-control-input" <?php if (isset($form4q4) && $form4q4=="4") echo "checked";?> value="4">
        <label class="custom-control-label" for="form4q4_2">Very Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q4_3" name="form4q4" class="custom-control-input" <?php if (isset($form4q4) && $form4q4=="3") echo "checked";?> value="3">
        <label class="custom-control-label" for="form4q4_3">Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q4_4" name="form4q4" class="custom-control-input" <?php if (isset($form4q4) && $form4q4=="2") echo "checked";?> value="2">
        <label class="custom-control-label" for="form4q4_4">Fair</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q4_5" name="form4q4" class="custom-control-input" <?php if (isset($form4q4) && $form4q4=="1") echo "checked";?> value="1">
        <label class="custom-control-label" for="form4q4_5">Poor</label>
      </div>
    </div>
    <!-- FORM 4 Q5 -->
    <hr>
    <p class="text-left"><b>5.</b> <?php question('Form 4',4); ?></p>
    <div class="row justify-content-center">
      
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q5_1" name="form4q5" class="custom-control-input" <?php if (isset($form4q5) && $form4q5=="5") echo "checked";?> value="5">
        <label class="custom-control-label" for="form4q5_1">Outstanding</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q5_2" name="form4q5" class="custom-control-input" <?php if (isset($form4q5) && $form4q5=="4") echo "checked";?> value="4">
        <label class="custom-control-label" for="form4q5_2">Very Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q5_3" name="form4q5" class="custom-control-input" <?php if (isset($form4q5) && $form4q5=="3") echo "checked";?> value="3">
        <label class="custom-control-label" for="form4q5_3">Satisfactory</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q5_4" name="form4q5" class="custom-control-input" <?php if (isset($form4q5) && $form4q5=="2") echo "checked";?> value="2">
        <label class="custom-control-label" for="form4q5_4">Fair</label>
      </div>
      <div class="flex-item custom-control custom-radio border rounded custom-control-inline" style="padding-right:2px; padding-left: 1.3rem; margin-bottom: 10px;">
        <input type="radio" id="form4q5_5" name="form4q5" class="custom-control-input" <?php if (isset($form4q5) && $form4q5=="1") echo "checked";?> value="1">
        <label class="custom-control-label" for="form4q5_5">Poor</label>
      </div>
    </div>
  </div>
</div>
<!-- END of FORM 4 -->
<!-- ---------------- -->
<!-- FORM 5 -->
<div class="collapse <?php  echo $retVal = (isset($form5_show)) ? "show" : "" ; ?>" id="collapseExample5" data-parent="#accordion">
  <div class="card card-body">
    <h6 class="text-center alert alert-info">Comment</h6>
    <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
    <!-- FORM 5 Q1 -->
    <hr>
  </div>
</div>
<!-- END of FORM 5 -->
<!-- ---------------- -->
<!-- FORM 6 -->
<div class="collapse <?php  echo $retVal = (isset($form6_show) || query_method()[0]==false) ? "" : "show" ; ?>" id="collapseExample6" data-parent="#accordion">
  <div class="card card-body">
    <br>
    <input type="submit" name="submit" value="Submit" class="btn btn-success btn-lg btn-block">
    <br>
    <h6 class="text-left alert alert-info">Summary of Ratings</h6>
    <script src="js/highcharts.js"></script>
    <script src="js/highcharts-3d.js"></script>
    <script src="js/exporting.js"></script>
    <div id="containergraph" style="min-width: 80%; max-width: 50%; height: 400px; margin: 0 auto"></div>
    <script type="text/javascript">
    Highcharts.chart('containergraph', {
    chart: {
    type: 'column',
    options3d: {
    enabled: true,
    alpha: 10,
    beta: 25,
    depth: 70
    }
    },
    title: {
    text: ''
    },
    subtitle: {
    text: ''
    },
    plotOptions: {
    column: {
    depth: 25
    }
    },
    xAxis: {
    categories: ['Evaluation Ratings'],
    labels: {
    skew3d: true,
    style: {
    fontSize: '16px'
    }
    }
    },
    yAxis: {
    title: {
    text: 'Percentage'
    }
    },
    series: [{
    name: 'QCE Form1',
    data: [<?php echo ((($form1q1+$form1q2+$form1q3+$form1q4+$form1q5)/25)*100); ?>],
    
    },{
    name: 'QCE Form2',
    data: [<?php echo ((($form2q1+$form2q2+$form2q3+$form2q4+$form2q5)/25)*100); ?>]
    },{
    name: 'QCE Form3',
    data: [<?php echo ((($form3q1+$form3q2+$form3q3+$form3q4+$form3q5)/25)*100); ?>]
    },{
    name: 'QCE Form4',
    data: [<?php echo ((($form4q1+$form4q2+$form4q3+$form4q4+$form4q5)/25)*100); ?>]
    }]
    });
    </script>
    <hr>
  </div>
</div>
<!-- END of FORM 6 -->
<!-- ---------------- -->

</div>

</form>


<br>
<?php 


#echo htmlspecialchars($_SERVER["PHP_SELF"])."?id=".$_GET['id'];
// echo $form1q1 ." ". $form1q2 . " " . $form1q3 . " " . $form1q4 . " " . $form1q5;
// echo "<hr>";
// echo $form2q1 ." ". $form2q2 . " " . $form2q3 . " " . $form2q4 . " " . $form2q5;
// echo "<hr>";
// echo $form3q1 ." ". $form3q2 . " " . $form3q3 . " " . $form3q4 . " " . $form3q5;
// echo "<hr>";
// echo $form4q1 ." ". $form4q2 . " " . $form4q3 . " " . $form4q4 . " " . $form4q5;
// echo "<hr>";
// echo $comment;
?>
</div>
<!-- ---------------------- -->
<!-- END BODY -->
<?php require_once("footer.php"); ?>