<?php
/* The password reset form, the link to this page is included
   from the forgot.php email message
*/
require 'db.php';
require_once 'classes/Reporter.php';

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']))
{
  if($_GET['email'] != strip_tags($_GET['email'])||$_GET['hash'] != strip_tags($_GET['hash'])){
      Reporter::report_err("Invalid inputs!");
  }else{
    $email=$mysqli->escape_string($_GET['email']);
    $hash=$mysqli->escape_string($_GET['hash']);

    $result=$mysqli->query("SELECT * FROM t_users where email='$email' and hash='$hash'");

    if($result->num_rows==0)
    {
       Reporter::report_err("You have entered invalid URL for password reset!");
    }
  }
}
  else{
    Reporter::report_err("Sorry, verification failed, try again!");
}
?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Reset Your Password</title>
  <?php include 'css/css.html'; ?>
</head>

<body>
    <div class="form">
          <h1 id='hPass'>Choose Your New Password</h1>
              
          <div class="field-wrap">
            <label id="lblNewPas">
              New Password<span class="req">*</span>
            </label>
            <input type="password"required name="newpassword" autocomplete="off"/>
          </div>
              
          <div class="field-wrap">
            <label>
              Confirm New Password<span class="req">*</span>
            </label>
            <input type="password"required name="confirmpassword" autocomplete="off"/>
          </div>
          
          <!-- This input field is needed, to get the email of the user -->
          <input type="hidden" name="email" value="<?= $email ?>">    
              
          <button id="resetbtn" class="button button-block"/>Apply</button>
    </div>
 <script src='js/jquery-3.2.1.min.js'></script>
 <script src="js/index.js"></script>

</body>
</html>