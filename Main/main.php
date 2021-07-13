<!-- This is the main page for the web application. This is where the user can add, edit, delete and view 
  the courses for GWA computation. -->

<html>
<?php
    session_start();
    require  "../Database.php";
    $PDO = Database::letsconnect();
    //Initialization of session variables
    if(!isset($_SESSION['Years']))
        $_SESSION['Years'] = array();
    if(!isset($_SESSION['Courses']))
        $_SESSION['Courses'] = array();
    if(!isset($_SESSION['Counter']))
        $_SESSION['Counter'] = 0;
    if(!isset($_SESSION['checkEdit']))
        $_SESSION['checkEdit'] = 0;
    if(!isset($_SESSION['EditID']))
        $_SESSION['EditID'] = "";
    if(!isset($_SESSION['CourseEdit']))
        $_SESSION['CourseEdit'] = array();
    if(!isset($_SESSION['checkDelete']))
        $_SESSION['checkDelete'] = 0;
    if(!isset($_SESSION['checkDeleteSem']))
        $_SESSION['checkDeleteSem'] = 0;
    if(!isset($_SESSION['CourseDeleteSem']))
        $_SESSION['CourseDeleteSem'] = "";
    if(!isset($_SESSION['CourseDeleteID']))
        $_SESSION['CourseDeleteID'] = "";
    if(!isset($_SESSION['YearandSem']))
       $_SESSION['YearandSem'] = array();
    if(!isset($_SESSION['YearandSemGWA']))
       $_SESSION['YearandSemGWA'] = array();
    if(!isset($_SESSION['countyearsem']))
       $_SESSION['countyearsem'] = 0;
    if(!isset($_SESSION['GWA']))
       $_SESSION['GWA'] = 0;
   //SESSION ID CHECK
    if (empty($_SESSION['UserID']))
         header("Location: ../Log_In/login.php");
     if ($_SESSION['Type'] == "Admin")
         header("Location: ../Main/admin.php");
    
   
?>
<head>
	<title>SINGCO</title>
    <link rel="icon" href="../images/singco-logo.svg" type="image/icon type">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Modal-->
    <link rel="stylesheet" href="../Modal/modal.css">
    <link rel="stylesheet" href="../css/main.css" type="text/css">
    <script src="../Modal/popper.min.js"></script>
    <script src="../Modal/bootstrap.min.js"></script>
    <!-- Modal-->
    <script src = "../js/modalform.js"></script>
    <script src = "../js/main.js"> </script>
     <!-- Upload Modal-->
    <script src="../js/dragndrop2.js"></script>
    <link rel="stylesheet" href="../css/dragndrop2.css">
    <link rel="stylesheet" href="../Modal/modalUpload.css">
     <!-- Upload Modal-->
     <!-- ICONS -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Select and Search -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>

<?php
    include "main_modals.php";
    include "multiple_inputs.php";
    //Shows the Edit modal after redirecting from keyprocess.php
    if($_SESSION['checkEdit'] > 0) {
      $_SESSION['checkEdit']=0;
      echo '<script>
              $(document).ready(function(){
              $("#edit-modal").modal("show");});
          </script>';
    }
    //Shows the Delete modal after redirecting from keyprocess.php
    if($_SESSION['checkDelete'] > 0) {
      $_SESSION['checkDelete']=0;
      echo '<script>
              $(document).ready(function(){
              $("#delete-modal").modal("show");});
          </script>';
    }
    //Shows the Delete Sem modal after redirecting from keyprocess.php
    if($_SESSION['checkDeleteSem'] > 0) {
      $_SESSION['checkDeleteSem']=0;
      echo '<script>
              $(document).ready(function(){
              $("#delete-sem-modal").modal("show");});
          </script>';
  }
    
     
?>


<body id="home">
<!-- add navigation bar here -->
<div class="main_container">
<!-- ADD BUTTON -->
  <div id="add_btn_overlay">
    <button onclick="modal()" id="add_btn" title="Add"> <i data-feather="plus"></i> </button>
  </div>
<!-- -->
<!-- LOGO -->
<nav id="home">
  <div class="nav_overlay">
    <div class="left">
        <img src="../images/singco-logo.svg" class="navlogo"alt="" width="28px">
    </div>
    <div class="middle">
        <a href="main.php" title="Home"><i data-feather="home" onclick="home()" title="Home"></i></a>
      <i data-feather="upload-cloud" onclick="modalupload()" title="Upload"></i>
      <i data-feather="rotate-ccw" onclick="resetmodal()" title="Reset\Clear"></i>
      <i data-feather="printer" onclick="printmodal()" title="Print"></i>
    </div>
    <div class="right">
        <h4 class="username"><?php echo $_SESSION['UserName'];?></h4>
      <a onclick="logoutmodal()"><i data-feather="log-out" id="log_out" title="Logout"></i></a>
    </div>
  </div>
</nav>
<script type="text/javascript">
  feather.replace();

</script>

<?php
//ADD SUBJECT/S START
	if(isset($_POST['btncontinue'])) {
        $courses = array();
        $year = $_POST['acad-year'];
        $semester = $_POST['semester'];
        if(isset($_POST['rowCount'])) {
            $rowCount = $_POST['rowCount'];
        }
        for($i = 1; $i <= $rowCount; $i++) {
            $currentCourse = "course" . $i;
            //Check if name exists
            if(isset($_POST[$currentCourse])) {
                $currentGrade = "grade" . $i;
                $currentRemovalGrade = "removal-grade" . $i;
                $course = $_POST[$currentCourse];
                foreach($PDO->query("SELECT * FROM checklist where CourseID='".$course."'") as $row3){
                    $units=$row3['Credit'];
                }
                $grade = $_POST[$currentGrade];
                if($_POST[$currentGrade] == "4.00")
                    $removal_grade = $_POST[$currentRemovalGrade];
                else
                    $removal_grade = "n/a";
                $lastid="CG-0";

                //Check if grade is an acceptable numerical grade and update the state based on the maxtakes
                if ($grade!="5.00" && $grade != "DFR" && $grade != "DRP" && $grade != "FAIL" && $grade != "INC" && $removal_grade != "5.00") {
                      $timesTaken = 0;
                      foreach($PDO->query("SELECT * FROM checklist WHERE CourseID = '".$course."'") as $row1)
                          $maxTakes = $row1['MaxTakes'];
                      foreach($PDO->query("SELECT * FROM grades WHERE course = '".$course."'") as $row2)
                          $timesTaken++;
                      if($timesTaken >= $maxTakes-1) {
                        $sql = "UPDATE grades SET state = '1' WHERE course = '".$course."'";
                        $exec = $PDO->prepare($sql);
                        $exec->execute();
                        $state = "1";
                      } else {$state=NULL;}
                }
                else {$state=NULL;}
                foreach($PDO->query("Select * from grades where user_id='".$_SESSION['UserID']."'") as $row)
                    $lastid = $row['grade_id'];
                $cut = explode('-', $lastid);
                $generated=(int)$cut[1]+1;
                $grade_id="CG"."-".str_pad($generated, 4, "0", STR_PAD_LEFT);
                $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO grades(user_id,grade_id, year, semester, course,state,units, grade, removal_grade) VALUES(?,?, ?, ?, ?, ?, ?, ?, ?)";
                $exec = $PDO->prepare($sql);
                $exec->execute([$_SESSION['UserID'],$grade_id, $year, $semester, $course, $state, $units, $grade, $removal_grade, ]);
            }
        }
  }
//ADD SUBJECT/S END

//EDIT SUBJECT START
  if(isset($_POST['btnsave'])) {

    $year = $_POST['acad-year-edit'];
    $semester = $_POST['semester-edit'];
    $course = $_POST['course-edit'];

    foreach($PDO->query("SELECT * FROM checklist where CourseID='".$course."'") as $row3){
         $units=$row3['Credit'];
    }

    $grade = $_POST['grade-edit'];

    if($_POST['grade-edit'] == "4.00")
        $removal_grade = $_POST['removal-grade-edit'];
    else
        $removal_grade="n/a";

    //Check pre-edited course if maxtakes > 1
    foreach($PDO->query("SELECT * FROM grades WHERE grade_id = '".$_SESSION['EditID']."' AND user_id='".$_SESSION['UserID']."'") as $row) {
        foreach($PDO->query("SELECT * FROM checklist WHERE CourseID = '".$row['course']."'") as $row2) {
            if($row2['MaxTakes'] > 1) {
                if($row2['CourseID'] != $course) { //Check if pre-edited course name is not equal to the edited course name
                    foreach($PDO->query("SELECT * FROM grades WHERE course = '".$row['course']."'") as $row3) {
                        $PDO->query("UPDATE grades SET state = NULL WHERE course = '".$row['course']."'");
                    }
                }
            }
        }
    }

    $edit = "UPDATE grades SET year = '".$year."', semester = '".$semester."', course = '".$course."', units = '".$units."', grade = '".$grade."',removal_grade = '".$removal_grade."' WHERE grade_id = '" . $_SESSION['EditID'] . "' and user_id='".$_SESSION['UserID']."'";
    $q = $PDO->prepare($edit);
    $q->execute();

    // After updting course, check if new course reached MaxTakes
    if ($grade!="5.00" && $grade != "DFR" && $grade != "DRP" && $grade != "FAIL" && $grade != "INC" && $removal_grade != "5.00") {
        $timesTaken = 0;
        foreach($PDO->query("SELECT * FROM checklist WHERE CourseID = '".$course."'") as $row1)
            $maxTakes = $row1['MaxTakes'];
        foreach($PDO->query("SELECT * FROM grades WHERE course = '".$course."'") as $row2)
            $timesTaken++;
        if($timesTaken >= $maxTakes) {
          $sql = "UPDATE grades SET state = '1' WHERE course = '".$course."'";
          $exec = $PDO->prepare($sql);
          $exec->execute();
          $state = "1";
        } else {$state=NULL;}
    }
    else {
        $sql = "UPDATE grades SET state = NULL WHERE course = '".$course."'";
        $exec = $PDO->prepare($sql);
        $exec->execute();
    }

    echo "<meta http-equiv='refresh' content='0'>";
  }
//EDIT SUBJECT END

//DELETE SEM START
  if(isset($_POST['btndeletesem'])) {
      $cut = explode(" ", $_SESSION['CourseDeleteSem']);
      //Check if courses in the sem have MaxTakes > 1. If yes, store in an array
      $semcourses = array();
      $sql = "SELECT * FROM grades WHERE year = '".$cut[0]."' and semester='".$cut[1]." ".$cut[2]."' and user_id='".$_SESSION['UserID']."'";
      foreach($PDO->query($sql) as $row) {
          foreach($PDO->query("SELECT * FROM checklist WHERE CourseID = '".$row['course']."'") as $row2) {
              if($row2['MaxTakes'] > 1) {
                    array_push($semcourses, $row2['CourseID']);
              }
          }
      }
      //Traverse array of courses with MaxTakes > 1 and update the state of those courses in the grades table to NULL
      foreach($semcourses as $removecourse) {
          $PDO->query("UPDATE grades SET state = NULL WHERE course = '".$removecourse."'");
      }

      //Check which semester to delete
      if ($cut[1]=="First"|| $cut[1]=="Second"){
         $PDO->query("DELETE FROM grades WHERE year= '" .$cut[0]. "'   and semester='".$cut[1]." ".$cut[2]."' and user_id='".$_SESSION['UserID']."'");
      }
      else{
           $PDO->query("DELETE FROM grades WHERE year= '" .$cut[0]. "'   and semester='".$cut[1]."' and user_id='".$_SESSION['UserID']."'");
      }

      echo "<meta http-equiv='refresh' content='0'>";
  } 
//DELETE SEM END

//DELETE SUBJECT START
  if(isset($_POST['btndelete'])) {
      //Update state of other entries of same subject if it exists to NULL
      foreach($PDO->query("SELECT * FROM grades WHERE grade_id = '".$_SESSION['CourseDeleteID']."' AND user_id='".$_SESSION['UserID']."'") as $row) {
          foreach($PDO->query("SELECT * FROM checklist WHERE CourseID = '".$row['course']."'") as $row2) {
              if($row2['MaxTakes'] > 1) {
                  foreach($PDO->query("SELECT * FROM grades WHERE course = '".$row['course']."'") as $row3) {
                      $PDO->query("UPDATE grades SET state = NULL WHERE course = '".$row['course']."'");
                  }
              }
          }
      }
      $PDO->query("DELETE FROM grades WHERE grade_id = '" .$_SESSION['CourseDeleteID'] . "' and user_id='".$_SESSION['UserID']."'");
  }
//DELETE SUBJECT END

//SAVE PRINT INFO
  if(isset($_POST['btnproceed'])) {
        //Check if current GWA is acceptable
        if($_SESSION['GWA']==0 || $_SESSION['GWA']==NAN) {
          echo '<script>
                  $(document).ready(function(){
                  $("#emptyinput-modal").modal("show");});
              </script>';
        }
        else{//Obtaining information from Print modal
            $_SESSION['StudentName'] = $_POST['firstname'] . " " . substr($_POST['middleinitial'], 0, 1) . ". " . $_POST['lastname'];
            $_SESSION['LastName'] = $_POST['lastname'];
            $_SESSION['Gender'] = $_POST['gender'];
            $_SESSION['Degree'] = $_POST['degree'];
            $_SESSION['Purpose'] = $_POST['purpose'];
            $gwaselection=$_POST['gwaselection'];
            $sum=0;
            $additionalinfo="";

          //Check which GWA to compute (Overall or Pick Semesters)
          if ($gwaselection=="100"){
                foreach($_POST['check_list'] as $row){
                    $sum+=$row;
                }
                $gwa =  $sum/count($_POST['check_list']);
                $additionalinfo=$_POST['additionalinfo'];
            }
            else{
                $txt="GWA";
                $gwa=$_SESSION['GWA'];
            }

        if ($_POST['laude']=="yes"){
            //Checking if GWA falls under the the range of laudes
            if ($gwa <= 1.75 && $gwa >= 1.0) {
                $_SESSION['IsLaude'] = 1;
                    if ($gwa <= 1.75 && $gwa > 1.5)
                        $_SESSION['Laude'] = "cum laude";
                    else if ($gwa <= 1.5 && $gwa > 1.25)
                        $_SESSION['Laude'] = "magna cum laude";
                    else if ($gwa <= 1.25 && $gwa >= 1.0)
                        $_SESSION['Laude'] = "summa cum laude";
            } else
                $_SESSION['IsLaude'] = 0;
        } else
            $_SESSION['IsLaude'] = 0;

        $date = date("jS") . "-" . date("F") . "-" . date("Y");

        if ($_SESSION['IsLaude'] == 1) {
            $laudecert = $_SESSION['Laude'] ;
        } else {
            $laudecert = 0;
        }

        if(preg_match("/[a-z]/i", $additionalinfo)==false)
            $additionalinfo="";

        $PDO->query("DELETE FROM certificate WHERE user_id= '" .$_SESSION['UserID']. "'");

        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO certificate(user_id, gwa, first_name, middle_initial, last_name, gender, degree, purpose, date, college, college_sec, is_laude, add_info) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $exec = $PDO->prepare($sql);
        $exec->execute([$_SESSION['UserID'], round(bcdiv($gwa, 1, 5),4), $_POST['firstname'], substr($_POST['middleinitial'], 0, 1), $_POST['lastname'], $_POST['gender'], $_POST['degree'], $_POST['purpose'], $date, $_POST['college'], $_POST['collegesec'], $laudecert, $additionalinfo]);

         echo "<meta http-equiv='refresh' content='0.0001; url=../Output/certsample.php'>";
      }
}//SAVE PRINT INFO END

//----------------------------------------------------------------------------------
//FILE UPLOAD SCAN AND SAVE DATABASE
    if(isset($_POST['btnupload'])){
        if($_FILES["file"]["error"] == 4) {//if empty or not
               echo '<script>
              $(document).ready(function(){
              $("#empty-modal").modal("show");});
          </script>';
        }
        else{
            $filename=$_FILES['file']['name'];
            $filepath=__DIR__."\\".$filename;
            $extension=explode('.', $filename);

            if ($extension[1]=="txt"){
                $mv = move_uploaded_file($_FILES['file']['tmp_name'], $filepath);
                $file = fopen( $filepath, "r") or die("Unable to open file!");

                // Number_Courses_Per_Sem_Year count
                $count_ncps=-1;
                //count ng sem
                $sem_year_count=0;
                //count of grades, years, units
                $subjects_grades_units_count=0;
                //the number line on the orig text file
                $numline=-1;
                //Compute valids
                $UnitsSum=0;
                $GradesxUnitsSum=0;
                //flag for exceeding course title for next lines
                $flag=false;
                $longtitle="";
                $Semester="";
                $Year="";
                $Subject="";
                $Grade="";
                $Unit="";
                $Removal_Grade="";

                while(!feof($file)) {
                    $line=fgets($file);
                    $numline++;

                    if (strpos($line,"|")==true && strpos($line,"UP BAGUIO")==false){
                        //for the conditions of having a second line for long course titles 
                        $cutcoursetitle=explode('|', $line);
                        $s1=preg_match('/[A-Za-z]/i', $cutcoursetitle[0]);
                        $s2=preg_match('/[A-Za-z]/i', $cutcoursetitle[1]);
                        $s3=preg_match('/[A-Za-z]/i', $cutcoursetitle[2]);
                        $s4=preg_match('/[A-Za-z]/i', $cutcoursetitle[3]);
                        $s5=preg_match('~[0-9]+~', $cutcoursetitle[0]);
                        $s6=preg_match('~[0-9]+~', $cutcoursetitle[1]);
                        $s7=preg_match('~[0-9]+~', $cutcoursetitle[2]);
                        $s8=preg_match('~[0-9]+~', $cutcoursetitle[3]);
                        
                        //Scanning the Sems or Summeer
                        if (strpos($line,"Semester")==true || strpos($line,"ummer")==true){
                            $cut=explode('|', $line);
                            $_SESSION['Sem_Year'][$sem_year_count]=$cut[0];
                            $sem_year_count++;
                            $count_ncps++;
                            $_SESSION['Number_Courses_Per_Sem_Year'][ $count_ncps]=0;

                            //SEMESTER AND YEAR
                            $letters=str_split($cut[0]);
                            for ($x=0;$x<count($letters);$x++){
                                if (preg_match('~[0-9]+~', $letters[$x])){
                                    $num=$x;
                                    break;}
                            }
                            $Semester=trim(substr($cut[0],0,$num));
                            $Year=trim(substr($cut[0],$num));
                        }//if for sem and year

                        //for the long titles
                        else if(($s1||$s5)&&($s2==false && $s3==false && $s4==false && $s6==false && $s7==false && $s8==false)){
                           $flag=true;
                            $longtitle=$longtitle." ".trim($cutcoursetitle[0]);
                        }
                        //Scanning the grade and unit in a line
                        else if(preg_match('~[0-9]+~', $line) || strpos($line,"DRP")||$flag||strpos($line,"FAIL")){
                            $cut=explode('|', $line);
                            $trimgrade=trim($cut[1]," ");
                            $trimremoval=trim($cut[2]," ");
                            $snip=trim($cut[3]," ");
                            $trimunit = str_replace("\n", '', $snip); // remove new lines
                            $trimunit = str_replace("\r", '', $trimunit); // remove carriage returns

                            if ($flag==true){
                                $flag=false;
                                $longtitle=$longtitle." ".$cutcoursetitle[0];
                                $_SESSION['Subjects'][$subjects_grades_units_count]=strtolower($longtitle);
                                $Subject=trim(preg_replace('/\s+/', ' ' , strtoupper($longtitle)));
                                $longtitle="";

                                //SUBJECT
                                if (strpos(strtoupper($Subject),"N S T P")!==false){
                                    $Subject=str_replace("N S T P","NSTP",$Subject);
                                }

                                elseif (strpos(strtoupper($Subject),"P.I.")!==false){
                                    $Subject=str_replace("P.I.","PI",$Subject);
                                }

                                $letters=explode(' ',$Subject);
                                $id_match=array();
                                $name_match=array();
                                $cmatch=0;
                                $concat=$letters[0];
                                $last="";
                                // Scanning the Course if it is in the database
                                 for ($x=1;$x<count($letters);$x++){
                                     $concat=$concat." ".$letters[$x];
                                   
                                    foreach($PDO->query("Select * from checklist") as $row){
                                        $id = $row['CourseID'];
                                        $coursename = $row['CourseName'];
                                        $coursedesc = $row['CourseDesc'];

                                        if (strpos($coursename,strtoupper($concat))!==false){
                                            $id_match[$cmatch]=$id;
                                            $name_match[$cmatch]=$coursename;
                                            $cmatch++;

                                            if(strpos($Subject,$coursedesc)!==false){
                                                $Subject=$id;
                                            }
                                        }
                                    }//foreach
                                 }//forloop

                                if($cmatch==0)
                                    $Subject=ucwords(strtolower($Subject));
                                elseif (strpos($Subject,"CS-")===false){
                                    for ($x=0;$x<$cmatch;$x++){
                                        if (strpos($Subject,$name_match[$x])!==false){
                                           // echo "YES";
                                            $Subject=$id_match[$x];
                                        }
                                    }
                                }

                            //SUBJECT


                            }//-----------------------------------------------------------
                            else{
                                $_SESSION['Subjects'][$subjects_grades_units_count]=strtolower($cut[0]);

                                //SUBJECT
                                $Subject=preg_replace('/\s+/', ' ' , $cut[0]);
                                if (strpos(strtoupper($Subject),"N S T P")!==false){
                                    $Subject=str_replace("N S T P","NSTP",$Subject);
                                }

                                elseif (strpos(strtoupper($Subject),"P.I.")!==false){
                                    $Subject=str_replace("P.I.","PI",$Subject);
                                }

                                $letters=explode(' ',$Subject);
                                $id_match=array();
                                $name_match=array();
                                $cmatch=0;
                                $concat=$letters[0];
                                $last="";
                                 for ($x=1;$x<count($letters);$x++){
                                     $concat=$concat." ".$letters[$x];
                                    foreach($PDO->query("Select * from checklist") as $row){
                                        $id = $row['CourseID'];
                                        $coursename = $row['CourseName'];
                                        $coursedesc = $row['CourseDesc'];

                                        if (strpos($coursename,strtoupper($concat))!==false){
                                            $id_match[$cmatch]=$id;
                                            $name_match[$cmatch]=$coursename;
                                            $cmatch++;

                                            if(strpos($Subject,$coursedesc)!==false){
                                                $Subject=$id;
                                            }
                                        }
                                    }//foreach
                                 }//forloop

                                if($cmatch==0)
                                    $Subject=ucwords(strtolower($Subject));
                                elseif (strpos($Subject,"CS-")===false){
                                    for ($x=0;$x<$cmatch;$x++){
                                        if (strpos($Subject,$name_match[$x])!==false){
                                           // echo "YES";
                                            $Subject=$id_match[$x];
                                        }
                                    }

                                }

                            //SUBJECT
                            }

                            if($trimgrade=="4.0"){
                                $rg=preg_replace('/\s+/', ' ' , $cut[2]);
                                if (is_numeric($rg)!==false || $rg==""||$rg==" " )
                                    $Removal_Grade="n/a";
                                else
                                    $Removal_Grade=trim($cut[2]);
                            }
                            else
                                $Removal_Grade="n/a";

                            $_SESSION['Grades'][$subjects_grades_units_count]=$cut[1];
                            $_SESSION['Units'][$subjects_grades_units_count]=$cut[3];
                            $Grade=trim($cut[1]);
                            $Unit=trim($cut[3]);

                            //SAVE TO THE DATABASE
                            $lastid="CG-0";
                            foreach($PDO->query("Select * from grades where user_id='".$_SESSION['UserID']."'") as $row)
                            $lastid = $row['grade_id'];
                            $cut = explode('-', $lastid);
                            $generated=(int)$cut[1]+1;
                            $grade_id="CG"."-".str_pad($generated, 4, "0", STR_PAD_LEFT);
                            $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $state=NULL;
                            if (is_numeric($Grade)){
                                if(strpos($Subject,"CS-")!==false && ((int)$Grade>=1.0 && (int)$Grade<=4.0))
                                      $state="1";
                            }
                            $sql = "INSERT INTO grades(user_id,grade_id, year, semester, course,state, units, grade, removal_grade) VALUES(?, ?, ?, ?, ?, ?, ?,?,?)";
                            $exec = $PDO->prepare($sql);
                            $exec->execute([$_SESSION['UserID'],$grade_id, trim($Year), $Semester, $Subject,$state ,$Unit, $Grade, $Removal_Grade]);
                            echo "<meta http-equiv='refresh' content='0.0001; url=../Main/main.php'>";
                            //SAVE TO THE DATABASE END
                
                            $subjects_grades_units_count++;
                            //add to grades and units if walang inc etc.
                            if (is_numeric($trimgrade) && is_numeric($trimunit)){
                                if ($trimgrade=="4.0" && is_numeric($trimremoval)){
                                    $UnitsSum+=floatval($trimunit);
                                    $GradesxUnitsSum+=3.0*$trimunit;
                                }
                                else{
                                    $UnitsSum+=floatval($trimunit);
                                    $GradesxUnitsSum+=$trimgrade*$trimunit;
                                }
                            }//if for grades and units
                            $_SESSION['Number_Courses_Per_Sem_Year'][$count_ncps]++;
                        }//if for course
                        else
                            continue;
                    }
                    else
                        continue;
                }//while end

                if ($GradesxUnitsSum==0 || $UnitsSum==0){
                     echo "<script>
                    $('#empty-txt-modal').modal('show');
                     </script>";
                }
                else{
                    $_SESSION['GWA']=$GradesxUnitsSum/$UnitsSum;
                //Separate the years from the String sem_year  and erase redundant years
                $s=0;
                for ($z=0;$z<count($_SESSION['Sem_Year']);$z++){
                    $letters=str_split($_SESSION['Sem_Year'][$z]);

                    for ($x=0;$x<count($letters);$x++){
                        if (preg_match('~[0-9]+~', $letters[$x])){
                            $num=$x;
                            break;}
                    }
                     $v=trim(substr($_SESSION['Sem_Year'][$z],0,$num));
                    $w=trim(substr($_SESSION['Sem_Year'][$z],$num));
                    $year=str_replace(" ", "", $w);
                    $f=false;

                    for($y=0;$y<count($_SESSION['Years']);$y++){
                        if ($_SESSION['Years'][$y]==$year){
                            $f=true;
                        }
                    }
                    if($f==false){
                         $_SESSION['Years'][$s]=$year;
                        $s++;
                    }
                }
                //Number of Sem per Year
                 $countsem=0;
                 for ($v=0;$v<count($_SESSION['Years']);$v++){
                    $countsem=0;
                    for ($u=0;$u<count( $_SESSION['Sem_Year']);$u++){
                        if(strpos($_SESSION['Sem_Year'][$u],$_SESSION['Years'][$v]))
                            $countsem++;
                     }
                      $_SESSION['Number_Sem_Per_Year'][$v]=$countsem;
                 }
                fclose($file);
                unlink($filepath);
                }
            }//if
            else {
                 echo '<script>
              $(document).ready(function(){
              $("#extension-modal").modal("show");});
          </script>';
            }
         }//else
    }//ifset

    //FILE UPLOAD SCAN AND SAVE DATABASE END
//-------------------------------------------------------------------------------------------------------

//START CODE DISPLAY TABLE
  //Arranging the Years
  $count=0;
  $years=array();
  $sql = "SELECT * FROM grades  where user_id='".$_SESSION['UserID']."' ORDER BY year ASC, semester ASC";
      foreach($PDO->query($sql) as $row){
          $flag=false;
          for ($y=0;$y<count($years);$y++){
              if ($row['year']==$years[$y])
                  $flag=true;
          }
           if ($flag==false){
               $years[$count]=$row['year'];
              $count++;
          }
      }
    
      $yearandsem=array();
      $yearandsemgwa=array();
      $countyearsem=0;
      $sumgwaxunit2=0;
      $sumunit2=0;
      for ($a=0;$a<count($years);$a++){
          echo
          '<br><br><div class="acad_year_text">  Academic Year '.$years[$a].' </div>
               <div class="table_container">';

          //Semester
          $temp="";
          $sql1 = "SELECT * FROM grades where year='".$years[$a]."' and user_id='".$_SESSION['UserID']."' ORDER BY year ASC, semester ASC";
          foreach($PDO->query($sql1) as $row1){
             $sem=$row1['semester'];
             if ($temp!=$row1['semester']){
                  $temp=$row1['semester'];
                 $yearandsem[$countyearsem]=$years[$a]." ".$sem;
            $link_edit='keyprocess.php?variable=deletesem_'.$years[$a]."_".$sem;
             echo'<div class="table_overlay">
             <table class = "table_items">
                          <thead>
                               <tr>
                                <th colspan="5" scope="colgroup" class="semester_text">'.$sem.'
                                  <a href = keyprocess.php?variable=deletesem_'.$years[$a]."_".$sem.'>
                                    <button type="submit" class="deletesem" id="delete_sem">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                  </a>
                                </th>
                               </tr>
                          </thead>
                          <tbody>
                               <tr>
                                    <th>Subjects</th>
                                    <th>Final Grade</th>
                                    <th>Removal Grade</th>
                                    <th>Credit</th>
                                    <th>Menu</th>
                               </tr>';

                          //Grades
                          $gwasem=0;
                          $sumgwaxunit=0;
                          $sumunit=0;
                          $sql2 = "SELECT * FROM grades where year='".$years[$a]."' and semester='".$sem."' and user_id='".$_SESSION['UserID']."'  ORDER BY year ASC, semester ASC";
                               foreach($PDO->query($sql2) as $row2){
                                    echo '<tr class="row-highlight">';
                                    //Scanning if the grades row have courses in the database or not 
                                    if (strpos($row2['course'],"CS-")===false)
                                        echo'<td style="text-align: left !important;">'.ucwords(strtolower($row2['course'])).'</td>';
                                    else{
                                        foreach($PDO->query("SELECT * FROM checklist where CourseID='".$row2['course']."'") as $row3)
                                            echo'<td style="text-align: left !important;">'.ucwords(strtolower($row3['CourseName'])).'</td>';
                                    }

                                    //final grade
                                    echo'
                                         <td>'.$row2['grade'].'</td>';
                                     //removal grade
                                    if ($row2['grade']==4.0)
                                        if ($row2['removal_grade']==" "|| is_numeric($row2['removal_grade'])==false)
                                            echo "<td></td>";
                                         else
                                            echo'<td>'.bcdiv($row2['removal_grade'],1,2).'</td>';

                                    else echo'
                                         <td></td>';
                                         //units
                                         echo '
                                         <td>'.$row2['units'].'</td>';
                                         //menu
                                         echo'
                                         <td>
                                              <div class="dropdown menubutton">
                                              <i class="menu fas fa-bars "></i>
                                                   <div class="dropdown-menu">
                                                        <a  href = keyprocess.php?variable=edit_'.$row2['grade_id'] .'><button class="menu-button">More</button></a>
                                                        <a href = keyprocess.php?variable=delete_'.$row2['grade_id'] .'><button class="menu-button" name="btndelete">Delete</button></a>
                                                   </div>
                                              </div>
                                         </td>';

                                   if (is_numeric($row2['grade'])&&is_numeric($row2['units'])){
                                       //echo "yeah";
                                        if ($row2['grade']!=4.0){
                                           $sumgwaxunit+=$row2['grade']*$row2['units'];
                                           $sumgwaxunit2+=$row2['grade']*$row2['units'];
                                       }
                                       else if ($row2['grade']==4.0 &&is_numeric($row2['removal_grade'])){
                                            $sumgwaxunit+=$row2['removal_grade']*$row2['units'];
                                            $sumgwaxunit2+=$row2['removal_grade']*$row2['units'];
                                       }
                                       $sumunit+=$row2['units'];
                                       $sumunit2+=$row2['units'];
                                   }
                               }//loop_grades
                                if ($sumgwaxunit!=0 && $sumunit!=0){
                                    $gwasem= $sumgwaxunit/$sumunit;
                                }
                                $yearandsemgwa[$countyearsem]=$gwasem;
                                $countyearsem++;
                               //GWA
                               echo '
                               <tr>
                                   <td class="gwatext" style="text-align: left !important;">GWA</td>
                                   <td class="gwatext">'. round(bcdiv($gwasem, 1, 5),4).'</td>
                               </tr>
                          </tbody>
                     </table>
                    </div>';
              }
          }//loop_semester
              echo'</div>';
      }//loop_School year
    
    
    $rowcount=0;
    foreach($PDO->query("Select * from grades where  user_id='".$_SESSION['UserID']."'") as $r)
        $rowcount++;
    
    //Scanning if the GWA is zero and has zero rows in the database grades
    if ($sumgwaxunit2!=0||$rowcount!=0){
        if ($sumgwaxunit2!=0)
            $_SESSION['GWA']=$sumgwaxunit2/$sumunit2;
         echo '</div>
         <div class="gwa_container">
         <br><br><div class="acad_year_text2">  Overall GWA: <div="acad_year_text2" style="color:orange">'.round(bcdiv($_SESSION['GWA'], 1, 5),4).'</div></div>
         </div>';
    }
    else if ($rowcount==0){
        $_SESSION['GWA']=0;
         echo '<br><br><div class="acad_year_text3"> Please Add Inputs </div></div>';
    }
    $_SESSION['countyearsem']=$countyearsem;
    for ($x=0;$x<$countyearsem;$x++){
        $_SESSION['YearandSem'][$x]=$yearandsem[$x];
        $_SESSION['YearandSemGWA'][$x]=$yearandsemgwa[$x];
        }
//START CODE DISPLAY TABLE END
//-------------------------------------------------------------------------------------------------------
    ?>
</body>


</html>
