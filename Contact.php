<?php

$success = "";
//For Contact Emails
// The Code for sending a Message email from a user to the admin
/*The Php file consists of php mailer functions use to email the admin about the user’s request or message. The php Mailer will be activated or called using the submit button, “btn_contact”. In the function,  username and password must consists the email and the password for the designated gmail that receives queries from the users. Also, provided the AddAddress, AddCC, Subject, and Body functions for more details required to complete the email. 
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
if(isset($_POST['btn_contact'])){
  $name=$_POST['name_contact']; 
  $message=$_POST['message_contact']; 
  $email=$_POST['email_contact']; 

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
    $mail->setFrom($email, 'Student Records Evaluator');  //OUR email + name to appear in email
    $mail->addAddress('singcofp@gmail.com');                //input OUR email here
    $mail->AddCC("ladomer@up.edu.ph","Lolibeth Domer");
    $mail->AddCC("klee2@up.edu.ph","Kianne Lee");
    $mail->AddCC("jflorezco@up.edu.ph","John Marco Florezco");
    $mail->AddCC("bcroque1@up.edu.ph","Benjamin Roque");
   
    $mail->addReplyTo($email, 'SRE');                     //here goes the SRE's email input

    //Content
    $mail->isHTML(true);                                    //Set email format to HTML
    $mail->Subject = '[CONTACT REQUEST] SINGCO Contact Request';    //subject
    $mail->Body    = $name.'<br>'.$email.'<br><br>'.$message;  //message

    $mail->send();
    $success .= "Message sent!";

  } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      exit;
  }
    
    
    
    
}
?>
