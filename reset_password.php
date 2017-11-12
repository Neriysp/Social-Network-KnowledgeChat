<?php
require 'db.php';
require_once 'classes/Reporter.php';

 if($_SERVER['REQUEST_METHOD']=='POST'){
     if(isset($_POST['newPassword']) && !empty($_POST['newPassword']) && isset($_POST['confirmpassword']) && !empty($_POST['confirmpassword'])
        && ($_POST['newPassword']==$_POST['confirmpassword'])){

         $newPassword=password_hash($_POST['newPassword'],PASSWORD_BCRYPT);

         $email = $mysqli->escape_string($_POST['email']);

          $sql = "UPDATE t_users SET password='$newPassword' WHERE email='$email'";
         if ( $mysqli->query($sql) ) {

            echo 'success.php?suc=Your password has been reset successfully!';
         //Reporter::report_suc("Your%20password%20has%20been%20reset%20successfully!");   
         
         }

     }
     else {
         echo 'error.php?err=Two passwords you entered don\'t match, try again!';
        // Reporter::report_err("Two passwords you entered don't match, try again!"); 
     }

 }