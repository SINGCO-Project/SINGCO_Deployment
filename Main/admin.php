<!-- This php file includes all the code for the admin page. This includes the 3 tabs on the menu which are home, users and courses divs. In the home div, the page provides the dashboard and boxes that provides the number of courses per colleges, plus the button to view their courses(table  with edit delete option). In the Users tab, provides the users table and an email section where the admin can send an email to the user such as informing their password. Moreover, the Course tab consists of table of all the courses. These tables consists of edit delete and add option where the admin can use to modify the database. Lastly, the modals (add, edit,delete) were also provided here for users and all the courses tables. -->

<html>
    <?php
    //globals
    $date = "";
    session_start();
    include "send_password.php";
    require  "../Database.php";
    $PDO = Database::letsconnect();
    //SESSION ID CHECK
    if (empty($_SESSION['UserID']))
         header("Location: ../Log_In/login.php");
    if ($_SESSION['Type'] == "User")
         header("Location: ../Main/main.php");
    //Initialization of Session variables
    if(!isset($_SESSION['AdminUser-EditID']))
        $_SESSION['AdminUser-EditID'] = 0;
    if(!isset($_SESSION['AdminUser-DeleteID']))
        $_SESSION['AdminUser-DeleteID'] = 0;
     if(!isset($_SESSION['AdminUser-checkEdit']))
        $_SESSION['AdminUser-checkEdit'] = 0;
    if(!isset($_SESSION['AdminUser-checkDelete']))
        $_SESSION['AdminUser-checkDelete'] = 0;
    if(!isset($_SESSION['CheckCourseEdit']))
        $_SESSION['CheckCourseEdit'] = 0;
    if(!isset($_SESSION['CourseEditID']))
        $_SESSION['CourseEditID'] = "";
    if(!isset($_SESSION['CheckCourseDelete']))
        $_SESSION['CheckCourseDelete'] = 0;
    if(!isset($_SESSION['CourseDeleteID']))
        $_SESSION['CourseDeleteID'] = "";
    if(!isset($_SESSION['CheckCourseEditCollege']))
        $_SESSION['CheckCourseEditCollege'] = "";
    if(!isset($_SESSION['CheckCourseDeleteCollege']))
        $_SESSION['CheckCourseDeleteCollege'] = "";
    if(!isset($_SESSION['CheckClear']))
        $_SESSION['CheckClear'] = "";

    if(!isset(  $_SESSION['Activities'])){
         $_SESSION['Activities']  = array();
         $date = new DateTime('now', new DateTimeZone('Asia/Manila'));
         array_push($_SESSION['Activities'],"".$date->format('h:i a')."<li class='activities'>You logged in.");
    }
    if(!isset(  $_SESSION['searchdivflag'])){
        $_SESSION['searchdivflag']="";
    }

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
   <link rel="stylesheet" href="../css/admin.css" type="text/css">
    <script src="../Modal/popper.min.js"></script>
    <script src="../Modal/bootstrap.min.js"></script>
    <!-- Modal-->
    <script src = "../js/modalform.js"></script>
    <script src = "../js/manual.js"> </script>
     <!-- Upload Modal-->
    <script src="../js/dragndrop2.js"></script>
    <link rel="stylesheet" href="../css/dragndrop2.css">
    <link rel="stylesheet" href="../Modal/modalUpload.css">
     <!-- Upload Modal-->
     <script src="https://unpkg.com/feather-icons"></script>
     <!-- Datatables JS -->
     <link rel="stylesheet" type="text/css" href="../css/dataTables.css">
     <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
   </head>

    <!--Initialization of the all the tables to convert it into Datatables-->
    <script>
        function adminuseraddmodal(){
            $(document).ready(function() {
                $("#adminuser-add-modal").modal("show");
            });
        }
        var table;
        $(document).ready(function() {
           $('.table_id').DataTable({
              "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                
            });
            
        });
        
        $(document).ready(function() {
            $('.table_id2').DataTable({
              "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
            });
        });

    </script>
    <!-- LOGO -->
<body>
    <!--NAVBAR-->
<div id="overlay">
  <nav class="header">
    <div class="nav_overlay">
      <div class="left">
          <img src="../images/singco-logo.svg" alt="" width="26px">
      </div>
      <div class="right">
        <span class="activities" style="margin-right:10px;">Go to gmail</span>
          <a href="https://www.gmail.com" target="_blank"><i data-feather="mail"></i></a>
      </div>
    </div>
  </nav>

<div class="main-menu">
  <ul>
      <li>
          <a href="#" id="a_home">
              <i class="fa fa-home"></i>
              <span class="nav-text">
                  Home
              </span>
          </a>
      </li>
      <li class="has-subnav">
          <a id="a_users">
              <i class="fa fa-users"></i>
              <span class="nav-text">
                  Users
              </span>
          </a>
      </li>
      <li class="has-subnav">
          <a id="a_courses">
             <i class="fa fa-th-list"></i>
              <span class="nav-text">
                  Courses
              </span>
          </a>
      </li>
  </ul>
  <ul class="logout">
      <li>
          <a onclick="logoutmodal()">
               <i class="fa fa-sign-out"></i>
              <span class="nav-text">
                  Logout
              </span>
          </a>
      </li>
  </ul>
</div>
<!--NAVBAR END-->

<!-- ADD USER MODAL-->
<!-- Add user modal will appear when the user click the add button in the user tab. Consisting of the three columns: Type, username/email and password which are needed to make another user/admin.   Also provided a generate password button to have a unique set of password. -->
<form method="post">
    <div id="adminuser-add-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Add User</h2>
                    <div type="button" class="modal_button close"  name="closedelete"data-dismiss="modal" aria-hidden="true">&times;</div>
                </div>
                    <div class="modal-body">
                        <p>Type:
                        <select type = "text" id = "username" name = "admin-user-type" placeholder = "password" required>
                            <option value="" disabled selected>Choose user type</option>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                        </select>
                        </p>
                       <p>Username:
                        <input type = "email" id = "username" name = "admin-user-username" placeholder = "Username/ Email" required>
                        </p>
                        <p>Password:
                        <input type = "text" id = "add_user_pw" name = "admin-user-password" placeholder = "password" required>
                        </p>
                        <div class="modal-footer">
                            <button type="button" name="pw_generator" onclick="add_generate()">Generate</button>
                            <button type="button" class="modal_button btn btn-default" name="btncancel"data-dismiss="modal">Cancel</button>
                            <button type="submit" id="btncontinue" class="modal_button btn btn-primary" onclick = "enable();"name="btnadduser" >Add </button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- ADD USER MODAL-->

<!--DELETE  MODAL-->
<!--The Delete user modal will appear that serves as a warning to the user to confirm the deletion of the user-row using the DeleteUserID provided.-->
<form method="post">
        <div id="adminuser-delete-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Delete User?</h2>
                        <div type="button" class="modal_button close"  name="closedelete"data-dismiss="modal" aria-hidden="true">&times;</div>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete
                        <?php
                            foreach($PDO->query("Select * from users where user_id='".$_SESSION['AdminUser-DeleteID']."'") as $row)
                                $str = $row['username'];
                            echo $str."?";
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal_button btn btn-default" name="btncancel"data-dismiss="modal">Cancel</button>
                        <button type="submit"  class="modal_button btn btn-primary" id="btndeleteuser" name='btndeleteuser'  >Continue </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
<!--DELETE MODAL END-->

 <!-- EDIT USER MODAL-->
 <!-- Edit user modal will appear when the user click an edit button on any rows to edit the user’s information and update it in the database using the EditUserID. -->
<form method="post">
    <div id="adminuser-edit-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Edit</h2>
                    <div type="button" class="modal_button close"  name="closedelete"data-dismiss="modal" aria-hidden="true">&times;</div>
                </div>
                    <div class="modal-body">
                        <p>Type:
                        <select type = "text" id = "username" name = "admin-user-edit-type"  required>
                            <option value="" disabled >Choose user type</option>

                        <?php
                            foreach($PDO->query("Select * from users where user_id='".$_SESSION['AdminUser-EditID']."'") as $row)
                                    $type = $row['type']; ?>
                            <option value = "Admin"  <?php if ($type == 'Admin') {echo "selected";}?>>Admin</option>
                            <option value = "User" <?php if ($type == 'User') {echo "selected";}?>>User</option>
                        </select>
                        </p>

                       <p>Username:
                        <input type = "email" id = "username" name = "admin-user-edit-username" placeholder = "Username/ Email" value ="
                            <?php
                            foreach($PDO->query("Select * from users where user_id='".$_SESSION['AdminUser-EditID']."'") as $row){
                                $uname = $row['username'];
                                $pword = $row['password'];
                                $type = $row['type'];
                            }
                              echo $uname;
                            ?> " required>
                        </p>
                        <p>Password:
                        <input type = "text" id = "edit_user_pw" name = "admin-user-edit-password" placeholder = "password" value="<?php echo $pword;?>" required>
                        </p>
                        <div class="modal-footer">
                            <button type="button" name="pw_generator" onclick="edit_generate()">Generate</button>
                            <button type="button" class="modal_button btn btn-default" name="btncancel"data-dismiss="modal" >Cancel</button>
                            <button type="submit" id="btncontinue" class="modal_button btn btn-primary" onclick = "enable();"name="btnedituser" >Save</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- EDIT USER MODAL-->

<div id="main">
<!-- HOME -->

<!-- DASHBOARD -->
<!--HOMETAB-->
<!--It includes the Dashboard(Recent Activities, Clock and Username) and the tables for CS, CSS, CAC, General Courses.-->
<div id="home">
  <div class="dashboard_text">
    <h4>DASHBOARD</h4>
    <button class="btn-minimize"></button>
  </div>

    <script>
    $(".btn-minimize").click(function(){
      $(this).toggleClass('btn-plus');
      $(".widget-content").slideToggle();
    });
    </script>

  <div id="dashboard_container" class="widget-content">
    <!-- WELCOME ADMIN -->
      <div id="welcome">
          <center>
            <h2>Welcome, <span style="color: #FFB300"> <?php echo $_SESSION['UserName'];?>! </span> </h2>
          </center>
          <img src="..\images\welcome.svg" alt="" width="80%" height="80%" class="svg">
      </div>
      
    <!-- RECENT ACTIVITIES -->
      <div id="recent_activities">
        <div id="inner_recent">
          <div class="dashboard_header">
            <h2> Recent Activities </h2>
            <button onclick="clearmodal()" type="submit"> <i class='fa fa-minus-circle' aria-hidden='true'></i>
            </button>
          </div>
          <hr style="width: 100%; margin-bottom: 10px;">
          <ul id="divactivities">

              <?php
                  foreach($_SESSION['Activities'] as $act ){

                    echo '
                    <div class="activity_list">'.$act.'</li></div>';
                  }

              ?>
          </ul>
        </div>
      </div>
    <!-- RECENT ACTIVITIES -->
    <!-- CLOCK -->
      <div id="clock">
        <div id="MyClockDisplay" class="clock" onload="showTime()"></div>
      </div>
      <div class="dashboard_text">
        <h4>NUMBER OF COURSES</h4>
      </div>
      <div class="filtered cs">
        <div>
          <h2>College of Science</h2>
          <?php
            $course = "SELECT * FROM checklist WHERE (College = 'College of Science')";
            $cs_ctr = 0;
            foreach($PDO->query($course) as $row) {
              $cs_ctr += 1;
            }
           ?>
        </div>
         <div>
           <h4><?php  echo $cs_ctr?></h4>
           <hr>
           <p class="viewtable"><a  id="btnCS" >View Table</a></p>
         </div>
      </div>
      <div class="filtered css">
        <div>
          <h2>College of Social Science</h2>
          <?php
            $course = "SELECT * FROM checklist WHERE (College = 'College of Social Science')";
            $css_ctr = 0;
            foreach($PDO->query($course) as $row) {
              $css_ctr += 1;
            }
           ?>
        </div>
         <div>
           <h4><?php  echo $css_ctr?></h4>
           <hr>
          <p class="viewtable"><a id="btnCSS">View Table</a></p>
         </div>
      </div>

      <div class="filtered cac">
        <div>
          <h2>College of Arts and Communication</h2>
          <?php
            $course = "SELECT * FROM checklist WHERE (College = 'College of Arts and Communication')";
            $cac_ctr = 0;
            foreach($PDO->query($course) as $row) {
              $cac_ctr += 1;
            }
           ?>
        </div>
         <div>
           <h4><?php  echo $cac_ctr?></h4>
           <hr>
            <p class="viewtable"><a id="btnCAC" >View Table</a></p>
         </div>
      </div>
      <div class="filtered gen">
        <div>
          <h2>General</h2>
          <?php
            $course = "SELECT * FROM checklist WHERE (College = 'General')";
            $gen_ctr = 0;
            foreach($PDO->query($course) as $row) {
              $gen_ctr += 1;
            }
           ?>
        </div>
        <div>
          <h4><?php  echo $gen_ctr?></h4>
          <hr>
          <p class="viewtable"><a id="btnGEN" >View Table</a></p>
        </div>
      </div>
  </div>


</div> <!--HOME END-->

   

<!-- CS TABLE-->
<div id="CS-table">
  <h4>COLLEGE OF SCIENCE</h4>
  <table class="table_id" class="display" style="width:100%">
      <thead>
          <tr>
            <th>Course Name</th>
            <th>Course Description</th>
            <th>College</th>
            <th>Credit</th>
            <th>Max No. of takes</th>
            <th>Type</th>
            <th>Delete</th>
            <th>Edit</th>
          </tr>
      </thead>
      <tbody>
        <?php
              foreach($PDO->query("SELECT * from checklist WHERE College = 'College of Science'") as $row){
              echo"
                  <tr class='row-highlight'>
                  <td>".$row['CourseName']."</td>
                  <td>".ucwords(strtolower($row['CourseDesc']))."</td>
                  <td>".ucwords(strtolower($row['College']))."</td>
                  <td>".$row['Credit']."</td>
                  <td>".$row['MaxTakes']."</td>
                  <td>".$row['Status']."</td>
                  <td><a href = ../Main/keyprocess.php?variable=admindel_course_".$row['CourseID']."_CS><button type='submit' class='delete_icon'><i class='fa fa-trash-o' aria-hidden='true''></i></button></a></td>
                  <td><a href = ../Main/keyprocess.php?variable=adminedit_course_".$row['CourseID']."_CS><button type='submit' class='edit_icon'><i class='fa fa-edit' aria-hidden='true''></i></button></a></td>
                  </tr>
                  ";
               }
      ?>
      </tbody>
  </table>
</div>
<!-- CSS TABLE-->
<div id="CSS-table">
  <h4>COLLEGE OF SOCIAL SCIENCE</h4>
  <table class="table_id" class="display" style="width:100%">
      <thead>
          <tr>
            <th>Course Name</th>
            <th>Course Description</th>
            <th>College</th>
            <th>Credit</th>
            <th>Max No. of takes</th>
            <th>Type</th>
            <th>Delete</th>
            <th>Edit</th>
          </tr>
      </thead>
      <tbody>
        <?php
              foreach($PDO->query("SELECT * from checklist WHERE College = 'College of Social Science'") as $row){
              echo"
                  <tr class='row-highlight'>
                  <td>".$row['CourseName']."</td>
                  <td>".ucwords(strtolower($row['CourseDesc']))."</td>
                  <td>".ucwords(strtolower($row['College']))."</td>
                  <td>".$row['Credit']."</td>
                  <td>".$row['MaxTakes']."</td>
                  <td>".$row['Status']."</td>
                  <td><a href = ../Main/keyprocess.php?variable=admindel_course_".$row['CourseID']."_CSS><button type='submit' class='delete_icon'><i class='fa fa-trash-o' aria-hidden='true''></i></button></a></td>
                  <td><a href = ../Main/keyprocess.php?variable=adminedit_course_".$row['CourseID']."_CSS><button type='submit' class='edit_icon'><i class='fa fa-edit' aria-hidden='true''></i></button></a></td>
                  </tr>
                  ";
               }
      ?>
      </tbody>
  </table>
</div>
<!-- CAC TABLE-->
<div id="CAC-table">
  <h4>COLLEGE OF ARTS AND COMMUNICACTION</h4>
  <table class="table_id" class="display" style="width:100%">
      <thead>
          <tr>
            <th>Course Name</th>
            <th>Course Description</th>
            <th>College</th>
            <th>Credit</th>
            <th>Max No. of takes</th>
            <th>Type</th>
            <th>Delete</th>
            <th>Edit</th>
          </tr>
      </thead>
      <tbody>
        <?php
              foreach($PDO->query("SELECT * from checklist WHERE College = 'College of Arts and Communication'") as $row){
              echo"
                  <tr class='row-highlight'>
                  <td>".$row['CourseName']."</td>
                  <td>".ucwords(strtolower($row['CourseDesc']))."</td>
                  <td>".ucwords(strtolower($row['College']))."</td>
                  <td>".$row['Credit']."</td>
                  <td>".$row['MaxTakes']."</td>
                  <td>".$row['Status']."</td>
                  <td><a href = ../Main/keyprocess.php?variable=admindel_course_".$row['CourseID']."_CAC><button type='submit' class='delete_icon'><i class='fa fa-trash-o' aria-hidden='true''></i></button></a></td>
                  <td><a href = ../Main/keyprocess.php?variable=adminedit_course_".$row['CourseID']."_CAC><button type='submit' class='edit_icon'><i class='fa fa-edit' aria-hidden='true''></i></button></a></td>
                  </tr>
                  ";
               }
      ?>
      </tbody>
  </table>
</div>
<!-- GENERAL COURSES TABLE-->
<div id="GEN-table">
  <h4>GENERAL COURSES</h4>
  <table class="table_id" class="display" style="width:100%">
      <thead>
          <tr>
            <th>Course Name</th>
            <th>Course Description</th>
            <th>College</th>
            <th>Credit</th>
            <th>Max No. of takes</th>
            <th>Type</th>
            <th>Delete</th>
            <th>Edit</th>
          </tr>
      </thead>
      <tbody>
        <?php
              foreach($PDO->query("SELECT * from checklist WHERE College = 'General'") as $row){
              echo"
                  <tr class='row-highlight'>
                  <td>".$row['CourseName']."</td>
                  <td>".ucwords(strtolower($row['CourseDesc']))."</td>
                  <td>".ucwords(strtolower($row['College']))."</td>
                  <td>".$row['Credit']."</td>
                  <td>".$row['MaxTakes']."</td>
                  <td>".$row['Status']."</td>
                  <td><a href = ../Main/keyprocess.php?variable=admindel_course_".$row['CourseID']."_GEN><button type='submit' class='delete_icon'><i class='fa fa-trash-o' aria-hidden='true''></i></button></a></td>
                  <td><a href = ../Main/keyprocess.php?variable=adminedit_course_".$row['CourseID']."_GEN><button type='submit' class='edit_icon'><i class='fa fa-edit' aria-hidden='true''></i></button></a></td>
                  </tr>
                  ";
               }
      ?>
      </tbody>
  </table>
</div>
<!-- END OF HOME DIV -->

<!-- USER LIST TAB-->
<!-- It includes the table of all the user’s information. Moreover, a Send Password section where the admin can send a user’s password via email. -->
<div id="user_list">
    <h4>USER LIST</h4>
     <button id="btn_add_user" onclick="adminuseraddmodal()" style="margin-left:0;padding:0"><i data-feather="plus"></i></button>
       <div class="table_admin table_container" >
              <table class = "table_id" id="user-table">
                <thead>
                  <tr class="tr_head">
                      <th class = "table_header">Type</th>
                      <th class = "table_header">Username</th>
                      <th class = "table_header">Password</th>
                      <th class = "table_header">Delete</th>
                      <th class = "table_header">Edit</th>
                  </tr>
                </thead>
                <tbody >
                            <?php
                            foreach($PDO->query("SELECT * from users") as $row){

                            echo'<tr class="row-highlight"><td>'.$row['type'].'</td>';
                            echo'<td>'.$row['username'].'</td>';
                            echo'<td>'.$row['password'].'</td>';
                            echo'<td><a href = keyprocess.php?variable=adminuser-delete_'.$row['user_id'].'>
                               <button type="submit" class="delete_icon" title="Delete">
                               <i class="fa fa-trash-o" aria-hidden="true"></i>
                               </button></a></td>';

                            echo'<td> <a href = keyprocess.php?variable=adminuser-edit_'.$row['user_id'].'>
                               <button type="submit" class="edit_icon" title="Edit">
                               <i class="fa fa-edit" aria-hidden="true"></i>
                               </button></a></td>';

                               echo '
                               </tr>
                          ';
                  }
              echo'</tbody></table></div>';

        //PHP Post Function for adduser
        if(isset($_POST['btnadduser'])) {
            $username = $_POST['admin-user-username'];
            $password = $_POST['admin-user-password'];
            $type = $_POST['admin-user-type'];

             foreach($PDO->query("Select * from users") as $row)
                    $lastid = $row['user_id'];
            $cut = explode('-', $lastid);
            $generated=(int)$cut[1]+1;
            $user_id="U"."-".str_pad($generated, 4, "0", STR_PAD_LEFT);
            $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO users(user_id,username, password,type) VALUES(?,?,?,?)";
            $exec = $PDO->prepare($sql);
            $exec->execute([$user_id,$username,$password,$type]);

            $date = new DateTime('now', new DateTimeZone('Asia/Manila'));
            array_push($_SESSION['Activities'], "".$date->format('h:i a')."<li class='activities'>You added ".$type." ".$username.".");
            echo "<meta http-equiv='refresh' content='0'>";

        }
        
        //PHP Post Function for edituser
         if(isset($_POST['btnedituser'])) {
            $username = $_POST['admin-user-edit-username'];
            $password = $_POST['admin-user-edit-password'];
            $type = $_POST['admin-user-edit-type'];

             $edit = "UPDATE users SET type = '".$type."',username = '".$username."', password = '".$password."' WHERE user_id = '" . $_SESSION['AdminUser-EditID'] . "'";
            $q = $PDO->prepare($edit);
            $q->execute();
            $date = new DateTime('now', new DateTimeZone('Asia/Manila'));
            array_push($_SESSION['Activities'],"".$date->format('h:i a')."<li class='activities'>You edited User ".$username.".");
            echo "<meta http-equiv='refresh' content='0'>";
        }
                    
        //PHP Post Function for deleteuser
        if(isset($_POST['btndeleteuser'])) {
            foreach($PDO->query("Select * from users WHERE user_id='".$_SESSION['AdminUser-DeleteID']."'") as $row)
                $username=$row['username'];
            $date = new DateTime('now', new DateTimeZone('Asia/Manila'));
            array_push($_SESSION['Activities'],"".$date->format('h:i a')."<li class='activities'>You deleted User ".$username.".");

            $PDO->query("DELETE FROM users WHERE user_id='".$_SESSION['AdminUser-DeleteID']."'");
            
            $PDO->query("DELETE FROM certificate WHERE user_id= '" .$_SESSION['AdminUser-DeleteID']. "'");
            
            $PDO->query("DELETE FROM grades WHERE user_id= '" .$_SESSION['AdminUser-DeleteID']. "'");
            
             echo "<meta http-equiv='refresh' content='0'>";
        }

     //Activating the modals
      if($_SESSION['AdminUser-checkEdit'] > 0) {
        $_SESSION['AdminUser-checkEdit']=0;
          echo '<script>
              $(document).ready(function(){
              $("#user_list").css("display" ,"block");
                 $("#course_list").css("display", "none");
              $("#adminuser-edit-modal").modal("show");});
          </script>';
        }
    if($_SESSION['AdminUser-checkDelete'] > 0) {
      $_SESSION['AdminUser-checkDelete']=0;
      echo '<script>
              $(document).ready(function(){
              $("#user_list").css("display" ,"block");
                 $("#course_list").css("display", "none");
              $("#adminuser-delete-modal").modal("show");});
          </script>';
        }
    ?>
             
    <!-- The Send Password Section-->
    <br><br>
    <h4>EMAIL USER'S PASSWORD</h4>
    <form method="post" id="email_pw_wrapper">
      <p class="success"><?php echo $success; ?></p>
        <div class="email_password">
              <p>User's email</p>
              <input class="contact" type="email" name="email_password" placeholder="Email" required>
              <p>Message</p>
              <textarea class="contact" name="message_password" required>Hi, here is your new password: </textarea>
              <button type="submit" name="send_password">Send</button>
          </div>
    </form>
</div>


<!-- COURSE LIST -->
<!-- It includes the table of all the courses’s information. -->
<div id="course_list">
    <div id="allcourse-table">
  <h4>COURSE LIST</h4>
   <button id="btn_add_course" onclick="addCourse()" style="margin-left:0;padding:0"><i data-feather="plus"></i></button>
   <div id="pagination">

 </div>
  <div class = "courses-table">
      <div class = "table_admin table_container">
          <table class = "table_id2" >
            <thead>
              <tr>
                  <th>Course Name</th>
                  <th>Course Description</th>
                  <th>College</th>
                  <th>Credit</th>
                  <th>Max No. of takes</th>
                  <th>Type</th>
                  <th>Delete</th>
                  <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $course = "SELECT * FROM checklist";
                  foreach($PDO->query($course) as $row) {
                      echo "
                            <tr class='row-highlight'>
                              <td>".$row['CourseName']."</td>
                              <td>".ucwords(strtolower($row['CourseDesc']))."</td>
                              <td>".ucwords(strtolower($row['College']))."</td>
                              <td>".$row['Credit']."</td>
                              <td>".$row['MaxTakes']."</td>
                              <td>".$row['Status']."</td>
                              <td><a href = ../Main/keyprocess.php?variable=admindel_course_".$row['CourseID']."_O><button type='submit' class='delete_icon'><i class='fa fa-trash-o' aria-hidden='true''></i></button></a></td>
                              <td><a href = ../Main/keyprocess.php?variable=adminedit_course_".$row['CourseID']."_O><button type='submit' class='edit_icon'><i class='fa fa-edit' aria-hidden='true''></i></button></a></td>
                              </tr>
                            ";
                  }
              ?>
            </tbody>
          </table>
      </div>
  </div>
    </div>

</div> <!-- end of #course_list -->
</div> <!-- end of #main -->
<!-- COURSE LIST END -->

    
<!-- EDIT COURSE MODAL-->
<!-- Edit user modal will appear when the user click an edit button on any rows in the courses table in the course tab or any of the College Courses tables in the home tab. It will edit the course’s information and update it in the database using the EditCourseID. -->
<form method="post">
    <div id="adminedit-course-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Edit Course</h2>
                    <div type="button" class="modal_button close"  name="closedelete"data-dismiss="modal" aria-hidden="true">&times;</div>
                </div>
                <div class="modal-body">
                    <form type = "post" id = "adminedit-course">
                        <p>Course Name</p>
                        <input type = "text" name = "adminedit-course-name" id = "adminedit-course-name"
                        <?php
                            foreach($PDO->query("SELECT * FROM checklist WHERE CourseID = '".$_SESSION['CourseEditID']."'") as $row) {
                                echo 'value = "'.$row['CourseName'].'"';
                            }
                        ?>
                        required>
                        <p>Course Description</p>
                        <input type = "text"  name = "adminedit-course-desc" id = "adminedit-course-desc"
                        <?php
                            foreach($PDO->query("SELECT * FROM checklist WHERE CourseID = '".$_SESSION['CourseEditID']."'") as $row) {
                                echo 'value = "'.ucwords(strtolower($row['CourseDesc'])).'"';
                            }
                        ?>
                        required>
                        <p>College</p>
                        <select name = "adminedit-course-college" id = "adminedit-course-college" required>
                        <?php
                            foreach($PDO->query("SELECT * FROM checklist WHERE CourseID = '".$_SESSION['CourseEditID']."'") as $row) {
                                $college = $row['College'];
                            }
                        ?>
                            <option value = "COLLEGE OF SCIENCE" <?php if($college == "COLLEGE OF SCIENCE"){echo "selected";}?>>College of Science</option>
                            <option value = "COLLEGE OF ARTS AND COMMUNICATION" <?php if($college == "COLLEGE OF ARTS AND COMMUNICATION"){echo "selected";}?>>College of Arts and Communication</option>
                            <option value = "COLLEGE OF SOCIAL SCIENCE" <?php if($college == "COLLEGE OF SOCIAL SCIENCE"){echo "selected";}?>>College of Social Science</option>
                            <option value = "GENERAL" <?php if($college == "GENERAL"){echo "selected";}?>>General</option>
                        </select>
                        <p>Credit</p>
                        <select name = "adminedit-course-credit" id = "adminedit-course-credit" onchange = "gradeChangeEdit(this);" required>
                        <?php
                            foreach($PDO->query("SELECT * FROM checklist WHERE CourseID = '".$_SESSION['CourseEditID']."'") as $row) {
                                $credit = $row['Credit'];
                                $MT = $row['MaxTakes'];
                                $type = $row['Status'];
                            }
                        ?>
                            <option value = "1.00" <?php if($credit == "1.00"){echo "selected";}?>>1.00</option>
                            <option value = "2.00" <?php if($credit == "2.00"){echo "selected";}?>>2.00</option>
                            <option value = "(2.00)" <?php if($credit == "(2.00)"){echo "selected";}?>>(2.00)</option>
                            <option value = "3.00" <?php if($credit == "3.00"){echo "selected";}?>>3.00</option>
                             <option value = "(3.00)" <?php if($credit == "(3.00)"){echo "selected";}?>>(3.00)</option>
                            <option value = "4.00" <?php if($credit == "4.00"){echo "selected";}?>>4.00</option>
                            <option value = "5.00" <?php if($credit == "5.00"){echo "selected";}?>>5.00</option>
                            <option value = "6.00" <?php if($credit == "6.00"){echo "selected";}?>>6.00</option>
                        </select>
                        <p>Max Takes</p>
                        <select name = "adminedit-course-max" id = "adminadd-course-max"  required>
                            <option value = "1" <?php if($MT == "1"){echo "selected";}?>>1</option>
                            <option value = "2" <?php if($MT == "2"){echo "selected";}?>>2</option>
                            <option value = "3" <?php if($MT == "3"){echo "selected";}?>>3</option>
                        </select>
                        <p>Type</p>
                        <select name = "adminedit-course-type" id = "adminadd-course-type"  required>
                            <option value = "OLD" <?php if($type == "OLD"){echo "selected";}?>>Old Subject</option>
                            <option value = "NEW" <?php if($type == "NEW"){echo "selected";}?>>New Subject</option>
                        </select>

                        <div class="modal-footer">
                            <button type = "button" class = "modal_button btn btn-default" name = "btncancel" data-dismiss = "modal">Cancel</button>
                            <button type = "submit"  class = "modal_button btn btn-primary" name = "btn-save-course" id = "btn-save-course">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</form>
<!--EDIT COURSE MODAL END-->

<!--DELETE COURSE MODAL-->
<!--The Delete user modal will appear that serves as a warning to the user to confirm the deletion of the user-row using the DeleteEditID provided.-->
<form method="post">
    <div id="admindelete-course-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Delete Course?</h2>
                    <div type="button" class="modal_button close"  name="closedelete"data-dismiss="modal" aria-hidden="true">&times;</div>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the course
                    <?php
                        //echo $_SESSION['CourseDeleteID'];
                        $course_to_del = "SELECT * FROM checklist WHERE CourseID = '".$_SESSION['CourseDeleteID']."'";
                        foreach ($PDO->query($course_to_del) as $row) {
                            $coursenamedesc = $row['CourseName']." ".$row['CourseDesc'];
                        }
                        echo $coursenamedesc;
                    ?>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal_button btn btn-default" name="btncancel"data-dismiss="modal">Cancel</button>
                    <button type="submit"  class="modal_button btn btn-primary" name= "btn-delete-course">Continue </button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--DELETE COURSE MODAL END-->

<!-- ADD COURSE MODAL-->
<!-- Add user modal will appear when the user click the add button only in the course tab. Consisting of the columns: Course Name, Course Descriptions, College, Credit/ Unit, Max No. of takes, and Type/ Status which are needed to make another course.  -->
<form method="post">
    <div id="adminadd-course-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Add Course</h2>
                    <div type="button" class="modal_button close"  name="closedelete"data-dismiss="modal" aria-hidden="true">&times;</div>
                </div>
                <div class="modal-body">
                    <form type = "post" id = "adminadd-course">
                        <p>Course Name</p>
                        <input type = "text" name = "adminadd-course-name" id = "adminadd-course-name" placeholder="Course Name" required>
                        <p>Course Description</p>
                        <input type = "text"  name = "adminadd-course-desc" placeholder="Course Description" id = "adminadd-course-desc" required>
                        <p>College</p>
                        <select name = "adminadd-course-college" id = "adminadd-course-college" required>
                            <option value = "" disabled selected>Choose College</option>
                            <option value = "COLLEGE OF SCIENCE">College of Science</option>
                            <option value = "COLLEGE OF ARTS AND COMMUNICATION">College of Arts and Communication</option>
                            <option value = "COLLEGE OF SOCIAL SCIENCE">College of Social Science</option>
                            <option value = "GENERAL">General</option>
                        </select>
                        <p>Credit</p>
                        <select name = "adminadd-course-credit" id = "adminadd-course-credit"  required>
                            <option value = "" disabled selected>Choose Credit</option>
                            <option value = "1.00">1.00</option>
                            <option value = "2.00">2.00</option>
                            <option value = "(2.00)">(2.00)</option>
                            <option value = "3.00">3.00</option>
                            <option value = "(3.00)">(3.00)</option>
                            <option value = "4.00">4.00</option>
                            <option value = "5.00">5.00</option>
                            <option value = "6.00">6.00</option>
                        </select>
                        <p>Max Takes</p>
                        <select name = "adminadd-course-max" id = "adminadd-course-max"  required>
                            <option value = "" disabled selected>Choose Max no. of takes</option>
                            <option value = "1">1</option>
                            <option value = "2">2</option>
                            <option value = "3y">3</option>
                        </select>
                        <p>Type</p>
                        <select name = "adminadd-course-type" id = "adminadd-course-type"  required>
                            <option value = "" disabled selected>Choose the type</option>
                            <option value = "OLD">Old Subject</option>
                            <option value = "NEW">New Subject</option>
                        </select>
                        <div class="modal-footer">
                            <button type="button" class="modal_button btn btn-default" name="btncancel"data-dismiss="modal">Cancel</button>
                            <button type="submit" id="btncontinue" class="modal_button btn btn-primary" name="btn-add-course-continue" >Continue </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- ADD COURSE MODAL END -->
    
<!--LOGOUT MODAL-->
<!--The logout modal  will appear if the user click the logout icon in the navbar which indicates as a confirmation popup to logout. -->
    <form method="post">
        <div id="logout-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title"> Are you sure you want to logout?</div>
                        <div class="close"  name="closedelete"data-dismiss="modal" aria-hidden="true">&times;</div>
                    </div>
                    <div class="modal-body"style="font-size:18px"><br>
                       Your data will be saved and will be returned to the login page.<br><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal_button btn btn-default" name="btncancel"data-dismiss="modal">Cancel</button>
                        <button type="submit" class="modal_button btn btn-default" name="btnlogout">Logout</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
<!--LOGOUT MODAL END-->
    
<!--ClEAR MODAL-->
<!--The clear modal will appear after the user click the clear icon in the home tab of the recent activities. This will clear the listed activities that the user have been doing such as deleting/editing/adding a course/ user in the admin page.-->
    <form method="post">
        <div id="clear-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title">Warning</div>
                        <div class="close"  name="closedelete"data-dismiss="modal" aria-hidden="true">&times;</div>
                    </div>
                    <div class="modal-body"style="font-size:18px"><br>
                       Are you sure you want to clear all the recent activities.<br><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal_button btn btn-default" name="btncancel"data-dismiss="modal">Cancel</button>
                        <button type="submit" class="modal_button btn btn-default" name="clearact" >Clear</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
<!--CLEAR MODAL END-->


<?php
if(isset($_POST['btnlogout'])){
    session_destroy();
    echo "<script> localStorage.clear();</script>";
    echo "<meta http-equiv='refresh' content='0.0001; url=../Log_In/login.php'>";
}
?>
</div>
</body>

<script>
//disabling the dropdown boxes
function editCourse() {
    document.getElementById("adminedit-course-name").removeAttribute("disabled");
    document.getElementById("adminedit-course-desc").removeAttribute("disabled");
    document.getElementById("adminedit-course-college").removeAttribute("disabled");
    document.getElementById("adminedit-course-credit").removeAttribute("disabled");
}

function addCourse() {
    $(document).ready(function(){
        $("#adminadd-course-modal").modal("show");
    });
}
</script>

<?php
  //Activation of Course Edit and Course Delete Modal
  if($_SESSION['CheckCourseEdit'] > 0) {
      $_SESSION['CheckCourseEdit']=0;
      echo '<script>
                 $(document).ready(function(){
              $("#adminedit-course-modal").modal("show");
               });
          </script>';

  }
  if($_SESSION['CheckCourseDelete'] > 0) {
      $_SESSION['CheckCourseDelete']=0;
      echo '<script>
              $(document).ready(function(){
              $("#admindelete-course-modal").modal("show");
              });
          </script>';

  }
?>

<?php
//PHP Post Function for editcourse
if(isset($_POST['btn-save-course'])) {
    $course_name = addslashes(strtoupper($_POST['adminedit-course-name']));
    $course_desc = addslashes(strtoupper($_POST['adminedit-course-desc']));
    $college = $_POST['adminedit-course-college'];
    $credit = $_POST['adminedit-course-credit'];
    $max = $_POST['adminedit-course-max'];
    $type = $_POST['adminedit-course-type'];

    $editcourse = "UPDATE checklist SET CourseName = '".$course_name."', CourseDesc = '".$course_desc."', College = '".$college."',MaxTakes='".$max."',Status='".$type."',Credit = '".$credit."' WHERE CourseID = '".$_SESSION['CourseEditID']."'";
    $sql = $PDO->prepare($editcourse);
    $sql->execute();
    $date = new DateTime('now', new DateTimeZone('Asia/Manila'));
    array_push($_SESSION['Activities'],"".$date->format('h:i a')."<li class='activities'>You edited Course ".$course_name.".");
    echo "<meta http-equiv='refresh' content='0'>";
}

//PHP Post Function for deletecourse
if(isset($_POST['btn-delete-course'])) {
    foreach($PDO->query("Select * from checklist WHERE CourseID = '".$_SESSION['CourseDeleteID']."'") as $row)
            $course_name=$row['username'];
            $date = new DateTime('now', new DateTimeZone('Asia/Manila'));
    array_push($_SESSION['Activities'],"".$date->format('h:i a')."<li class='activities'>You deleted Course ".$course_name.".");

    $PDO->query("DELETE FROM checklist WHERE CourseID = '".$_SESSION['CourseDeleteID']."'");
    echo "<meta http-equiv='refresh' content='0'>";
}
//PHP Post Function for addcourse
if(isset($_POST['btn-add-course-continue'])) {
    $course_name = $_POST['adminadd-course-name'];
    $course_desc = $_POST['adminadd-course-desc'];
    $college = $_POST['adminadd-course-college'];
    $credit = $_POST['adminadd-course-credit'];
     $max = $_POST['adminadd-course-max'];
    $type = $_POST['adminadd-course-type'];

    foreach($PDO->query("SELECT * FROM checklist") as $row) {
       $last_ID = $row['CourseID'];
    }
    $cut = explode('-', $last_ID);
    $generated=(int)$cut[1]+1;
    $id = "CS-".str_pad($generated, 4, "0", STR_PAD_LEFT);
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $PDO->query("INSERT INTO checklist (CourseID, CourseName, CourseDesc, College,MaxTakes,Status, Credit) VALUES('".$id."', '".strtoupper($course_name)."', '".strtoupper($course_desc)."', '".$college."','".$max."','".$type."','".$credit."')");
    $date = new DateTime('now', new DateTimeZone('Asia/Manila'));
    array_push($_SESSION['Activities'],"".$date->format('h:i a')."<li class='activities'>You added Course ".$course_name.".");
    echo "<meta http-equiv='refresh' content='0'>";
}
    
    //PHP Post Function for Clearing the Recent Activities
     if(isset($_POST['clearact'])) {
        unset($_SESSION['Activities']); 
        $_SESSION['Activities']= array();
           $_SESSION['CheckClear'] = "1";
         echo "<script> localStorage.setItem('clear', true);viewtable('CLEAR');</script>";
    }
    
    ?>

    
<script type="text/javascript">
//This section is for the javascript of the tabs(Home, Users, Courses) and the table divs (CS,CSS,CAC, GEN ) 
      $("#btnviewtable").click( function(){
            $.post("admin.php");
            });
      
        //Function which College to showin the home tab and which part/location of the home tab
        function viewtable(college){
            //alert(college);
            if (college=="CS"){
                $('#CS-table').show();
                $('#CAC-table').hide();
                $('#CSS-table').hide();
                $('#GEN-table').hide();
                location.href = '#CS-table';

            }
            else if (college=="CAC"){
                $('#CS-table').hide();
                $('#CAC-table').show();
                $('#CSS-table').hide();
                $('#GEN-table').hide();
                 location.href = '#CAC-table';
            }
            else if (college=="CSS"){
                 $('#CS-table').hide();
                $('#CAC-table').hide();
                $('#CSS-table').show();
                $('#GEN-table').hide();
                 location.href = '#CSS-table';
            }
             else if (college=="GEN"){
                 $('#CS-table').hide();
                $('#CAC-table').hide();
                $('#CSS-table').hide();
                $('#GEN-table').show();
                 location.href = '#GEN-table';
            }
            else if (college=="CLEAR"){
                 localStorage.setItem('clear', true);
                 location.href = '#recent_activities';
            }
        }
      
    
  feather.replace();
    $(document).ready(function () {
        
         $('#btnCS').on('click', function () {
             localStorage.clear();
             localStorage.setItem('cs', true);
             localStorage.setItem('divhome', true);
             viewtable('CS');
            });
        
         $('#btnCSS').on('click', function () {
             localStorage.clear();
            localStorage.setItem('css', true);
            localStorage.setItem('divhome', true);
            viewtable('CSS');
            });
        
         $('#btnCAC').on('click', function () {
             localStorage.clear();
            localStorage.setItem('cac', true);
              localStorage.setItem('divhome', true);
            viewtable('CAC');
            });
        
         $('#btnGEN').on('click', function () {
             localStorage.clear();
            localStorage.setItem('gen', true);
            localStorage.setItem('divhome', true);
            viewtable('GEN');
            });
        
        $('#a_users').on('click', function () {
            $('#user_list').show();
            $('#course_list').hide();
            $('#home').hide();

             $('#CS-table').hide();
             $('#CAC-table').hide();
             $('#CSS-table').hide();
             $('#GEN-table').hide();
            localStorage.clear();
            localStorage.setItem('divuser', true);

        });

        $('#a_courses').on('click',function(){
            $('#course_list').show();
            $('#user_list').hide();
            $('#home').hide();

             $('#CS-table').hide();
             $('#CAC-table').hide();
             $('#CSS-table').hide();
             $('#GEN-table').hide();

            localStorage.clear();
            localStorage.setItem('divcourse', true);

        });

        $('#a_home').on('click',function(){
           
            $('#home').show();
            $('#course_list').hide();
            $('#user_list').hide();
            localStorage.removeItem('divcourse');
            localStorage.removeItem('divuser');
            localStorage.setItem('divhome', true);
            if (localStorage.getItem('clear')){
                    $( "#divactivities" ).load(window.location.href + " #divactivities" );
                     location.href = '#home';
                 }
            
             if (localStorage.getItem('cs')) {
                   viewtable('CS');
                 if (localStorage.getItem('clear')){
                    $( "#divactivities" ).load(window.location.href + " #divactivities" );
                     location.href = '#home';
                 }
                 localStorage.clear();
                  localStorage.setItem('divhome', true);
                  localStorage.setItem('cs', true);
                    
             }
             else if (localStorage.getItem('css')) {
                 viewtable('CSS');
                 if (localStorage.getItem('clear')){
                    $( "#divactivities" ).load(window.location.href + " #divactivities" );
                     location.href = '#home';
                 }
                 localStorage.clear();
                  localStorage.setItem('divhome', true);
                  localStorage.setItem('css', true);
                 
             }
            else if (localStorage.getItem('cac')) {
                 viewtable('CAC'); 
                if (localStorage.getItem('clear')){
                    $( "#divactivities" ).load(window.location.href + " #divactivities" );
                     location.href = '#home';
                 }
                 localStorage.clear();
                  localStorage.setItem('divhome', true);
                  localStorage.setItem('cac', true);
                 
            }
              else if (localStorage.getItem('gen')) {
                  viewtable('GEN');
                  if (localStorage.getItem('clear')){
                    $( "#divactivities" ).load(window.location.href + " #divactivities" );
                     location.href = '#home';
                 }
                  localStorage.clear();
                  localStorage.setItem('divhome', true);
                  localStorage.setItem('gen', true);
                 
              }
            
              
            <?php
                if ( $_SESSION['CheckCourseEditCollege']!="O" || $_SESSION['CheckCourseDeleteCollege']!="O" ){
                    $E=$_SESSION['CheckCourseEditCollege'];
                    $D=$_SESSION['CheckCourseDeleteCollege'];

                  if($E=="CS"||$D=="CS"){
                        echo "viewtable('CS');";
                        $_SESSION['CheckCourseEditCollege']="0";
                        $_SESSION['CheckCourseDeleteCollege']="0";
                  }
                  else if($E=="CSS"||$D=="CSS"){
                        echo "viewtable('CSS');";
                          $_SESSION['CheckCourseEditCollege']="0";
                        $_SESSION['CheckCourseDeleteCollege']="0";}
                  else if($E=="CAC"||$D=="CAC"){
                        echo "viewtable('CAC');";
                    $_SESSION['CheckCourseEditCollege']="0";
                        $_SESSION['CheckCourseDeleteCollege']="0";}
                  else if ($E=="GEN"||$D=="GEN"){
                      echo "viewtable('GEN');";
                    $_SESSION['CheckCourseEditCollege']="0";
                        $_SESSION['CheckCourseDeleteCollege']="0";}
                
                    if ($_SESSION['CheckClear'] =="1") 
                        echo "viewtable(CLEAR);";
                    
              }
            
            ?>
           
        });
        
       

        if (localStorage.getItem('divhome')) {
            $('#a_home').trigger('click');
        }
        
        if (localStorage.getItem('cs')) {
            $('#a_home').trigger('click');
        }
        
        if (localStorage.getItem('css')) {
            $('#a_home').trigger('click');
        }
        
        if (localStorage.getItem('gen')) {
            $('#a_home').trigger('click');
        }
        
        if (localStorage.getItem('divuser')) {
            $('#a_users').trigger('click');
        }
         if (localStorage.getItem('divcourse')) {
            $('#a_courses').trigger('click');
        }
         if (!localStorage.getItem('divhome')&&!localStorage.getItem('divcourse')&&!localStorage.getItem('divuser')) {
             $('#a_home').trigger('click');
        }

         <?php
    if ($_SESSION['searchdivflag']=="1"){
        $_SESSION['searchdivflag']="";
        echo " $('#a_courses').trigger('click');";
    }


    ?>
});
    
    //Calling the designated modals
    function logoutmodal(){
    $(document).ready(function() {
        $("#logout-modal").modal("show");
    });}

     function clearmodal(){
    $(document).ready(function() {
        $("#clear-modal").modal("show");
    });}
    
    

//clock
function showTime(){
    var date = new Date();
    var h = date.getHours(); // 0 - 23
    var m = date.getMinutes(); // 0 - 59
    var s = date.getSeconds(); // 0 - 59

    if(h == 0){
        h = 12;
    }

    if(h > 12){
        h = h - 12;
    }

    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;

    var time = h + ":" + m + ":" + s;
    var date = date.toDateString();

    document.getElementById("MyClockDisplay").innerText = '<div id="clock_time">' + time + '</div><br />'+ date;
    document.getElementById("MyClockDisplay").innerHTML = '<div id="clock_time">' + time + '</div><br />' + date;
    setTimeout(showTime, 1000);

}
//password generator
  function add_generate(){
    var keyListAlpha="abcdefghijklmnopqrstuvwxyz",
        keyListInt="123456789",
        keyListSpec="!@#_",
        password='';
    var len = Math.ceil(16/2);
    len = len - 1;
    var lenSpec = 16-2*len;

    for (i=0;i<len;i++) {
        password+=keyListAlpha.charAt(Math.floor(Math.random()*keyListAlpha.length));
        password+=keyListInt.charAt(Math.floor(Math.random()*keyListInt.length));
    }

    for (i=0;i<lenSpec;i++)
        password+=keyListSpec.charAt(Math.floor(Math.random()*keyListSpec.length));

    password=password.split('').sort(function(){return 0.5-Math.random()}).join('');

    document.getElementById("add_user_pw").value = password;
  }
  function edit_generate(){
    var keyListAlpha="abcdefghijklmnopqrstuvwxyz",
        keyListInt="123456789",
        keyListSpec="!@#_",
        password='';
    var len = Math.ceil(16/2);
    len = len - 1;
    var lenSpec = 16-2*len;

    for (i=0;i<len;i++) {
        password+=keyListAlpha.charAt(Math.floor(Math.random()*keyListAlpha.length));
        password+=keyListInt.charAt(Math.floor(Math.random()*keyListInt.length));
    }

    for (i=0;i<lenSpec;i++)
        password+=keyListSpec.charAt(Math.floor(Math.random()*keyListSpec.length));

    password=password.split('').sort(function(){return 0.5-Math.random()}).join('');

    document.getElementById("edit_user_pw").value = password;
  }

showTime();

if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}

</script>



</html>
