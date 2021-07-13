<?php
    //Checking the Credentials inputted by the user
    /* This file is used to check the inputted data for logging in the application. It consists of function that will be used or triggered using the login button in the login.php. Also, it has conditions whether the user’s data do not match to any database, empty input boxes, and matches the username and password.
    */
    require  "../Database.php";
    $PDO = Database::letsconnect();
    
    if(!isset(  $_SESSION['UserID']))
         $_SESSION['UserID']  = "";
    if(!isset(  $_SESSION['Type']))
          $_SESSION['Type']  = "";
    if(!isset(  $_SESSION['UserName']))
         $_SESSION['UserName']  = "";

    $error= "";
   
    // For the Admin-type of user
    // Setting the localStorage to divhome for default displaying of div to home
    echo "<script>
    localStorage.setItem('divhome', true);
    if (!localStorage.getItem('divcourse'))
        localStorage.removeItem('divcourse');
    if (!localStorage.getItem('divuser'))
        localStorage.removeItem('divuser');
    </script>";

//Logging In Algorithm
if(isset($_POST['button_login'])) {
  $username = trim($_POST['uname']);
  $password = trim($_POST['psw']);
    try {
      $query = "select * from `users` where `username`=:username and `password`=:password";
      $stmt = $conn->prepare($query);
      $stmt->bindParam('username', $username, PDO::PARAM_STR);
      $stmt->bindValue('password', $password, PDO::PARAM_STR);
      $stmt->execute();
      $count = $stmt->rowCount();
      $row   = $stmt->fetch(PDO::FETCH_ASSOC);
      if($count == 1 && !empty($row)) {
            //Checking the inputted Credentials if it is in the Database
            foreach ($PDO->query("select * from users where username='".$username."' and password='".$password."'") as $row){
                $_SESSION['UserID']  = $row['user_id'];
                $type=$row['type'];
                $_SESSION['Type']=$row['type'];
                $_SESSION['UserName']  = $row['username'];
            }
          
          if ($type=="Admin")//Admin
              header("Location: ../Main/admin.php");
          else//User
              header("Location: ../Main/main.php");
      } else {
          //If the Username/Password is incorrect
        echo '<script>alert("Incorrect Username or Password");</script>';
      }
    } catch (PDOException $e) {
        echo "Error : ".$e->getMessage();
    }
}

?>

