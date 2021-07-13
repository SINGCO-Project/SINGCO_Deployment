<!-- Temporary page for setting the session variables for all the CRUD processes of the web appliation-->

<?php
session_start();
//Obtaining the variable from the url which contains the information regarding
//which process to do and which session variables to set
$string = $_GET['variable'];
$cut = explode("_", $string);

//Setting of admin edit session variables
if($cut[0] == "adminedit") {
   if($cut[1] == "course") {
      $_SESSION['CheckCourseEdit'] = 1;
      $_SESSION['CheckCourseEditCollege'] = $cut[3];
      $_SESSION['CourseEditID']= $cut[2];
      echo "<meta http-equiv='refresh' content='0.0001; url = admin.php'>";   
   }
}

//Setting of admin delete session variables
if($cut[0] == "admindel") {
   if($cut[1] == "course") {
      $_SESSION['CheckCourseDelete'] = 1;
      $_SESSION['CheckCourseDeleteCollege'] = $cut[3];
      $_SESSION['CourseDeleteID'] = $cut[2];
      echo "<meta http-equiv='refresh' content='0.0001; url = admin.php'>";
   }
}

//Setting of session variables for editing user information
if($cut[0] == "adminuser-edit") {
     // echo "<script>alert('". $cut[1]."')</script>";
   $_SESSION['AdminUser-checkEdit'] = 1;
   $_SESSION['AdminUser-EditID']= $cut[1];
   echo "<meta http-equiv='refresh' content='0.0001; url = admin.php'>";
}

//Setting of session variables for deleting users
if($cut[0] == "adminuser-delete") {
   
   $_SESSION['AdminUser-checkDelete'] = 1;
   $_SESSION['AdminUser-DeleteID'] = $cut[1];
   echo "<meta http-equiv='refresh' content='0.0001; url = admin.php'>";
}

//Setting course edit session variables
if($cut[0] == "edit") {
   $_SESSION['checkEdit'] = 1;
   $_SESSION['EditID']= $cut[1];
   echo "<meta http-equiv='refresh' content='0.0001; url = main.php'>";
}

//Setting course delete session variables
if($cut[0] == "delete") {
   $_SESSION['checkDelete'] = 1;
   $_SESSION['CourseDeleteID'] = $cut[1];
   echo "<meta http-equiv='refresh' content='0.0001; url = main.php'>";
}

//Setting delete semester session variables
if($cut[0] == "deletesem") {
   $_SESSION['checkDeleteSem'] = 1;
   $_SESSION['CourseDeleteSem'] = $cut[1]." ".$cut[2]." Semester";
   echo "<meta http-equiv='refresh' content='0.0001; url = main.php'>";
}

?>