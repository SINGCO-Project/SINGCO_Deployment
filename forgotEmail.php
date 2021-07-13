<?php

$success = "";
//For Forgot Password Emails
/*The Php file consists of php mailer functions use to email the admin to change the user’s password from the credential inputted. The php Mailer will be activated or called using the submit button, “button_forgot”. In the function,  username and password must consists the email and the password for the designated gmail that receives queries from the users. Also, provided the AddAddress, AddCC, Subject, and Body functions for more details required to complete the email. 
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

if(isset($_POST['button_forgot'])){
  $replyTo = $_POST['forgot_email'];                          //initialize email input of SRE

  try{

    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'singcofp@gmail.com';                   //SMTP temporary username (change if there's an official email for SMTP)
    $mail->Password   = '@S1ngc0FP';                            //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above


    //Recipients
    $mail->setFrom($replyTo, 'Student Records Evaluator');  //OUR email + name to appear in email
    $mail->addAddress('singcofp@gmail.com');                //input OUR email here
    $mail->addReplyTo($replyTo, 'SRE');                     //here goes the SRE's email input

    //Content
    $mail->isHTML(true);                                    //Set email format to HTML
    $mail->Subject = '[REQUEST] SINGCO Change Password';    //subject
    $mail->Body    = 'Hi! May I request for a new password. <br>Thank you!<br><br>'.$replyTo;  //message

    $mail->send();
    $success .= "Email sent!";

  } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      exit;
  }
}
?>
