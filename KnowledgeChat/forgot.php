<?php 
/* Reset your password form, sends reset.php password link */
require 'db.php';
require 'init.php';
require_once 'classes/Reporter.php';

if($_SERVER['REQUEST_METHOD']=='POST')
{
  if($_POST['email'] != strip_tags($_POST['email'])){
     Reporter::report_err("Invalid inputs!");
  }else{
  $email = $mysqli->escape_string($_POST['email']);

  $result=$mysqli->query("SELECT * from t_users where email='$email'");

  if($result->num_rows>0){

    $user=$result->fetch_assoc();

    $email=$user['email'];
    $hash=$user['hash'];
    $firstName=$user['first_name'];
    $to=$email;
    $subject='Password Reset Link (  knowledgeChat.com )';
    $message_body="
    Hello $first_name,

    You have requested password reset!

    Please click this link to reset your password:

    ".ASSET_ROOT."/reset.php?email=$email&hash=$hash";

    mail($to, $subject, $message_body);

   Reporter::report_suc("Please check your email $email  for a confirmation link to complete your password reset!");

  }else{
    Reporter::report_err("User with that email doesn't exist!");
  }
}
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Reset Your Password</title>
  <?php include 'css/css.html'; ?>
</head>
<body>
    
  <div class="form">

    <h1>Reset Your Password</h1>

    <form action="forgot.php" method="post">
     <div class="field-wrap">
      <label>
        Email Address<span class="req">*</span>
      </label>
      <input type="email"required autocomplete="off" name="email"/>
    </div>
    <button class="button button-block"/>Reset</button>
    </form>
  </div>
          
 <script src='js/jquery-3.2.1.min.js'></script>
 <script src="js/index.js"></script>
</body>

</html>
