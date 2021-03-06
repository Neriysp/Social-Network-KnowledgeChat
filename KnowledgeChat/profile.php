<?php
require 'db.php';
require_once 'classes/Login.php';
require_once 'classes/Reporter.php';
require 'classes/Profile.php';
require 'classes/Global.php';

if(!$user_id=Login::isLoggedIn($mysqli)){
  //Rasti kur kerkon profilin nga url direkt pa bere login
  header("location:index.php");
}else{

if(isset($_GET['user']) && !empty($_GET['user'])){
  if($_GET['user'] != strip_tags($_GET['user'])){
    Reporter::report_err("Invalid inputs!");
  }
  else{
    $result=$mysqli->query("SELECT * from t_users where id=$user_id");
      if($result->num_rows>0){
        $user=$result->fetch_assoc();
        $active=$user['active'];
        $email=$user['email'];
        $firstName=$user['first_name'];
        $lastName=$user['last_name'];
        $profile_pic=$user['prof_image'];
      }

    $profile_id=$_GET['user'];
    if($profile_id==$user_id){
      $isOwnProfile=true;
    }
    else{
      $isOwnProfile=false;
    }
    $UserProfile= new Profile($profile_id,$mysqli,$isOwnProfile,$profile_pic);

    if(!$active){
      include 'profileNactive.php';
    }
    else{
     include 'realProfile.php';
    }
 }
}
else{
  header("location:profile.php?user=$user_id");

}
}

?>


