//This file contains the javascript functions course() and gwasubmit()

//For dynamic changing of degrees in the Degree dropdown
function course(collegeSelect, degreeSelect) {
    var collegeSelect = document.getElementById(collegeSelect);
   var degreeSelect = document.getElementById(degreeSelect);
   degreeSelect.innerHTML = "<option value='' disabled selected>Please choose a Degree</option>";

   if (collegeSelect.value == "College of Science") {
      var optionArray =  [
                        "Bachelor of Science in Biology",
                        "Bachelor of Science in Computer Science",
                        "Bachelor of Science in Mathematics",
                        "Bachelor of Science in Physics",
                        "Master of Science in Conservation and Restoration Ecology",
                        "Master of Science in Mathematics",
                        "Doctor of Philosophy in Mathematics"];
       document.getElementById("degree").disabled = false;
   } else if (collegeSelect.value == "College of Social Science") {
      var optionArray =  [
                        "Bachelor of Arts in Social Sciences",
                        "Bachelor of Arts in Social Sciences Major in Anthropology and Minor in Philosophy",
                        "Bachelor of Arts in Social Sciences Major in Anthropology and Minor in Political Science",
                        "Bachelor of Arts in Social Sciences Major in Antropology and Minor in Psychology",
                        "Bachelor of Arts in Social Sciences Major in Anthropology and Minor in Sociology",
                        "Bachelor of Arts in Social Sciences Major in Economics and Minor in Philosophy",
                        "Bachelor of Arts in Social Sciences Major in Economics and Minor in Political Science",
                        "Bachelor of Arts in Social Sciences Major in Economics and Minor in Psychology",
                        "Bachelor of Arts in Social Sciences Major in Economics and Minor in Sociology",
                        "Bachelor of Arts in Social Sciences Major in History and Minor in Philosophy",
                        "Bachelor of Arts in Social Sciences Major in History and Minor in Political Science",
                        "Bachelor of Arts in Social Sciences Major in History and Minor in Psychology",
                        "Bachelor of Arts in Social Sciences Major in History and Minor in Sociology",
                        "Bachelor of Science in Management Economics",
                        "Master of Arts in Social and Development Studies",   
                        "Master of Management"
                        ];
       document.getElementById("degree").disabled = false;
   } else if (collegeSelect.value == "College of Arts and Communication") {
      var optionArray =  [
                        "Bachelor of Arts in Communication",
                        "Bachelor of Arts in Communication Major in Broadcast Communication and Minor in Journalism",
                        "Bachelor of Arts in Communication Major in Broadcast Communication and Minor Speech Communication",
                        "Bachelor of Arts in Communication Major in Journalism and Minor in Broadcast Communication",
                        "Bachelor of Arts in Communication Major in Journalism and Minor Speech Communication",
                        "Bachelor of Arts in Communication Major in Speech Communication and Minor in Broadcast Communication",
                        "Bachelor of Arts in Communication Major in Speech Communication and Minor in Journalism",
                        "Bachelor of Arts in Language and Literature",
                        "Bachelor of Fine Arts",
                        "Certificate in Fine Arts",
                        "Master of Arts in Language and Literature"
                        ];
       document.getElementById("degree").disabled = false;
   }

    for (var option in optionArray) {
      var value = optionArray[option];
      var newOption = document.createElement("option");
        newOption.value = value;
        newOption.innerHTML = value;
        degreeSelect.options.add(newOption);
   }

}

//Creating checkboxes for Pick the Semesters
function gwasubmit(sign) {
    var signcheck = sign.options[sign.selectedIndex].value;
    var div = document.getElementById("checkboxes");
    var addinfo = document.getElementById("additionalinfo");
    var cl = document.getElementById("check_list[]");

    if (signcheck == "100") {
        div.style.display = "block";
        addinfo.setAttribute("required");
    }
    else {
        div.style.display = "none";
    }
}


