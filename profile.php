<?php
require 'db.php';
require_once 'classes/Login.php';
require_once 'classes/Reporter.php';

if(!$user_id=Login::isLoggedIn($mysqli)){
  //Rasti kur kerkon profilin nga url direkt pa bere login
  die("Not logged in!");
}

$result=$mysqli->query("SELECT * from t_users where id=$user_id");
if($result->num_rows>0){
  $user=$result->fetch_assoc();
  $active=$user['active'];
  $email=$user['email'];
  $firstName=$user['first_name'];
  $lastName=$user['last_name'];
}

if(isset($_GET['user']) && !empty($_GET['user'])){
  if($_GET['user'] != strip_tags($_GET['user'])){
    Reporter::report_err("Invalid inputs!");
  }
  else{
    $profile_id=$_GET['user'];
    if($profile_id==$user_id){
      $isOwnProfile=true;
    }
    else{
      $isOwnProfile=false;
    }
  }
}

if(!$active){
  include 'profileNactive.php';
}
else{
  include 'realProfile.php';
}
?>


