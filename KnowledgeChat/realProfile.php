<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Knowledge Chat</title>
    <link rel="stylesheet" type="text/css" href="css/global.css">
    <link rel="stylesheet" type="text/css" href="css/profile.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
	<div class="wrapper">
	<?=	$UserProfile->getNavbar($user_id,$mysqli);?>
	<div class="sidebar box">
	<?=$UserProfile->getUserData();?>
</div>
	<div class="posts box">
  <?= $UserProfile->getPosts();?>
		</div>
	<div class="right-sidebar box">
   <?= $UserProfile->getRightSidebar(); ?>
	</div>
    </div>
   <?= $UserProfile->getPopupCreateGroup();?>
</body>
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/global.js"></script>
    <script type="text/javascript" src="js/profile.js"></script>
</html>
