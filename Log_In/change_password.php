<?php
include "forgotEmail.php";
 ?>

<!--The UI for the Change Password page-->
<!--This php file consists the frontend of the forgot password page, 
where the user is able to type their email to notify the admin to change or
send the user’s password.-->

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>SINGCO</title>
      <link rel="icon" href="../images/singco-logo.svg" type="image/icon type">
    <link rel="stylesheet" href="css/change_password.css">
  </head>
  <body>
    <div id="email">
      <div class="email-content">
        <h5>Forgot your password?</h5>
        <div class ="success"> <?php echo $success ?> </div>
        <center>
          <form action="" class="form" method="post">
            <input type="email" class="input_email" name="forgot_email" placeholder="Enter Email Here" autocomplete="off" required>
            <button class="button_email" type="submit" name="button_forgot">Submit</button>
            <p>Please input your email. The OUR will soon send you your new password in your email. </p>
          </form>
        </center>
      </div>
    </div>
  </body>
</html>
