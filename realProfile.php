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
<div class="popup" data-popup="popup-1">
    <div class="popup-inner">
       <h2>Groups</h2>
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
    <tbody id="myTable">
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

        <p><a data-popup-close="popup-1" href="#">Close</a></p>
        <a class="popup-close" data-popup-close="popup-1" href="#">x</a>
    </div>
</div>
</body>
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/profile.js"></script>
</html>
