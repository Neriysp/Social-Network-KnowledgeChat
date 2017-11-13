<?php
require 'db.php';
require_once 'classes/Login.php';

if(!$user_id=Login::isLoggedIn($mysqli)){

  header("location:index.php");
}
else{

  if(isset($_POST['confirm'])){

    if(isset($_POST['alldevices'])){

    $mysqli->query("DELETE FROM t_login_tokens where user_id=$user_id");

    }
    else{
      if(isset($_COOKIE['SNID']))
     {
       $hashed_token=sha1($_COOKIE['SNID']);
       $mysqli->query("DELETE FROM t_login_tokens where token='$hashed_token' and user_id=$user_id");
     }

    }
         setcookie('SNID','',time()-3600,'/');
         setcookie('SNID_C','',time()-3600,'/');
         header("location:index.php");
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Logout</title>
</head>

<body>
  <h1>Logout of your Account?</h1>
  <p>Are you sure you'd like to logout?</p>
  
    <form action="logout.php" method="post">
    <input type="checkbox" name="alldevices" value="alldevices">
    Logout of all devices?<br>
    <input type="submit" name="confirm" value="Confirm">
    </form>
</body>
</html>
