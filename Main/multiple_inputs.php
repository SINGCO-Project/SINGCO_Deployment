<!-- This file contains the javascript functions used for multiple entries in the add modal which includes addEntry(),
sortCourses(), removeEntry(), limit(), removeRows() and the JQuery for the select2 library which is used to
implement the search dropdowns -->

<script>

//ADD ENTRY FUNCTION START
function addEntry() {
    var count = document.getElementById("rowCount");
    var manualTable = document.getElementById("course-info");
    var currentRow = manualTable.insertRow(-1);
    //Need to +1 to currentIndex since the value of rowCount will only change after adding a new row
    var currentIndex = count.value; currentIndex++;
    var rowIndex = "row" + currentIndex;
    currentRow.setAttribute("id", rowIndex);
    var courseIndex = "course" + currentIndex;
    var gradeIndex = "grade" + currentIndex;
    var removalDivIndex = "removal" + currentIndex;
    var removalSelIndex = "removal-grade" + currentIndex;

    //Cell for remove btn
    var remEntry = document.createElement("i");
    remEntry.setAttribute("class", "fa fa-trash-o");
    remEntry.setAttribute("id", currentIndex);
    remEntry.onclick = function(){removeEntry(remEntry.id)};
    var currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(remEntry);

    //Cell for courses
    var courseSelect = document.createElement("select");
    courseSelect.setAttribute("name", courseIndex);
    courseSelect.setAttribute("id", courseIndex);
    courseSelect.required = true;
    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(courseSelect);
    //Default value
    var courseOption = document.createElement("option");
    courseOption.setAttribute("value", "");
    courseOption.setAttribute("selected", true);
    courseOption.disabled = true;
    var optionText = document.createTextNode("Choose Course");
    courseOption.appendChild(optionText);
    document.getElementById(courseIndex).appendChild(courseOption);

    //Filling select with db data
    var sort = document.getElementById("sort").value;
    //If the currently selected value in the sort dropdown is ALL, 
    //select all courses in the checklist
    if (sort == "ALL") {
        <?php

        $i=0;
        $courses_check=array();

        foreach ($PDO->query("select * from grades where user_id='".$_SESSION['UserID']."'") as $row){
            $courses_check[$i]=$row['course']."_".$row['state'];
            $i++;}

        foreach ($PDO->query("select * from checklist") as $row) {
             $state1="NULL";
            foreach ($courses_check as $c) {
              $cut = explode('_', $c);
            if ($cut[0]==$row['CourseID'])
                  $state1=$cut[1];

            }
            $courseDesc = $row['CourseName']." (".ucwords(strtolower($row['CourseDesc'])).")";
            $courseDescFull = addslashes($courseDesc);
            echo "var courseOption = document.createElement('option');";
            if($state1 == "1") {
                echo "courseOption.disabled = true;";
                $taken = " Maximum No. of Takes Reached";
            } else {$taken = "";}
            echo"courseOption.setAttribute('value', '".$row['CourseID']."');
                var optionText = document.createTextNode('".$courseDescFull." ".$taken."');
                courseOption.appendChild(optionText);
                document.getElementById(courseIndex).appendChild(courseOption);";
            }
        ?>
    }

    //If the currently selected value in the sort dropdown is NEW, 
    //select all courses in the checklist with Status = 'NEW'
    if (sort == "NEW") {
        <?php

        $i=0;
        $courses_check=array();

        foreach ($PDO->query("select * from grades where user_id='".$_SESSION['UserID']."'") as $row){
            $courses_check[$i]=$row['course']."_".$row['state'];
            $i++;}

        foreach ($PDO->query("select * from checklist where Status = 'NEW'") as $row) {
             $state1="NULL";
            foreach ($courses_check as $c) {
              $cut = explode('_', $c);
            if ($cut[0]==$row['CourseID'])
                  $state1=$cut[1];

            }
            $courseDesc = $row['CourseName']." (".ucwords(strtolower($row['CourseDesc'])).")";
            $courseDescFull = addslashes($courseDesc);
            echo "var courseOption = document.createElement('option');";
            if($state1 == "1") {
                echo "courseOption.disabled = true;";
                $taken = " Maximum No. of Takes Reached";
            } else {$taken = "";}
            echo"courseOption.setAttribute('value', '".$row['CourseID']."');
                var optionText = document.createTextNode('".$courseDescFull." ".$taken."');
                courseOption.appendChild(optionText);
                document.getElementById(courseIndex).appendChild(courseOption);";
            }
        ?>
    }

    //If the currently selected value in the sort dropdown is OLD,
    //select all courses in the checklist with Status = 'OLD'
    if (sort == "OLD") {
        <?php

        $i=0;
        $courses_check=array();

        foreach ($PDO->query("select * from grades where user_id='".$_SESSION['UserID']."'") as $row){
            $courses_check[$i]=$row['course']."_".$row['state'];
            $i++;}

        foreach ($PDO->query("select * from checklist where Status = 'OLD'") as $row) {
             $state1="NULL";
            foreach ($courses_check as $c) {
              $cut = explode('_', $c);
                  // echo "<option>Fuck". $row['CourseID']." </option>";
            if ($cut[0]==$row['CourseID'])
                  $state1=$cut[1];

            }
            $courseDesc = $row['CourseName']." (".ucwords(strtolower($row['CourseDesc'])).")";
            $courseDescFull = addslashes($courseDesc);
            echo "var courseOption = document.createElement('option');";
            if($state1 == "1") {
                echo "courseOption.disabled = true;";
                $taken = " Maximum No. of Takes Reached";
            } else {$taken = "";}
            echo"courseOption.setAttribute('value', '".$row['CourseID']."');
                var optionText = document.createTextNode('".$courseDescFull." ".$taken."');
                courseOption.appendChild(optionText);
                document.getElementById(courseIndex).appendChild(courseOption);";
            }
        ?>
    }

    // Cell for course grade
    var gradeSelect = document.createElement("select");
    gradeSelect.setAttribute("name", gradeIndex);
    gradeSelect.setAttribute("id", gradeIndex);
    gradeSelect.required = true;
    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(gradeSelect);
    //Default value
    var gradeOption = document.createElement("option");
    gradeOption.setAttribute("value", "");
    gradeOption.setAttribute("selected", true);
    gradeOption.disabled = true;
    var optionText = document.createTextNode("Choose Grade");
    gradeOption.appendChild(optionText);
    document.getElementById(gradeIndex).appendChild(gradeOption);
    //Filling select with array data
    var grades = ["1.00", "1.25", "1.50", "1.75", "2.00", "2.25", "2.50", "2.75", "3.00", "4.00", "5.00","DFR","DRP","FAIL","INC","PASS"];
    for(i = 0; i < grades.length; i++) {
        var gradeOption = document.createElement("option");
        gradeOption.setAttribute("value", grades[i]);
        var optionText = document.createTextNode(grades[i]);
        gradeOption.appendChild(optionText);
        document.getElementById(gradeIndex).appendChild(gradeOption);
    }

    //Cell for removal grade
    var removalSelect = document.createElement("select");
    removalSelect.setAttribute("name", removalSelIndex);
    removalSelect.setAttribute("id", removalSelIndex);
    removalSelect.style.display = "none";
    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(removalSelect);
    //Default value
    var remGradeOption = document.createElement("option");
    remGradeOption.setAttribute("value", "");
    remGradeOption.setAttribute("selected", true);
    remGradeOption.disabled = true;
    var optionText = document.createTextNode("Choose Removal Grade");
    remGradeOption.appendChild(optionText);
    document.getElementById(removalSelIndex).appendChild(remGradeOption);
    //Filling select with array data
    var removalGrades = ["3.00","4.00" ,"5.00"];
    for(i = 0; i < removalGrades.length; i++) {
        var gradeOption = document.createElement("option");
        gradeOption.setAttribute("value", removalGrades[i]);
        var optionText = document.createTextNode(removalGrades[i]);
        gradeOption.appendChild(optionText);
        document.getElementById(removalSelIndex).appendChild(gradeOption);
    }

    //Setting the onchange functions for courseSelect and gradeSelect
    courseSelect.onchange = function(){disable(courseSelect.id);};
    gradeSelect.onchange = function(){gradeChange(gradeSelect.id, removalSelect.id);};
    //Incrementing the value stored in rowCount by 1 after adding the new row
    var currentCount = document.getElementById("rowCount").value;
    currentCount++;
    document.getElementById("rowCount").value = currentCount;
    disable("course1");
    limit();

    //For dropdown search
     var countcount=document.getElementById("rowCount").value;
     countindex=countcount;

    for ( var i = 1; i <=countindex; i++) {
        $('#course'+i).select2({
            dropdownParent: $("#info-modal"),
        });
    }
    var table = document.getElementById("course-info").rows.length;
     //For dropdownsearch
}
//ADD ENTRY FUNCTION END

//SORT COURSES FUNCTION START
function sortCourses() {
    var count = document.getElementById("rowCount").value;
    var courseSort = document.getElementById("sort").value;

    //Traverse all rows in the table
    for (j = 1; j <= count; j++) {
        //Array of subjects per Status (ALL, NEW, OLD) start
        var newCourses = "<option value = '' disabled>Choose Course</option>" + "<?php $i=0;
                                $courses_check=array();
                                foreach ($PDO->query("select * from grades where user_id='".$_SESSION['UserID']."'") as $row){
                                    $courses_check[$i]=$row['course']."_".$row['state'];
                                $i++;}

                                foreach ($PDO->query("select * from checklist where Status = 'NEW'") as $row){
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
                                }?>";
        var oldCourses = "<option value = '' disabled>Choose Course</option>" + "<?php $i=0;
                                $courses_check=array();
                                foreach ($PDO->query("select * from grades where user_id='".$_SESSION['UserID']."'") as $row){
                                    $courses_check[$i]=$row['course']."_".$row['state'];
                                $i++;}

                                foreach ($PDO->query("select * from checklist where Status = 'OLD'") as $row){
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
                                }?>";
        var allCourses = "<option value = '' disabled>Choose Course</option>" + "<?php $i=0;
                                $courses_check=array();
                                foreach ($PDO->query("select * from grades where user_id='".$_SESSION['UserID']."'") as $row){
                                    $courses_check[$i]=$row['course']."_".$row['state'];
                                $i++;}

                                foreach ($PDO->query("select * from checklist") as $row){
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
                                }?>";
        //Array of subjects per Status (ALL, NEW, OLD) end

        var selectID = document.getElementById("course" + j);
        if(selectID) {
            if(courseSort == "NEW") {
                var selectedCourse = selectID.value;
                if(selectedCourse == "") {selectedCourse = "null";}
                var pos = newCourses.search(selectedCourse);
                if(pos != -1) {
                    var newCourses = [newCourses.slice(0, pos-8), "selected ", newCourses.slice(pos-8)].join('');
                } else {
                    var newCourses = [newCourses.slice(0, 8), "selected ", newCourses.slice(8)].join('');
                }
                $(selectID).find('option').remove();
                $(selectID).html(newCourses);
            }
            if(courseSort == "OLD") {
                var selectedCourse = selectID.value;
                if(selectedCourse == "") {selectedCourse = "null";}
                var pos = oldCourses.search(selectedCourse);
                if(pos != -1) {
                    var oldCourses = [oldCourses.slice(0, pos-8), "selected ", oldCourses.slice(pos-8)].join('');
                } else {
                    var oldCourses = [oldCourses.slice(0, 8), "selected ", oldCourses.slice(8)].join('');
                }
                $(selectID).find('option').remove();
                $(selectID).html(oldCourses);
            }
            if(courseSort == "ALL") {
                var selectedCourse = selectID.value;
                if(selectedCourse == "") {selectedCourse = "null";}
                var pos = allCourses.search(selectedCourse);
                if(pos != -1) {
                    var allCourses = [allCourses.slice(0, pos-8), "selected ", allCourses.slice(pos-8)].join('');
                } else {
                    var allCourses = [allCourses.slice(0, 8), "selected ", allCourses.slice(8)].join('');
                }
                $(selectID).find('option').remove();
                $(selectID).html(allCourses);
            }
        }
    }
    disable("course1");
}
//SORT COURSES FUNCTION END

//REMOVE ENTRY/ROW FUNCTION START
function removeEntry(rowID) {
    document.getElementById("row" + rowID).remove();
    var count = document.getElementById("rowCount").value;    
    var reindex = parseInt(rowID) + 1;//Index of the row directly below the row being deleted
    var newRowIndex, newRemBtnIndex, newCourseIndex, newGradeIndex, newRemGradeIndex;
    //Traverse all the rows below the row being deleted and reindex the row number, 
    //remove button, course, grade and removal grade
    for(i = reindex; i <= count; i++) {
        newRowIndex = "row" + (i - 1);
        newRemBtnIndex = i - 1;
        newCourseIndex = "course" + (i - 1);
        newGradeIndex = "grade" + (i - 1);
        newRemGradeIndex = "removal-grade" + (i - 1);
        document.getElementById("row" + i).setAttribute("id", newRowIndex);
        document.getElementById(i).setAttribute("name", newRemBtnIndex);
        document.getElementById(i).setAttribute("id", newRemBtnIndex);
        document.getElementById("course" + i).setAttribute("name", newCourseIndex);
        document.getElementById("course" + i).setAttribute("id", newCourseIndex);
        document.getElementById("grade" + i).setAttribute("name", newGradeIndex);
        document.getElementById("grade" + i).setAttribute("id", newGradeIndex);
        document.getElementById("removal-grade" + i).setAttribute("name", newRemGradeIndex);
        document.getElementById("removal-grade" + i).setAttribute("id", newRemGradeIndex);
    }
    document.getElementById("rowCount").value = count - 1;
    disable('course1');
    limit();
}
//REMOVE ENTRY/ROW FUNCTION START

//Limits the number of rows per Add modal to 5 by hiding the text link
//for adding new entries
function limit() {
    var courseTable = document.getElementById("course-info");
    if(courseTable.rows.length == 5) {
        $('#add').hide();
    } else {
        $('#add').show();
    }
}

//Resets the Add modal to its default configurations and selected options
function removeRows() {
    var table = document.getElementById("course-info");
    var numRows = table.rows.length;
    if(numRows > 1) {
        for(i = 0; i < numRows - 1; i++) {
            table.deleteRow(1);
        }
    }
   
    $("select[id='year']").val("").trigger("change");
    $("select[id='course1']").val("").trigger("change");
    
    $('#rowCount').val("1");
    $('select').val("");
    $('#sort').val("NEW");
    $('#add').show();
}

//select2 code
$(document).ready(function() {
    $('#course1').select2({
      dropdownParent: $("#info-modal"),
    });
});

jQuery(document).ready(function($){
    $("select[id='year']").select2({height:100});
});
 
jQuery(document).ready(function($){
    $("select[id='acad-year-edit']").select2({height:100});
});
    
jQuery(document).ready(function($){
    $("select[id='course-edit']").select2({height:100});
});
    
    
    
</script>
