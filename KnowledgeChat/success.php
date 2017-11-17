<?php
require 'classes/Reporter.php';

if(isset($_GET['suc'])){
    // if($_GET['suc'] != strip_tags($_GET['suc'])){
    //     Reporter::report_err("ERROR!");
    // }
    // else
    $message=$_GET['suc'];
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Success</title>
  <?php include 'css/css.html'; ?>
</head>
<body>
<div class="form">
    <h1><?= 'Success'; ?></h1>
    <p>
    <?=$message?>
    </p>
    <a href="index.php"><button class="button button-block"/>Home</button></a>
</div>
</body>
</html>
