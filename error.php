<?php
if(isset($_GET['err'])){
    if($_GET['err'] != strip_tags($_GET['err'])){
        
        $message="ERROR!";
    }
    else
    $message=$_GET['err'];
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Error</title>
  <?php include 'css/css.html'; ?>
</head>
<body>
<div class="form">
    <h1>Error</h1>
    <p>
    <?=$message
    ?>
    </p>     
    <a href="index.php"><button class="button button-block"/>Home</button></a>
</div>
</body>
</html>
