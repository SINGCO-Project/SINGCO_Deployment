<?php
//The Php file consists of php mailer functions use to email the user by the admin to let them know their password. The php Mailer will be activated or called using the submit button, “button_forgot”. In the function,  username. Also, provided the AddAddress, AddCC, Subject, and Body functions for more details required to complete the email. 
$success = "";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

//echo "<script>alert('hi');</script>";
$mail = new PHPMailer(true);
if(isset($_POST['send_password'])){
  $message=$_POST['message_password'];
  $email=$_POST['email_password'];

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
    $mail->setFrom('singcofp@gmail.com', 'Student Records Evaluator');  //OUR email + name to appear in email
    $mail->addAddress($email);                //input OUR email here

    $mail->addReplyTo('singcofp@gmail.com', 'Student Records Evaluator');                     //here goes the SRE's email input

    //Content
    $mail->isHTML(true);                                    //Set email format to HTML
    $mail->Subject = '[CHANGE PASSWORD] SINGCO Change Password Request';    //subject
    $mail->Body    = $message;  //message

    $mail->send();
    $date = new DateTime('now', new DateTimeZone('Asia/Manila'));
    array_push($_SESSION['Activities'],"".$date->format('h:i a')."<li class='activities'>You sent ".$email."'s new password.");
    $success .= "Message sent!";

  } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      exit;
  }
}
?>
