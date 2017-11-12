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
		<input type="text" name="search-bar" placeholder="Search for anything..." id="search-bar">
		<button id="search-button"><span><i class="fa fa-search" aria-hidden="true"></i></button>
		<div class="nav-buttons">
		<button id="home-button">Home</button>
		<button id="profile-button">Profile</button>
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
		<div class="profile-photo">
			<img class="profile_picture" src="photos/aa.jpg"
			height="100px" width="100px">
		</div>
		<div class="description">
      <p>Skender Paturri</p>
			<p>Proffesion:Software Engeenier</p>
			<p>About me:<br>
			I am a code lover, i like to code!</p>
		</div>
    <div class="Actions">
  Actions:
    <p><button>Create a new Group</button></p>
    <br>
    <p>
      <button class="btn" data-popup-open="popup-1" href="#">Join Existing Groups</button>
    </p>
  </div>
  <div class="Created_groups">
      Created Groups:
    <ul>
      <li>
        <p><span><i class="fa fa-group" aria-hidden="true"></i></span>
        Node Js</p>
      </li>
      <li>
        <p><span><i class="fa fa-group" aria-hidden="true"></i></span>
        Angular Js</p>
      </li>
      <li>
        <p><span><i class="fa fa-group" aria-hidden="true"></i></span>
        React Js</p>
      </li>
    </ul>
  </div>
		<div class="Groups_in">
			Member of:
      <ul>
        <li>
          <p><span><i class="fa fa-group" aria-hidden="true"></i></span>
          Node Js</p>
        </li>
        <li>
          <p><span><i class="fa fa-group" aria-hidden="true"></i></span>
          Angular Js</p>
        </li>
        <li>
          <p><span><i class="fa fa-group" aria-hidden="true"></i></span>
          React Js</p>
        </li>
      </ul>
	</div>
</div>
	<div class="posts box">
		<div class="card">
			<div class="create_post">
			<p><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Create a Post</p>
			</div>
			<p><textarea class="new_post" rows="4" placeholder="What's on your mind?"></textarea></p>
                    <span><i class="fa fa-lg fa-camera-retro" aria-hidden="true"></i></span>
                    <span><i class="fa fa-lg fa-youtube-play" aria-hidden="true"></i></span>
                    <span><i class="fa fa-code fa-lg" aria-hidden="true"></i></span>
			<button id="post_btn"><a href="#">Post</a></button>
		</div>
		<div class="Posted_posts">
      <?php
        Profile::getPosts($profile_id,$mysqli);
      ?>
		</div>
		</div>
	<div class="right-sidebar box">
    <div class="right_sidebar_ads">

    </div>
    <div class="social no-bg">
    Connect on other platforms:<br>
  <a class="linkedin">
    <svg viewBox="0 0 800 800">
      <path d="M268 629h-97V319h97zm157 0h-97V319h93v42h1q31-50 93-50 114 0 114 133v185h-96V466q0-70-49-70-59 0-59 69z" />
      <circle cx="219" cy="220" r="56"/>
    </svg>
  </a>
  <a class="round github">
    <svg viewBox="0 0 800 800">
      <path d="M400 139c144 0 260 116 260 260 0 115-75 213-178 247-9 3-17-2-17-13v-71c0-35-18-48-18-48 57-6 119-28 119-128 0-44-27-70-27-70s14-29-2-69c0 0-22-7-72 27-42-12-88-12-130 0-50-34-72-27-72-27-16 40-2 69-2 69s-27 26-27 70c0 100 62 122 119 128 0 0-14 10-17 35-15 7-53 18-76-22 0 0-13-25-39-27 0 0-26 0-2 16 0 0 17 8 29 38 0 0 16 51 88 35v44c0 11-9 16-18 13-103-34-178-132-178-247 0-144 116-260 260-260z"/>
    </svg>
  </a>
  <a class="round codepen">
    <svg viewBox="0 0 800 800">
      <path d="M140 482V320q0-10 10-18l238-158q12-8 24 0l238 158q9 6 10 19v158q0 10-10 19L412 656q-12 8-24 0L150 497q-9-6-10-15zm282-278v104l97 65 78-52zm-44 104V204L203 321l78 52zm-193 54v75l56-37zm193 234V492l-97-65-78 52zm22-143l79-53-79-53-79 53zm22 143l175-117-78-52-97 64v105zm193-159v-75l-56 38z"/>
    </svg>
  </a>
</div>
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
