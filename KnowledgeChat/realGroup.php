<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Group Page</title>
    <link rel="stylesheet" type="text/css" href="css/global.css">
    <link rel="stylesheet" type="text/css" href="css/group.css">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body onscroll="chatScroll()">
	<div class="wrapper">
	<?= $GroupPage->getNavbar($user_id,$mysqli)?>
    <div class="close_chat">
    <button class="hide_chat">
    <i class="fa fa-chevron-right" aria-hidden="true"></i></button>
    </div>    
	<!--Chat Sidebar-->
	<div class="sidebar box">
    <?= $GroupPage->getChatSidebar()?>

	</div>
	<!--Header_Group-->
	<div class="group_head box">
    <?= $GroupPage->getGroupHeader()?> 
	</div>
	<!--Main Event-->
	<div class="main_event box">
		<?= $GroupPage->getEvents()?>
	</div>
    <div class="suggestions">
        Suggested groups or ads:
    </div>
	<!--Group Room-->
	<div class="group_rooms box">
	  <ul class="tab-group">
	  <li class="tab active" id="tab_posts"><a href="#posts">Posts</a></li>
      <li class="tab" id="tab_discussion"><a href="#discussion">Discussion</a></li>
    </ul>
    <div class="tab-content">
    	<div id="discussion">
    	</div>
    	<div id="posts">
    		<div class="posts box">
             <?= $GroupPage->getPosts()?>
		</div>
	<div class="right-sidebar box">
    <div class="right_sidebar_ads">
    </div>
	</div>
    </div>
    </div>
	</div>
</div>
  <?= $GroupPage->getPopupEventHistory()?>
</body>
<?=(($isGroupAdmin && $group_type=="closed")?$GroupPage->popupRequestsToJoinGroup():'');?>
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/global.js"></script>
    <script type="text/javascript" src="js/group.js"></script>
</html>
