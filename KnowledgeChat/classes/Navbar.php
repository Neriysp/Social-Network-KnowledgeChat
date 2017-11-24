<?php

class Navbar{

    public function getNavbar($user_id){

        $navBarHtml='<nav class="navbar box">
		<div id="title-logo" style="font-size: 25px">Kchat</div>
		<input type="text" name="search-bar" placeholder="Search" id="search-bar">
		<button id="search-button"><span><i class="fa fa-search" aria-hidden="true"></i></button>
		<div class="nav-buttons">
		<button id="home-button">Home</button>
		<button id="profile-button"><a href="profile.php?user='.$user_id.'">Profile</a></button>
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
    </nav>';
    

    echo $navBarHtml;
    }
}