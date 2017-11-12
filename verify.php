<?php 
require 'db.php';
require 'classes/Reporter.php';

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']));
{
    $email=$mysqli->escape_string($_GET['email']);
    $hash=$mysqli->escape_string($_GET['hash']);

    $result=$mysqli->query("SELECT * FROM t_users where email='$email' and hash='$hash' and active='0'");

    if($result->num_rows>0){
        
         $mysqli->query("UPDATE t_users set active='1' WHERE email='$email'") or die($mysqli->error);

         Reporter::report_suc("Your account has been activated!");
    }else{
        Reporter::report_err("Account has already been activated or the URL is invalid!");
    }
}