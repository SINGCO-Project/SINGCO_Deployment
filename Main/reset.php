<!-- Temporary page for reseting user session and deleting all courses that the user
added from the database -->

<?php
session_start();
$_SESSION['GWA']=0;
    require  "../Database.php";
    $PDO = Database::letsconnect(); 
    $PDO->query("DELETE FROM grades where user_id='".$_SESSION['UserID']."'");
    $PDO->query("UPDATE checklist SET state = NULL");
header("location:main.php");
?>