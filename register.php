<?php
require 'init.php';

if($_POST['firstname'] != strip_tags($_POST['firstname'])||$_POST['lastname'] != strip_tags($_POST['lastname'])||
$_POST['password'] != strip_tags($_POST['password'])||$_POST['email'] != strip_tags($_POST['email'])){
 Reporter::report_err("Invalid inputs!");
}else{

$firstName=$mysqli->escape_string($_POST['firstname']);
$lastName=$mysqli->escape_string($_POST['lastname']);
$email=$mysqli->escape_string($_POST['email']);
$password=$mysqli->escape_string(password_hash($_POST['password'],PASSWORD_BCRYPT));
$hash= $mysqli->escape_string(md5(rand(0,1000)));


$result=$mysqli->query("SELECT * from t_users where email='$email'");

if($result->num_rows>0){
  Reporter::report_err("User with this email already exists!");
}
else{
  $defaultImgPath='c:/xampp/htdocs/KnowledgeChatPhp/new/images/avatar.jpeg';
  $sql = "INSERT INTO t_users(first_name,last_name,email,password,hash,prof_image)
  VALUES('$firstName','$lastName','$email','$password','$hash',LOAD_FILE('$defaultImgPath'))";

  if($mysqli->query($sql))
  {
    $to=$email;
    $subject='Account Verification ( knowledgeChat.com )';
    $message_body="
    Hello $firstName,

    Thank you for signing up!

    Please click this link to activate your account:

    ".ASSET_ROOT."/verify.php?email=$email&hash=$hash";  

    mail($to,$subject,$message_body);

    header("location:index.php");
  }
  else{
    Reporter::report_err("Registration failed!");
  }
}
}

