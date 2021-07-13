<!-- This file generates the preview page for the GWA Certificate and uses the information submitted
from the Print modal form -->

<?php
session_start();
require  "../Database.php";
$PDO = Database::letsconnect();

//SESSION ID CHECK
    if (empty($_SESSION['UserID']))
         header("Location: ../Log_In/login.php");
    $scan=null;
    foreach ($PDO->query("SELECT * FROM certificate WHERE user_id = '".$_SESSION['UserID']."'") as $row) 
        $scan=$row['gwa'];
    if ($scan==null)
         header("Location: ../Main/main.php");
    if ($_SESSION['Type'] == "Admin")
         header("Location: ../Main/admin.php");

foreach ($PDO->query("SELECT * FROM certificate WHERE user_id = '".$_SESSION['UserID']."'") as $row) {
	$gwa = $row['gwa'];
     if(preg_match("/[a-z]/i",$row['middle_initial']))   
        $mi=$row['middle_initial'].". ";
    else
         $mi="";
        
	$name = $row['first_name']." ".$mi.$row['last_name'];
	$lastname = $row['last_name'];
    //Identifying the pronouns
	if ($row['gender'] == "F") {
		$title = "Ms.";
		$title2 = "her";
	}
	else if ($row['gender'] == "M") {	
		$title = "Mr.";
		$title2 = "his";
	}
    else{
        $title = "Mx.";
		$title2 = "their";
    }
	$degree = $row['degree'];
	$add_info = $row['add_info'];
	$purpose = $row['purpose'];
	$date = $row['date'];
	$date_split = explode("-", $date);
	$college = $row['college'];
	$college_sec = $row['college_sec'];
	$college = $row['college'];
	$is_laude = " ";
	if ($row['is_laude'] != "0"){
		$is_laude = ", ".$row['is_laude']." ";
	}
	$add_info = $row['add_info'];
	$secretary = "Secretary, ".$row['college'];
}

?>
<html>
<head>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
   
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
    <link rel="stylesheet" href="../css/printmodal.css" type="text/css">
    <script src="../Modal/popper.min.js"></script>
    <script src="../Modal/bootstrap.min.js"></script>
    <!-- Modal-->
    <script src = "../js/modalform.js"></script>
     <!-- Upload Modal-->
    <script src="../js/dragndrop2.js"></script>
    <link rel="stylesheet" href="../css/dragndrop2.css">
    <link rel="stylesheet" href="../Modal/modalUpload.css">
     <!-- Upload Modal-->
     <!-- (K) ICONS -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>


<style type="text/css">
    p{
    color:black;
  font-size: 17px;
  line-height: 20px;
  font-weight: 400;
  text-align: left;
        font-family: arial;
}

    
</style>
    <!-- LOGO -->
<nav id="home">
  <div class="nav_overlay">
    <div class="left">
        <img src="../images/singco-logo.svg" class="navlogo"alt="" width="28px">
    </div>
    <div class="middle">
        <a href="../Main/main.php"><i data-feather="home"  title="Home"></i></a>
        <i data-feather="edit"  title="Edit" onclick="printedit();"></i>
        <a href="output.php"><i data-feather="download"  title="Download"></i></a>
    </div>
    <div class="right">
        <h4 class="username"><?php echo $_SESSION['UserName'];?></h4>
      <a onclick="logoutmodal()"><i data-feather="log-out" id="log_out" title="Logout"></i></a>
    </div>
  </div>
</nav>
<body style = "
	width: 100%;
	height: 100%;
	margin: 0;
	padding: 0;
	background-color: #121212;">

<div class = "main" style="margin-top:7%">   
    
	<div class = "page" id = "page" style = "
		width: 210mm;
	    min-height: 297mm;
	    margin: 10mm auto;
	    border: 1px #D3D3D3 solid;
	    border-radius: 5px;
	    background: white;
	    padding-top: 0;">
	<div class = "margin-cert" style = "
		margin-top: 25.4mm;
		margin-left: 31mm;
		margin-right: 31mm;
		margin-bottom: 3.67cm;">
		<div class = "heading" style = "text-align: <?php if ($college=="College of Social Science") echo "left";
                                        else echo "center";?>;">
             <?php   if ($college=="College of Arts and Communication"){
                            $image="cac.jpg";
                            $size="27mm";}
                        else if ($college=="College of Social Science"){
                            $image= "up.png";
                            $size="23.5mm";}
                        else{ 
                            $image="cs.jpg";
                            $size="23.5mm";
                        }
                ?>
			<img  src = "../images/<?php echo $image;?>" id="collegelogo" style = "padding:0;margin:0;width: <?php echo $size;?>;">
            <?php 
                if ($college=="College of Arts and Communication")
			         echo '<div style = "width: 1mm; display: inline-block;"></div>';
			     else if ($college=="College of Social Science")
                        echo '<div style = "width: 6mm; display: inline-block;"></div>';
                 else
                    echo '<div style = "width: 3mm; display: inline-block;"></div>';
                
            ?>
			<div class = "headingtext" style = "display: inline-block; text-align: left; font-family: Calibri;">
                <p id="collegename" style = " font-size: 12.2pt; font-weight: bold; margin: 0;padding: 0">
                    <?php echo  strtoupper($college);?></p>
				<p id="collegeinfo" style = "font-size: 11.5pt;margin: 0;padding: 0">
					University of the Philippines Baguio<br>
					Governor Pack Road, Baguio City 2600<br>
					  <?php   if ($college=="College of Arts and Communication")                
                            echo "Tel. (074)444-8393<br>E-mail Address: cac-ocs.upbaguio@up.edu.ph<br>" ;
                        else if ($college=="College of Social Science")
                            echo "Tel. (074)442-2427<br>E-mail Address: css-ocs.upbaguio@up.edu.ph<br>";
                        else
                            echo "Tel. (074) 442-7231<br>E-mail Address: cs-ocs.upbaguio@up.edu.ph<br>";                            
                ?>
				</p>
				<script type="text/javascript">
				</script>
			</div>
             <?php 
                if ($college!="College of Arts and Communication")
			     echo '<div style = "width: 3mm; display: inline-block;"></div>';
             if ($college!="College of Social Science")
            echo '<img class = "uplogo" src = "../images/up.png" style = "width: 23.5mm; display:inline-block;">';
            ?>
		</div>
		<hr style = "background-color: black; height: 0.7px;margin-top:10px">
		<br><br><br>
		<div class = "main-certificate" style = "text-align: center;">
			<p style = "font-family: Arial; font-weight: bold; font-size: 16pt;margin-bottom: 6px;margin-top: 6px;text-align:center"> C E R T I F I C A T I O N</p>
			<br><br><br>
            <?php 
            $add_info=trim($add_info);
            $add_info_str="";
            if ($add_info!="")
                $add_info_str= " in the ".$add_info;
            ?>
			<p style = "text-align:justify;font-family: Arial; font-size: 12pt;">
				This is to certify that <b><u><?php echo strtoupper($title.' '.$name);?></u></b> obtained a General Weighted Average (GWA) of <b><u><?php echo $gwa;?></u></b><?php echo $add_info_str."<i>".$is_laude."</i>";?> in the <?php echo $degree;?>.
				<br><br>Issued this <?php echo $date_split[0].' day of '.$date_split[1].' '.$date_split[2].' upon the request of '.$title.' '.$lastname.' for '.$title2.' '.$purpose.'.';?>
			
			</p><br><br><br><br><br>
			<p align = "left" style = "font-family: Arial;"><b><?php echo strtoupper($college_sec);?></b><br><?php echo $secretary;?></p>


		</div>
	</div>
	</div>
</div>
</body>

<!-- Print MODAL-->
<!-- For editing the information on the certificate -->
    <form method="post">
        <div id="printedit-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title">Edit Certificate Information</div>
                        <div class="close"  name="closedelete"data-dismiss="modal" aria-hidden="true">&times;</div>
                    </div>
                    <div class="modal-body">
                        <form method = "post">
                            <h1><b>Please enter the necessary information below.</b></h1><br>
                            <h1>
                                Student Name
                                <br>
                                <?php foreach ($PDO->query("SELECT * FROM certificate WHERE user_id='".$_SESSION['UserID']."'") as $rows){
                                $fn=$rows['first_name'];
                                $mi=$rows['middle_initial'];
                                $ln=$rows['last_name'];
                                $gender=$rows['gender'];
                                $degree=$rows['degree'];
                                $purpose=$rows['purpose'];
                                $college=$rows['college'];
                                $college_sec=$rows['college_sec'];
                                $islaude=$rows['is_laude'];
                                $add_info=$rows['add_info'];
                                $rowgwa=$rows['gwa'];                                
                                    }
                                ?>
                                <input type = "text" placeholder = " First Name" name = "firstname" value="<?php echo $fn;?>" required><br>
                                <input type = "text" placeholder = " Middle Initial" name = "middleinitial" value="<?php echo $mi;?>"><br>
                                <input type = "text" placeholder = " Last Name" name = "lastname" value="<?php echo $ln;?>"required>
                            </h1>
                            <h1>
                                Gender: <select class = "gender" name = "gender" required>
                                            <option value = "M" <?php if($gender=="M") echo "selected";?>>Male</option>
                                            <option value = "F"  <?php if($gender=="F") echo "selected";?>>Female</option>
                                              <option value = "N"  <?php if($gender=="N") echo "selected";?>>Neither</option>
                                        </select>
                            </h1>

                            <h1>College:
                                <select class = "college" id = "college" name="college" onchange = "course(this.id, 'degree');" required>
                                    <option value = "College of Science" <?php if($college=="College of Science") echo "selected";?>>College of Science</option>
                                    <option value = "College of Arts and Communication" <?php if($college=="College of Arts and Communication") echo "selected";?>>College of Arts and Communication</option>
                                    <option value = "College of Social Science" <?php if($college=="College of Social Science") echo "selected";?>>College of Social Science</option>
                                </select>
                            </h1>
                            <h1>Degree:
                                <select class = "degree" id = "degree" name = "degree" required>
                                    <?php 
                                    
                                    if ($college=="College of Arts and Communication") {
                                        $sel="";if($degree=="Bachelor of Arts in Communication"){$sel="selected";}
                                        echo "<option value='Bachelor of Arts in Communication' ".$sel.">Bachelor of Arts in Communication</option>";    
                                        $sel="";if($degree=="Bachelor of Arts in Communication Major in Broadcast Communication and Minor in Journalism"){$sel="selected";}
                                        echo "<option value='Bachelor of Arts in Communication Major in Broadcast Communication and Minor in Journalism' ".$sel.">Bachelor of Arts in Communication Major in Broadcast Communication and Minor in Journalism</option>";    
                                        $sel="";if($degree=="Bachelor of Arts in Communication Major in Broadcast Communication and Minor Speech Communication"){$sel="selected";}
                                        echo "<option value='Bachelor of Arts in Communication Major in Broadcast Communication and Minor Speech Communication' ".$sel.">Bachelor of Arts in Communication Major in Broadcast Communication and Minor Speech Communication</option>";    
                                        $sel="";if($degree=="Bachelor of Arts in Communication Major in Journalism and Minor in Broadcast Communication"){$sel="selected";}
                                        echo "<option value='Bachelor of Arts in Communication Major in Journalism and Minor in Broadcast Communication' ".$sel.">Bachelor of Arts in Communication Major in Journalism and Minor in Broadcast Communication</option>";    
                                        $sel="";if($degree=="Bachelor of Arts in Communication Major in Journalism and Minor Speech Communication"){$sel="selected";}
                                        echo "<option value='Bachelor of Arts in Communication Major in Journalism and Minor Speech Communication' ".$sel.">Bachelor of Arts in Communication Major in Journalism and Minor Speech Communication</option>";    
                                        $sel="";if($degree=="Bachelor of Arts in Communication Major in Speech Communication and Minor in Broadcast Communication"){$sel="selected";}
                                        echo "<option value='Bachelor of Arts in Communication Major in Speech Communication and Minor in Broadcast Communication' ".$sel.">Bachelor of Arts in Communication Major in Speech Communication and Minor in Broadcast Communication</option>";
                                        $sel="";if($degree=="Bachelor of Arts in Communication Major in Speech Communication and Minor in Journalism"){$sel="selected";}
                                        echo "<option value='Bachelor of Arts in Communication Major in Speech Communication and Minor in Journalism' ".$sel.">Bachelor of Arts in Communication Major in Speech Communication and Minor in Journalism</option>";      
                                        $sel="";if($degree=="Bachelor of Arts in Language and Literature"){$sel="selected";}
                                        echo "<option value='Bachelor of Arts in Language and Literature' ".$sel.">Bachelor of Arts in Language and Literature</option>";    
                                        $sel="";if($degree=="Bachelor of Fine Arts"){$sel="selected";}
                                        echo "<option value='Bachelor of Fine Arts' ".$sel.">Bachelor of Fine Arts</option>";   
                                        $sel="";if($degree=="Certificate in Fine Arts"){$sel="selected";}
                                        echo "<option value='Certificate in Fine Arts' ".$sel.">Certificate in Fine Arts</option>";
                                        $sel="";if($degree=="Master of Arts in Language and Literature"){$sel="selected";}
                                        echo "<option value='Master of Arts in Language and Literature' ".$sel.">Master of Arts in Language and Literature</option>";  
                                    }               
                                    else if ($college=="College of Social Science"){
                                        $sel="";if($degree=="Bachelor of Arts in Social Sciences"){$sel="selected";}
                                        echo "<option value='Bachelor of Arts in Social Sciences' ".$sel.">Bachelor of Arts in Social Sciences</option>";
                                        $sel="";if($degree=="Bachelor of Arts in Social Sciences Major in Anthropology and Minor in Philosophy"){$sel="selected";}
                                        echo "<option value='Bachelor of Arts in Social Sciences Major in Anthropology and Minor in Philosophy' ".$sel.">Bachelor of Arts in Social Sciences Major in Anthropology and Minor in Philosophy</option>";
                                        $sel="";if($degree=="Bachelor of Arts in Social Sciences Major in Anthropology and Minor in Political Science"){$sel="selected";}
                                        echo "<option value='Bachelor of Arts in Social Sciences Major in Anthropology and Minor in Political Science' ".$sel.">Bachelor of Arts in Social Sciences Major in Anthropology and Minor in Political Science</option>";
                                        $sel="";if($degree=="Bachelor of Arts in Social Sciences Major in Antropology and Minor in Psychology"){$sel="selected";}
                                        echo "<option value='Bachelor of Arts in Social Sciences Major in Antropology and Minor in Psychology' ".$sel.">Bachelor of Arts in Social Sciences Major in Antropology and Minor in Psychology</option>";
                                        $sel="";if($degree=="Bachelor of Arts in Social Sciences Major in Anthropology and Minor in Sociology"){$sel="selected";}
                                        echo "<option value='Bachelor of Arts in Social Sciences Major in Anthropology and Minor in Sociology' ".$sel.">Bachelor of Arts in Social Sciences Major in Anthropology and Minor in Sociology</option>";
                                        $sel="";if($degree=="Bachelor of Arts in Social Sciences Major in Economics and Minor in Philosophy"){$sel="selected";}
                                        echo "<option value='Bachelor of Arts in Social Sciences Major in Economics and Minor in Philosophy' ".$sel.">Bachelor of Arts in Social Sciences Major in Economics and Minor in Philosophy</option>";
                                        $sel="";if($degree=="Bachelor of Arts in Social Sciences Major in Economics and Minor in Political Science"){$sel="selected";}
                                        echo "<option value='Bachelor of Arts in Social Sciences Major in Economics and Minor in Political Science' ".$sel.">Bachelor of Arts in Social Sciences Major in Economics and Minor in Political Science</option>";
                                        $sel="";if($degree=="Bachelor of Arts in Social Sciences Major in Economics and Minor in Psychology"){$sel="selected";}
                                        echo "<option value='Bachelor of Arts in Social Sciences Major in Economics and Minor in Psychology' ".$sel.">Bachelor of Arts in Social Sciences Major in Economics and Minor in Psychology</option>";
                                        $sel="";if($degree=="Bachelor of Arts in Social Sciences Major in Economics and Minor in Sociology"){$sel="selected";}
                                        echo "<option value='Bachelor of Arts in Social Sciences Major in Economics and Minor in Sociology' ".$sel.">Bachelor of Arts in Social Sciences Major in Economics and Minor in Sociology</option>";
                                        $sel="";if($degree=="Bachelor of Arts in Social Sciences Major in History and Minor in Philosophy"){$sel="selected";}
                                        echo "<option value='Bachelor of Arts in Social Sciences Major in History and Minor in Philosophy' ".$sel.">Bachelor of Arts in Social Sciences Major in History and Minor in Philosophy</option>";
                                        $sel="";if($degree=="Bachelor of Arts in Social Sciences Major in History and Minor in Political Science"){$sel="selected";}
                                        echo "<option value='Bachelor of Arts in Social Sciences Major in History and Minor in Political Science' ".$sel.">Bachelor of Arts in Social Sciences Major in History and Minor in Political Science</option>";
                                        $sel="";if($degree=="Bachelor of Arts in Social Sciences Major in History and Minor in Psychology"){$sel="selected";}
                                        echo "<option value='Bachelor of Arts in Social Sciences Major in History and Minor in Psychology' ".$sel.">Bachelor of Arts in Social Sciences Major in History and Minor in Psychology</option>";
                                        $sel="";if($degree=="Bachelor of Arts in Social Sciences Major in History and Minor in Sociology"){$sel="selected";}
                                        echo "<option value='Bachelor of Arts in Social Sciences Major in History and Minor in Sociology' ".$sel.">Bachelor of Arts in Social Sciences Major in History and Minor in Sociology</option>";
                                        $sel="";if($degree=="Bachelor of Science in Management Economics"){$sel="selected";}
                                        echo "<option value='Bachelor of Science in Management Economics' ".$sel.">Bachelor of Science in Management Economics</option>";
                                        $sel="";if($degree=="Master of Arts in Social and Development Studies"){$sel="selected";}
                                        echo "<option value='Master of Arts in Social and Development Studies' ".$sel.">Master of Arts in Social and Development Studies</option>";
                                        $sel="";if($degree=="Master of Management"){$sel="selected";}
                                        echo "<option value='Master of Management' ".$sel.">Master of Management</option>";
                                      
                                    }
                                    else{
                                        $sel="";if($degree=="Bachelor of Science in Biology"){$sel="selected";}
                                        echo "<option value='Bachelor of Science in Biology' ".$sel.">Bachelor of Science in Biology</option>";
                                        $sel="";if($degree=="Bachelor of Science in Computer Science"){$sel="selected";}
                                        echo "<option value='Bachelor of Science in Computer Science' ".$sel.">Bachelor of Science in Computer Science</option>";
                                        $sel="";if($degree=="Bachelor of Science in Mathematics"){$sel="selected";}
                                        echo "<option value='Bachelor of Science in Mathematics' ".$sel.">Bachelor of Science in Mathematics</option>";
                                        $sel="";if($degree=="Bachelor of Science in Physics"){$sel="selected";}
                                        echo "<option value='Bachelor of Science in Physics' ".$sel.">Bachelor of Science in Physics</option>";
                                        $sel="";if($degree=="Doctor of Philosophy in Mathematics"){$sel="selected";}
                                        echo "<option value='Doctor of Philosophy in Mathematics' ".$sel.">Doctor of Philosophy in Mathematics</option>";
                                        $sel="";if($degree=="Master of Science in Conservation and Restoration Ecology"){$sel="selected";}
                                        echo "<option value='Master of Science in Conservation and Restoration Ecology' ".$sel.">Master of Science in Conservation and Restoration Ecology</option>";
                                        $sel="";if($degree=="Master of Science in Mathematics"){$sel="selected";}
                                        echo "<option value='Master of Science in Mathematics' ".$sel.">Master of Science in Mathematics</option>"; 
                                    }                                    
                                    ?>
                                                                       
                                </select>
                            </h1>
                            <h1>College Secretary:
                                <input type = "text" name = "collegesec" placeholder = "Name of the College Secretary(Include Title/s)" value="<?php echo $college_sec?>"required>
                            </h1>
                            <h1>Purpose (i.e. medical school application, master's application, employment application,etc):
                                <input value="<?php echo $purpose?>" type = "text" id = "purpose" name = "purpose" placeholder = " What is the certificate for?" required>
                            </h1>
                            <div id = "is-laude-edit-div">
                                <h1>Include Laude?
                                    <select class = "" name = "laude" id = "is-laude-edit"  required>
                                        <option value="yes"  <?php if ($islaude!="0") echo "selected";?>> Yes</option>
                                        <option value="no" <?php if ($islaude=="0") echo "selected";?>> No</option>
                                    </select>
                                </h1>
                            </div>
                             <h1>GWA:
                                <select class = "gwa" name="gwaselection" id ="gwaselection"  required onchange = "gwasubmit(this);">
                                    <option value="" disabled selected>Please choose the GWA</option>
                                    <option value = <?php echo  '"'. round(bcdiv($_SESSION['GWA'], 1, 5),4).'"'; if ($rowgwa== round(bcdiv($_SESSION['GWA'], 1, 5),4)) echo "selected";?>  >Overall GWA</option>
                                    <option value="100" <?php if ($rowgwa!= round(bcdiv($_SESSION['GWA'], 1, 5),4)) echo "selected";?>> Pick the Semesters</option>
                                </select>
                            </h1>
                            <div id="checkboxes" style="display:none;">
                                <?php
                                for($x=0;$x< $_SESSION['countyearsem'];$x++){
                                        echo '<input class="ch" style="width:20px;height:20px;margin-left:5%" type="checkbox" name="check_list[]" value="'.$_SESSION['YearandSemGWA'][$x].'"><label> '.$_SESSION['YearandSem'][$x].'</label> <br>'; }
                                ?>
                            <br>
                            <h1>Additional info GWA (i.e. First Year, First year and Second year, First Semester of Year 2019-2020,etc):
                                <input type = "text" id = "additionalinfo" name = "additionalinfo" placeholder = "What is the year or the semesters of the checked GWA?" value="<?php echo $add_info;?>">
                            </h1>                                                         
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal_button btn btn-default" name="btncancel"data-dismiss="modal">Cancel</button>
                        <button type="submit"  class="modal_button btn btn-primary" name="btneditproceed" >Continue </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
<!--Print MODAL END--> 

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

<!-- For showing the edit and logout modals -->
<script>
feather.replace();
function printedit(){
    $(document).ready(function() {
        $("#printedit-modal").modal("show");
    });
}
function logoutmodal(){
    $(document).ready(function() {
        $("#logout-modal").modal("show");
    });
}
</script>
    
</html>


<?php 
foreach ($PDO->query("SELECT * FROM certificate WHERE user_id='".$_SESSION['UserID']."'") as $rows)    
    $gwa=$rows['gwa'];
 if ($gwa!= round(bcdiv($_SESSION['GWA'], 1, 5),4)){//pickgwa
    echo '<script>
    var div = document.getElementById("checkboxes");
    var addinfo = document.getElementById("additionalinfo");
    div.style.display = "block";
    addinfo.setAttribute("required");
    </script>';
 }
 else{//overallgwa
    echo '<script>
     div.style.display = "none";</script>';
 }

//EDIT CERT INFO START
if(isset($_POST['btneditproceed'])) {
        //Obtaining information from Print modal
        $_SESSION['StudentName'] = $_POST['firstname'] . " " . substr($_POST['middleinitial'], 0, 1) . ". " . $_POST['lastname'];
        $_SESSION['LastName'] = $_POST['lastname'];
        $_SESSION['Gender'] = $_POST['gender'];
        $_SESSION['Degree'] = $_POST['degree'];
        $_SESSION['Purpose'] = $_POST['purpose'];
        $purpose = addslashes($_POST['purpose']);
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
                if ($sum==0){
                    foreach ($PDO->query("SELECT * FROM certificate WHERE user_id='".$_SESSION['UserID']."'") as $rows)
                        $gwa=$rows['gwa'];
                }
            }
            else{
                $txt="GWA";
                $gwa= $_SESSION['GWA'];
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
          $mi=substr($_POST['middleinitial'], 0, 1);
        if(preg_match("/[a-z]/i", $additionalinfo)==false)
            $additionalinfo="";
        
      $editsql = "UPDATE certificate SET gwa = '".round(bcdiv($gwa, 1,5),4)."', first_name='".$_POST['firstname']. "', middle_initial='".$mi. "', last_name='".$_POST['lastname']."', gender='".$_POST['gender']."' , degree='".$_POST['degree']."', college='".$_POST['college']."', college_sec='".$_POST['collegesec']."', is_laude='".$laudecert."', add_info='".$additionalinfo."', date='".$date."', purpose='".$purpose."' WHERE user_id='".$_SESSION['UserID']."'";
       $sql = $PDO->prepare($editsql);
    $sql->execute();
     
         echo "<meta http-equiv='refresh' content='0'>";
      
}
//EDIT CERT INFO END


?>