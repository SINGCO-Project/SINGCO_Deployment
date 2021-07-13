<!-- This is where all the main modals used in the web application are created and designed 
which includes the add modal, edit modal,  -->

<!-- ADD MODAL-->
<form method="post">
    <div id="info-modal" class="modal fade" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">Add Subject</div>
                    <div class="close"  name="closedelete"data-dismiss="modal" aria-hidden="true">&times;</div>
                </div>
                <div class="modal-body">
                    <form type = "post" id = "add-subject">
                        <!-- This input tag stores the number of rows that the table currently have -->
                        <input type = "number" id = "rowCount" name = "rowCount" value = 1 style = "display: none;" readonly>
                        <p>Choose from the following selections</p>
                        <table class="sem-selection">
                        <tr>
                            <td>
                                <select name = "acad-year" id = "year" required>
                                    <option selected disabled value = "">Choose Academic Year</option>
                                </select>
                            </td>
                            <td>
                                <select name = "semester" id = "semester" required>
                                    <option selected disabled value = "">Choose Semester</option>
                                    <option value = "First Semester">First Semester</option>
                                    <option value = "Second Semester">Second Semester</option>
                                    <option value = "Summer">Summer/Midyear</option>
                                </select>
                            </td>
                            <td>
                                <form method="post" id="formsort">
                                <select name = "sort" id = "sort" onchange="sortCourses();">
                                    <option value = "ALL" >All Checklist</option>
                                    <option value = "NEW" selected>New Checklist</option>
                                    <option value = "OLD">Old Checklist</option>
                                </select>
                                </form>
                            </td>
                        </tr>
                        </table>

                        <table id = "course-info" class = "course-info">
                        <tr>
                            <td></td>
                            <td id="tdcourse">
                                 <select name = "course1" id = "course1" onchange = "disable('course1');"required>
                                    <option selected disabled value = "">Choose Course</option>
                                    <?php
                                     $i=0;
                                     $courses_check=array();

                                     foreach ($PDO->query("select * from grades where user_id='".$_SESSION['UserID']."'") as $row){
                                        $courses_check[$i]=$row['course']."_".$row['state'];
                                            $i++;}

                                   foreach ($PDO->query("select * from checklist where Status='NEW'") as $row){
                                         $state1="NULL";
                                        foreach ($courses_check as $c) {
                                              $cut = explode('_', $c);
                                            if ($cut[0]==$row['CourseID']){
                                                  $state1=$cut[1];
                                            }
                                        }
                                        if($state1 == '1') {
                                            $state = "disabled";
                                            $taken = " Maximum No. of Takes Reached";
                                        } else {$state = ""; $taken = "";}


                                         echo "<option value ='".$row['CourseID']."'".$state.">".$row['CourseName']." (".ucwords(strtolower($row['CourseDesc'])).")".$taken."</option>";
                                    }

                                    ?>
                                </select>
                            </td>
                            <td id="tdgrade">
                                <select name = 'grade1' id = 'grade1' required onchange = 'gradeChange("grade1", "removal-grade1");'>
                                    <option selected disabled value = "">Choose Grade</option>
                                    <option value = "1.00">1.00</option>
                                    <option value = "1.25">1.25</option>
                                    <option value = "1.50">1.50</option>
                                    <option value = "1.75">1.75</option>
                                    <option value = "2.00">2.00</option>
                                    <option value = "2.25">2.25</option>
                                    <option value = "2.50">2.50</option>
                                    <option value = "2.75">2.75</option>
                                    <option value = "3.00">3.00</option>
                                    <option value = "4.00">4.00</option>
                                    <option value = "5.00">5.00</option>
                                    <option value = "DFR">DFR</option>
                                    <option value = "DRP">DRP</option>
                                    <option value = "FAIL">FAIL</option>
                                    <option value = "INC">INC</option>
                                    <option value = "PASS">PASS</option>
                                </select>
                            </td>
                            <td id="tdremove">
                                <select name = "removal-grade1" id = "removal-grade1" style = "display:none;">
                                    <option selected disabled value = "">Choose Removal Grade</option>
                                    <option value = "3.00">3.00</option>
                                    <option value = "4.00">4.00</option>
                                    <option value = "5.00">5.00</option>
                                </select>
                            </td>
                        </tr>
                        </table>  <div class="add">
                        <p><a href = "javascript:addEntry();" id="add"class="add">+ Add another entry</a></p>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="modal_button btn btn-default" name="btncancel"data-dismiss="modal" onclick="removeRows();">Cancel</button>
                            <button type="submit" id="btncontinue" class="modal_button btn btn-primary" onclick = "enable();"name="btncontinue" >Continue </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</form>
<!--ADD MODAL END-->

<!-- EDIT MODAL-->
<form method="post">
    <div id="edit-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <?php
                            echo "Edit:";?></div>
                  <div class="close"  name="closedelete"data-dismiss="modal" aria-hidden="true">&times;</div>
                </div>
                <div class="modal-body">
                    <form type = "post" id = "edit-subject">
                        <p>Choose Academic Year</p>
                        <select name = "acad-year-edit" id = "acad-year-edit" disabled required>
                            <option selected disabled value = "">Choose Academic Year</option>
                            <?php $course = "SELECT year FROM grades WHERE grade_id = '" . $_SESSION['EditID'] . "' and user_id='".$_SESSION['UserID']."'";
                                foreach ($PDO->query($course) as $row)
                                    $edit_year = $row['year'];

                                $curr=(int)(date('Y'));
                                $sel="";
                                for($i=1961;$i<=$curr;$i++){
                                     $sel="";
                                    if ($i==$edit_year)
                                        $sel="selected";
                                    $add=$i+1;
                                    echo "<option value='".$i."-".$add."' ".$sel.">".$i."-".$add."</option>";
                                }
                            ?>

                        </select>
                        <p>Choose Semester</p>
                        <select name = "semester-edit" id = "semester-edit" disabled required>
                            <?php $course = "SELECT semester FROM grades WHERE grade_id = '" . $_SESSION['EditID'] . "' and user_id='".$_SESSION['UserID']."'";
                                foreach ($PDO->query($course) as $row)
                                    $edit_semester = $row['semester']; ?>
                            <option value = "First Semester"  <?php if ($edit_semester == 'First Semester') {echo "selected";}?>>First Semester</option>
                            <option value = "Second Semester" <?php if ($edit_semester == 'Second Semester') {echo "selected";}?>>Second Semester</option>
                            <option value = "Summer"  <?php if ($edit_semester == 'Summer') {echo "selected";}?>>Summer/Midyear</option>
                        </select>
                        <p>Choose Course Name</p>
                        <select name = "course-edit" id = "course-edit" disabled required>
                             <?php

                                foreach ($PDO->query("SELECT * FROM grades WHERE grade_id = '" . $_SESSION['EditID'] . "' and user_id='".$_SESSION['UserID']."'") as $rows)
                                 $idcourse=$rows['course'];
                                $i=0;
                                 $courses_check=array();

                                foreach ($PDO->query("select * from grades where user_id='".$_SESSION['UserID']."'") as $row){
                                    $courses_check[$i]=$row['course']."_".$row['state'];
                                $i++;}


                                if (strpos($idcourse,"CS-")===false){
                                    echo "<option value='".$idcourse."' selected> ".$idcourse."</option>";
                                }

                                foreach ($PDO->query("select * from checklist") as $row){
                                    $state1="NULL";
                                    foreach ($courses_check as $c) {
                                        $cut = explode('_', $c);
                                        if ($cut[0]==$row['CourseID']){
                                            $state1=$cut[1];
                                        }
                                    }

                                    if($state1 == '1' && $row['CourseID']!=$idcourse) {
                                        $state = " disabled";
                                        $taken = " Maximum No. of Takes Reached";
                                    }
                                    else if($row['CourseID']==$idcourse){
                                        $state = " selected";
                                        $taken = "";
                                    }
                                    else {$state = ""; $taken = "";}
                                    
                                    echo "<option value ='".$row['CourseID']."'".$state.">".$row['CourseName']." (".ucwords(strtolower($row['CourseDesc'])).")".$taken."</option>";
                                }

                            ?>
                        </select>

                        <p>Choose Final Grade</p>
                        <select name = "grade-edit" id = "grade-edit" onchange = "gradeChangeEdit(this);" disabled required>
                            <?php $course = "SELECT grade FROM grades WHERE grade_id = '" . $_SESSION['EditID'] . "' and user_id='".$_SESSION['UserID']."'";
                                foreach ($PDO->query($course) as $row)
                                    $edit_grade = $row['grade']; ?>
                            <option value = "1.00" <?php if($edit_grade == "1.00"){echo "selected";}?>>1.00</option>
                            <option value = "1.25" <?php if($edit_grade == "1.25"){echo "selected";}?>>1.25</option>
                            <option value = "1.50" <?php if($edit_grade == "1.50"){echo "selected";}?>>1.50</option>
                            <option value = "1.75" <?php if($edit_grade == "1.75"){echo "selected";}?>>1.75</option>
                            <option value = "2.00" <?php if($edit_grade == "2.00"){echo "selected";}?>>2.00</option>
                            <option value = "2.25" <?php if($edit_grade == "2.25"){echo "selected";}?>>2.25</option>
                            <option value = "2.50" <?php if($edit_grade == "2.50"){echo "selected";}?>>2.50</option>
                            <option value = "2.75" <?php if($edit_grade == "2.75"){echo "selected";}?>>2.75</option>
                            <option value = "3.00" <?php if($edit_grade == "3.00"){echo "selected";}?>>3.00</option>
                            <option value = "4.00" <?php if($edit_grade == "4.00"){echo "selected";}?>>4.00</option>
                            <option value = "5.00" <?php if($edit_grade == "5.00"){echo "selected";}?>>5.00</option>
                            <option value = "DFR" <?php if($edit_grade == "DFR"){echo "selected";}?>>DFR</option>
                            <option value = "DRP" <?php if($edit_grade == "DRP"){echo "selected";}?>>DRP</option>
                            <option value = "FAIL" <?php if($edit_grade == "FAIL"){echo "selected";}?>>FAIL</option>
                            <option value = "INC" <?php if($edit_grade == "INC"){echo "selected";}?>>INC</option>
                            <option value = "PASS" <?php if($edit_grade == "PASS"){echo "selected";}?>>PASS</option>
                        </select>
                        <div id = "removal-edit"
                        <?php
                            $rem = "SELECT removal_grade FROM grades WHERE grade_id = '" . $_SESSION['EditID'] . "' and user_id='".$_SESSION['UserID']."'";
                            foreach ($PDO->query($rem) as $row) {
                                $edit_rem = $row['removal_grade'];
                                if ($edit_rem != "n/a") {echo " style = 'display: block;'";}
                                else {echo " style = 'display: none;'";}
                            }
                        ?>>
                            <p>Choose Completion/Removal Grade</p>
                            <select name = "removal-grade-edit" id = "removal-grade-edit" disabled>
                                <?php $course = "SELECT removal_grade FROM grades WHERE grade_id = '" . $_SESSION['EditID'] . "' and user_id='".$_SESSION['UserID']."'";
                                    foreach ($PDO->query($course) as $row);
                                        $edit_remgrade = $row['removal_grade']; ?>
                                <option value = "3.00" <?php if($edit_remgrade == "3.00"){echo "selected";}?>>3.00</option>
                                <option value = "4.00" <?php if($edit_remgrade == "4.00"){echo "selected";}?>>4.00</option>
                                <option value = "5.00" <?php if($edit_remgrade == "5.00"){echo "selected";}?>>5.00</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type = "button" class = "modal_button btn btn-default" name = "btncancel" data-dismiss = "modal">Cancel</button>
                            <button type = "button"  class = "modal_button btn btn-primary" name = "btnedit" id = "btnedit" onclick = "editCourse();">Edit</button>
                            <button type = "submit"  class = "modal_button btn btn-primary" name = "btnsave" id = "btnsave" style = "display:none;">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</form>
<!--EDIT MODAL END-->

<!--DELETE MODAL-->
    <form method="post">
        <div id="delete-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title">Delete Course?</div>
                        <div class="close"  name="closedelete"data-dismiss="modal" aria-hidden="true">&times;</div>
                    </div>
                    <div class="modal-body">
                    </br>
                        <p> Are you sure you want to delete
                        <?php
                            $course_to_del = "SELECT * FROM grades WHERE grade_id = '" . $_SESSION['CourseDeleteID'] . "' and user_id='".$_SESSION['UserID']."'";
                            foreach($PDO->query($course_to_del) as $row) {
                                $courseShit = "SELECT * FROM checklist WHERE CourseID = '" . $row['course'] . "'";
                                foreach ($PDO->query($courseShit) as $row2) {
                                    $str= $row2['CourseDesc']." " ;
                                    echo $row2['CourseName']." (".ucwords(strtolower($str)).")";
                                }
                                if ($row['grade']=="4")
                                   echo " with ".bcdiv($row['grade'],1,2)." grade and a removal grade of ".bcdiv($row['removal_grade'],1,2);
                                
                                else if (!is_numeric($row['grade']))
                                      echo " with ".$row['grade']." grade";
                                else
                                      echo " with a grade of ".bcdiv($row['grade'],1,2);
                            }
                        ?>?
                      </p>
                  </br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal_button btn btn-default" name="btncancel"data-dismiss="modal">Cancel</button>
                        <button type="submit"  class="modal_button btn btn-primary" name='btndelete' >Continue </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
<!--DELETE MODAL END-->

<!--DELETE SEM MODAL-->
    <form method="post">
        <div id="delete-sem-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title">Delete Sem?</div>
                        <div class="close"  name="closedelete"data-dismiss="modal" aria-hidden="true">&times;</div>
                    </div>
                    <div class="modal-body">
                      </br>
                      <p>  Are you sure you want to delete A/Y
                        <?php
                            echo $_SESSION['CourseDeleteSem']."?";
                        ?>
                      </p>
                      </br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal_button btn btn-default" name="btncancel"data-dismiss="modal">Cancel</button>
                        <button type="submit"  class="modal_button btn btn-primary" name='btndeletesem' >Continue </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
<!--DELETE SEM MODAL END-->

<!--EMPTY INPUT MODAL-->
    <form method="post">
        <div id="emptyinput-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title">Warning!</div>
                        <div class="close"  name="closedelete"data-dismiss="modal" aria-hidden="true">&times;</div>
                    </div>
                    <div class="modal-body"style="font-size:18px"><br>
                        There are no inputs!<br><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal_button btn btn-default" name="btncancel"data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
<!--EMPTY INPUT MODAL END-->
<!--UPLOAD MODAL-->
    <form method="post" enctype="multipart/form-data">
        <div id="upload-modal" class="upload-modal modal fade">
            <div class="modal-dialog">
                <div class="modal-content-upload">
                    <div class="modal-header">
                        <div class="modal-title">Upload</div>
                        <div class="close"  name="closedelete"data-dismiss="modal" aria-hidden="true">&times;</div>
                    </div>
                    <div class="modal-body-upload"><br>
                        <input id="file_input" type="file" name="file" multiple>
                    </div>
                    <div class="modal-footer-upload">
                        <button type="button" class="btnupload" name="btncancel" onclick="empty_file()" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btnupload" name="btnupload">Upload</button>
                        <!--<input type="submit"  class="btnupload" name="btnupload"value="Upload">-->
                    </div>
                </div>
            </div>
        </div>
    </form>
<!--UPLOAD MODAL END-->
<script>
  
</script>

<!--EXTENSION MODAL-->
    <form method="post">
        <div id="extension-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content-warning">
                    <div class="modal-header">
                        <div class="modal-title">Warning!</div>
                        <div class="close"  name="closedelete"data-dismiss="modal" aria-hidden="true">&times;</div>
                    </div>
                    <div class="modal-body"><br><br>
                        Please only upload a text file! <br><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal_button btn btn-default" name="btncancel"data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
<!--EXTENSION MODAL END-->

<!--EMPTY MODAL-->
    <form method="post">
        <div id="empty-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content-warning">
                    <div class="modal-header">
                        <div class="modal-title">Warning!</div>
                        <div class="close"  name="closedelete"data-dismiss="modal" aria-hidden="true">&times;</div>
                    </div>
                    <div class="modal-body"><br><br>
                        There is no file!<br><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal_button_warning btn btn-default" name="btncancel"data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
<!--EMPTY MODAL END-->

<!--RESET MODAL-->
    <form method="post">
        <div id="reset-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title">Warning!</div>
                        <div class="close"  name="closedelete"data-dismiss="modal" aria-hidden="true">&times;</div>
                    </div>
                    <div class="modal-body"><br>
                      <p>  You will reset/delete everything. </p>
                      <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal_button btn btn-default" name="btncancel"data-dismiss="modal">Cancel</button>
                        <button type="button" class="modal_button btn btn-default" onclick="location.href = 'reset.php'">Continue</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
<!--RESET MODAL END-->

<!--LOGOUT MODAL-->
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

<?php 
if(isset($_POST['btnlogout'])){ 
    session_destroy();
    echo "<meta http-equiv='refresh' content='0.0001; url=../Log_In/login.php'>";
}
?>

<!--EMPTY TXT MODAL-->
    <form method="post">
        <div id="empty-txt-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title"> Warning!</div>
                        <div class="close"  name="closedelete"data-dismiss="modal" aria-hidden="true">&times;</div>
                    </div>
                    <div class="modal-body"style="font-size:18px"><br>
                       No grade to compute in the text file.<br><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal_button btn btn-default" name="btncancel"data-dismiss="modal">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
<!--EMPTY TXT MODAL END-->

 <!-- Print MODAL-->
<body>
    <form method="post">
        <div id="print-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title">Certificate Information</div>
                        <div class="close"  name="closedelete"data-dismiss="modal" aria-hidden="true">&times;</div>
                    </div>
                    <div class="modal-body">
                        <form method = "post">
                            <h1><b>Please enter the necessary information below.</b></h1><br>
                            <h1>
                                Student Name
                                <br>
                                <input type = "text" placeholder = " First Name" name = "firstname" required><br>
                                <input type = "text" placeholder = " Middle Initial" name = "middleinitial"><br>
                                <input type = "text" placeholder = " Last Name" name = "lastname" required>
                            </h1>
                            <h1>
                                Gender: <select class = "gender" name = "gender" required>
                                             <option value="" disabled selected>Please choose a Gender</option>
                                            <option value = "M">Male</option>
                                            <option value = "F">Female</option>
                                            <option value = "N">Neither</option>
                                                
                                        </select>
                            </h1>

                            <h1>College:
                                <select class = "college" id = "college" name="college" onchange = "course(this.id, 'degree');" required>
                                    <option value="" disabled selected>Please choose a College</option>
                                    <option value = "College of Science">College of Science</option>
                                    <option value = "College of Arts and Communication">College of Arts and Communication</option>
                                    <option value = "College of Social Science">College of Social Science</option>
                                </select>
                            </h1>
                            <h1>Degree:
                                <select class = "degree" id = "degree" name = "degree" required disabled>
                                    <option value="" disabled selected>Please choose a Degree</option>
                                </select>
                            </h1>
                            <h1>College Secretary:
                                <input type = "text" name = "collegesec" placeholder = "Name of the College Secretary (Include Title/s)" required>
                            </h1>

                            <h1>Purpose (i.e. medical school application, master's application, employment application,etc):
                                <input type = "text" id = "purpose" name = "purpose" placeholder = " What is the certificate for?" required>
                            </h1>
                            <div id = "is-laude-div">
                                <h1>Include Laude?
                                    <select class = "" name = "laude" id = "is-laude"  required>
                                        <option value="" disabled selected>Please choose yes or no</option>
                                        <option value="yes"> Yes</option>
                                        <option value="no"> No</option>
                                    </select>
                                </h1>
                            </div>
                             <h1>GWA:
                                <select class = "gwa" name="gwaselection" id ="gwaselection"  required onchange = "gwasubmit(this);">
                                    <option value="" disabled selected>Please choose the GWA</option>
                                    <option value = "<?php echo  $_SESSION['GWA'];?>">Overall GWA</option>
                                    <option value="100"> Pick the Semesters</option>
                                </select>
                            </h1>
                            <div id="checkboxes" style="display:none">
                                <?php
                                for($x=0;$x< $_SESSION['countyearsem'];$x++){
                                        echo '<input class="ch" style="width:20px;height:20px;margin-left:5%" type="checkbox" name="check_list[]" value="'.$_SESSION['YearandSemGWA'][$x].'" checked><label> '.$_SESSION['YearandSem'][$x].'</label> <br>'; }
                                ?>
                            <br>
                            <h1>Additional info GWA (i.e. First Year, First year and Second year, First Semester of Year 2019-2020,etc):
                                <input type = "text" id = "additionalinfo" name = "additionalinfo" placeholder = "What is the year or the semesters of the checked GWA?" >
                            </h1>

                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal_button btn btn-default" name="btncancel"data-dismiss="modal">Cancel</button>
                        <button type="submit"  class="modal_button btn btn-primary" name="btnproceed" >Continue </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
<!--Print MODAL END-->