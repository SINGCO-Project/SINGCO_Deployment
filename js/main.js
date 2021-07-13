//This file contains the javascript functions that is used throughout the web application including
//modal(), logoutmodal(), modalupload(), home(), resetmodal(), editModal(), deleteModal(), printmodal(),
//gradeChange(), disable(), enable(), gradeChangeEdit() and editCourses()

//To prevent page from submitting form twice
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}

//Displaying Add modal
function modal(){
    $(document).ready(function() {
        $("#info-modal").modal("show");
    });
        var i=0;
        var curr=new Date().getFullYear();

        for(i=1961;i<=curr;i++){
            var add=i+1;
            $("#year").append("<option value='"+i+"-"+add+"'>"+i+"-"+add+"</option>");
        }
}

//Displaying Logout modal
function logoutmodal(){
    $(document).ready(function() {
        $("#logout-modal").modal("show");
    });
}

//Displaying Upload modal
function modalupload(){
    $(document).ready(function() {
        $("#upload-modal").modal("show");
    });
}

//Back to Top
function home(){
  $(document).ready(function() {
   window.scrollTo({ top: 0, behavior: 'smooth' });

  });
}

//Displaying Reset modal
function resetmodal(){
    $(document).ready(function() {
        $("#reset-modal").modal("show");
    });
}

//Displaying the Edit modal
function editModal(){
    $(document).ready(function() {
        $("#edit-modal").modal("show");
    });
}

//Displaying the Delete modal
function deleteModal(){
    $(document).ready(function() {
        $("#delete-modal").modal("show");
    });
}

//Displaying the Print modal
function printmodal(){
    $(document).ready(function(){
        $("#print-modal").modal("show");});
}

//Showing and hiding of the removal grade dropdown
function gradeChange(grade, removalsel) {
    var gradeSel = document.getElementById(grade);
    var gradeCheck = gradeSel.options[gradeSel.selectedIndex].value;
    var select = document.getElementById(removalsel);
    if (gradeCheck == "4.00") {
        select.style.display = "block";
        select.required=true;
    }
    else {
        select.required=false;
        select.style.display = "none";
    }
}

//Disables the appropriate courses from all the course select dropdowns
function disable(courseID) {
    var selectNum = document.getElementById("rowCount").value;
    var course = document.getElementById(courseID);
    var courseName = course.options[course.selectedIndex].value;
    var subjects = [];
    for (i = 1; i<= selectNum; i++) {
        var sel = document.getElementById("course" + i);
        if (sel) {
            var selValue = sel.value;
            subjects.push(selValue);
        }
    }
    var selected = courseName;
    for (i = 1; i <= selectNum; i++) {
        var index = document.getElementById('course' + i);
        if (index) {
            $('#course' + i + " option").each(function(index) {
                var option = $(this).text();
                var isTaken = option.includes("Maximum");
                if (!isTaken) {
                    $(this).removeAttr("disabled");
                }
            });
        }
    }

    for (j = 0; j < subjects.length; j++) {
        for (k = 1; k <= selectNum; k++) {
            var index = document.getElementById('course' + k);
            if (index) {
                $('#course' + k + " option").each(function(index) {
                    if($(this).val() == subjects[j]) {
                        $(this).attr("disabled", "true");
                    }
                });
            }
        }
    }
}

//Removes the disabled attribute of the course that was submitted
//to prevent it from being disabled indefinitely
function enable() {
    var selectNum = document.getElementById("rowCount").value;
    for (i = 1; i <= selectNum; i++) {
        var sel = document.getElementById("course"+i);
        var selOption = sel.options[sel.selectedIndex];
        selOption.disabled = false;
    }
}

//Showing and hiding of the removal grade dropdown in the edit modal
function gradeChangeEdit(grade) {
    var gradeCheck = grade.options[grade.selectedIndex].value;
    //alert(gradeCheck);
    var div = document.getElementById("removal-edit");
    var select = document.getElementById("removal-grade-edit");
    if (gradeCheck == "4.00") {
        div.style.display = "block";
        select.required=true;
    }
    else {
        div.style.display = "none";
    }
    
}

//Makes the fields editable
function editCourse() {
    document.getElementById("acad-year-edit").removeAttribute("disabled");
    document.getElementById("semester-edit").removeAttribute("disabled");
    document.getElementById("course-edit").removeAttribute("disabled");
    document.getElementById("grade-edit").removeAttribute("disabled");
    document.getElementById("removal-grade-edit").removeAttribute("disabled");
    document.getElementById("btnedit").style.display = "none";
    document.getElementById("btnsave").style.display = "block";
}
