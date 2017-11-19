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
	<nav class="navbar box">
		<div id="title-logo" style="font-size: 25px">Kchat</div>
		<input type="text" name="search-bar" placeholder="Search" id="search-bar">
		<button id="search-button"><span><i class="fa fa-search" aria-hidden="true"></i></button>
		<div class="nav-buttons">
		<button id="home-button">Home</button>
		<button id="profile-button"><a href="profile.php?user=<?=$user_id?>">Profile</a></button>
		<div class="dropdown">
  		<button id="group-button">My Groups</button>
 		 <div class="dropdown-content">
   			 <a href="#">Link 1</a>
   			 <a href="#">Link 2</a>
   			 <a href="#">Link 3</a>
  			</div>
			</div>
		<button id="logOut-button"><a href="logout.php">Log Out</a></button>
		</div>
	</nav>

	<div class="sidebar box">
	<?php	$UserProfile->getUserData();?>
</div>
	<div class="posts box">
      <?php
        $UserProfile->getPosts();
      ?>
		</div>
	<div class="right-sidebar box">
       <?php
        $UserProfile->getRightSidebar();
      ?>
	</div>
    </div>
    <div class="popup" data-popup="popup-createGroup">
    <div class="popup-inner">
    <div class='create_new_group'><h2>Create New Group</h2></div><br>
    <div  class='popup_group_name'>
    <label>Name your group</label>
    <input type="text"  id="new_group_name" placeholder="Enter group name...">
    </div>
    <div  class='popup_group_description'>
    <label>Description of group</label>
    <input type="text"   id="new_group_description"  placeholder="Enter group description...">
    </div>
    <div  class='popup_group_topic'>
    <label>Topic</label>
    <input type="text"  id="new_group_topic"  placeholder="Enter group topic...">
    </div>
    <div  class='popup_group_add_members'>
    <label>Add some people</label>
    <input type="text"  id="new_add_members"  placeholder="Enter names...">
    </div>
    <div  class='popup_group_type'>
    <label>Choose group type</label>
    <input id="rad_open" type="radio" name="type_of_group"  value="open" checked="checked"> 
    <label for="rad_open" id="radio"><i class="fa fa-unlock-alt fa-2x" aria-hidden="true"></i>Open group <br> Anyone can join the group! </label>
    <input id="rad_closed" type="radio" name="type_of_group" value="closed" > 
    <label for="rad_closed" id="radio"><i class="fa fa-lock fa-2x" aria-hidden="true"></i>Closed group<br> Requires acceptance from admin to join! </label>
    </div>
    <div  class='popup_btn_create'>
      <button  id="create_new_group_btn"/>Create</button>
    </div>
        <a class="popup-close" data-popup-close="popup-createGroup" href="#">x</a>
    </div>
</div>
<div class="popup" data-popup="popup-joinGroup">
    <div class="popup-inner">
      <p><h2>Groups</h2></p><br>
  <p>Join any learning group you like:</p>
  <input type="text" id="searchPopup" onkeyup="FilerGrid()" placeholder="Search for names..">
  <br>
  <table border="1px" id="groupsTable" >
    <thead>
      <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Nr. of Members</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Html5</td>
        <td>Perfecting Skills of HTML5</td>
        <td>25</td>
      </tr>
      <tr>
        <td>CSS3</td>
        <td>Styling Modern Websites.</td>
        <td>50</td>
      </tr>
      <tr>
        <td>Javascript</td>
        <td>Client and Server side JS.</td>
        <td>100</td>
      </tr>
    </tbody>
  </table>

        <a class="popup-close" data-popup-close="popup-joinGroup" href="#">x</a>
    </div>
</div>
</body>
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/profile.js"></script>
</html>
