
<?php
/*  This file is the frontend or the UI for the login page where the user can see the descriptions about the web application. The main functions and the main benefits for using the app. Also includes the frontend of contact section where the user can email the admin containing their message.
*/
ob_start();
session_start();
//include "database.php";
//include "checkLogin.php";
include "forgotEmail.php";
include "Contact.php";

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>SINGCO</title>
      <link rel="icon" href="../images/singco-logo.svg" type="image/icon type">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link rel="stylesheet" href="css/login.css">
  </head>
  <body>
      <!--Sign in Modal-->
      <!--Modal for Logging in-->
    <div class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
              <center>
                <form id = "login_form" class="circle" method="post">
                    <br>
                    <h5> Sign In </h5>
                    <input type="text" class="inside_circle_item" placeholder="Enter Username" autocomplete="off" name="uname" required>
                    <br>
                    <input type="password" class="inside_circle_item" placeholder="Enter Password" name="psw" required>
                    <br>
                    <p> <a href="change_password.php" target="_blank"> Forgot Password? </a> </p>
                    <button type="submit" name="button_login">Login</button>
                </form>
              </center>
          </div>
        </div>
    <!--Sign in Modal-->

    <!-- Scroll to top button-->
    <button onclick="topFunction()" id="scroll_top" title="Go to top">Top</button>

      <!-- NAVBAR -->
      <!-- Navbar for Mobile-->
    <nav>
      <div class="hamburger">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
      </div>
      <ul class="nav-links">
        <li>
          <center>
            <form id="m_form" method="post">
                <h4>Sign In</h4>
                <input type="text" class="inside_circle_item" placeholder="Enter Username" autocomplete="off" name="uname" required>
                <br>
                <input type="password" class="inside_circle_item" placeholder="Enter Password" name="psw" required>
                <br>
                <p> <a href="change_password.php" target="_blank"> Forgot Password? </a> </p>
                <button type="submit" name="button_login">Login</button>
            </form>
          </center>
        </li>
        <li><a onclick="remove()" href="#">Home</a></li>
        <li><a onclick="remove()" href="#features_page">Features</a></li>
        <li><a onclick="remove()" href="#about_page">About</a></li>
        <li><a onclick="remove()" href="#contact_page">Contact</a></li>
      </ul>
    </nav>
      <!--Navbar for Mobile-->

    <div class="header">
      <div class="left">
          <img src="../images/singco-logo.svg" alt="" width="30px">
      </div>
      <div class="right">
        <ul>
          <li id="contact"><a href="#contact_page">Contact</a></li>
          <li id="about"><a href="#features_page">Features</a></li>
          <li id="about"><a href="#about_page">About</a></li>
          <li><button id="login">Login</button></li>
        </ul>
      </div>
      </div>
    <!-- End of Navbar -->

    <!-- BODY -->
    <div class="main">
      <h4>Welcome to</h4>
      <div class="singco_highlight">
        <h1 id="element" data-text="SINGCO"></h1>
      </div>
      <h4>A Software Interface for GWA Computation</h4>
    </div>

    <div class="main2" id="features_page">
      <!-- FEATURES -->
      <h2>How it Works</h2>
      <div class="mini_border"></div>
      <div class="card_container">
        <!-- CARD 1 -->
        <div class="card">
          <div class="card_1">
            <i data-feather="upload"></i>
            <h5>Input</h5>
            <p style="text-align:justify ">The input for this web application is either done automatically or manually. For automatic, the only valid input is a .txt file that contain the subjects, grades, completion/removal grades (if applicable), and the corresponding credits. It is generated by and from the Office of the University Registrar. For manual, the inputs are prepared in a dropdown button. To learn how to use the web application, please see the manual.</p>
          </div>
        </div>
        <!-- CARD 2 -->
        <div class="card" id="center_card">
          <div class="card_2">
            <i data-feather="loader"></i>
            <h5>Compute</h5>
            <p style="text-align:justify ">The web application is prepared mainly to calculate the General Weighted Average (GWA) of a requester. It follows the manual process of how GWA is computed by the Student Records Evaluator (SRE). </p>
          </div>
        </div>
        <!-- CARD 3 -->
        <div class="card">
          <div class="card_3">
            <i data-feather="printer"></i>
            <h5>Print</h5>
            <p style="text-align:justify ">A PDF Certificate is automatically generated. It contains the necessary details of the GWA Certificate requester. It includes primarily the person's basic information as well as the GWA. Moreover, a Latin Honor distinction is also included to the certificate whenever he/she qualifies.</p>
          </div>
        </div>
      </div>
      <h2>Benefits</h2>
      <div class="mini_border"></div>
    </div>

    <div class="main3">
      <div class="alternate">
        <img src="img/security.svg" alt="" width="100%" height="100%" class="svg">
      </div>
      <div class="alternate">
        <h5>Security</h5>
        <p style="text-align:justify ">The University is committed to comply with the Philippine Data Privacy Act of 2012 (DPA) in order to protect the right to data privacy of the University constituents. With this commitment, the web application prepared its own way to follow strictly the policies of the University. Therefore, a login function is applied to the application to minimize the users for only University Registar, System and Networks Office, College Secretaries and Student Evaluators who are eligible to use the GWA calculator application.</p>
      </div>
      <div class="alternate">
        <h5>Speed & Accuracy</h5>
        <p style="text-align:justify ">From the past years, GWA computation is done manually and human errors are committed. Therefore, this web application is created to solve this matter, or if not, to minimize computation errors as possible. Also, the application provides a faster processing of GWA Certificate which only takes several minutes to be accomplished as compared to the days of waiting before.</p>
      </div>
      <div class="alternate">
        <img src="img/speed.svg" alt="" width="100%" height="100%" class="svg">
      </div>
      <div class="alternate">
        <img src="img/flexibility.svg" alt="" width="100%" height="100%" class="svg">
      </div>
      <div class="alternate">
        <h5>Flexibility</h5>
        <p style="text-align:justify ">University of the Philippines Baguio's Academic Catalog had undergone some changes in the past years. This suggests that the application should also be able to adapt with the changes in the course list as well as the updated corresponding units. To keep it updated, the developers prepared an admin page which is eventually the key in achieving the flexibility of the application. In addition, the application could solve either the GWA or the Cumulative Weighted Grade Average (CWAG).</p>
      </div>
    </div>
    <div class="main2" id="about_page">
      <!-- ABOUT -->
      <h2>About</h2>
      <div class="mini_border"></div>
      <h6 style="text-align:justify ">Project SInGCo is a web application whose general purpose is to compute the GWA of requesters. Since GWA is manually computed before, in this application, computations are done automatically. Through this application, the previous GWA computation and releasing of certificates to the claimants which takes several days is done in just minutes. Two options are provided for the users. The first option is faster and easier. It only needs the .txt file of the True Copy of Grades (TCG) which is provided by the Office of the University Registrar (OUR). The file contains the student’s list of subjects taken, their corresponding units, and grade which are pulled directly from the OUR’s database. This file will be uploaded in the application and a preview of the certificate will be visible for the user. Afterwards, the user could download the pdf file of the certificate. However, for cases such as the unavailability of the txt files from the OUR, the second option solves the problem. From this option, instead of manual encoding of the grades, a drop-down menu is prepared for choosing the subjects and grades. Furthermore, special cases such as multiple takes of courses, readmissions, shifting of degree programs, and computation of additional subjects complicate the computation process. Therefore, the application aims to solve these hindrances creating a major impact in terms of ease, efficiency, and speed of computation. To learn more about using the application, please see the manual.
      </h6>
    </div>

      <!-- CONTACT SECTION-->
      <!-- Description: Contact Section is where the user can send a message to the Admin-->
    <div class="main2" id="contact_page">
      <h2>Contact Us</h2>
      <div class="mini_border"></div>
          <div class ="success"> <?php echo $success; ?> </div>
          <form method="post">
              <div class="email">
                   <input class="contact"type="text" name="name_contact" placeholder="Name" required>
                   <input class="contact" type="email" name="email_contact" placeholder="Email" required>
                  <textarea class="contact" name="message_contact" placeholder="Message" required></textarea>
                  <button type="submit" name="btn_contact" id="submit_email">Submit</button>
                </div>
          </form>
    </div>
    <!-- FOOTER -->
    <div class="margin_footer"></div>
    <div class="footer">
        <div id="policy">
          <a href="https://privacy.up.edu.ph/" target="_blank"><p> Privacy Policy </p></a>
        </div>
        <div id="copyright">
          <p> &#169; 2021 Domer | Lee | Lorezco | Roque. All Rights Reserved. </p>
        </div>
        <div class="socmed">
          <a href="../user-manual.pdf" target="_blank">User Manual</a>

        </div>
    </div>
    <!-- bootstrap JS -->
    <script src="login.js" charset="utf-8"></script>
    </body>

</html>
