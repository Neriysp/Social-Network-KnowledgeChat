<?php

class Navbar{

    public function getNavbar($user_id,$mysqli){
		//TODO:Per me rrit performancen duhet ti ruash ne chache qe te mos bohet thirrja ne db kot 

		$result=$mysqli->query("SELECT * from t_group_users where id_user=$user_id");
		$pending=$mysqli->query("SELECT * from t_req_join_closed where user_id=$user_id");
			
        $navBarHtml='<nav class="navbar box">
		<div id="title-logo" style="font-size: 25px">Kchat</div>
		<input type="text" name="search-bar" placeholder="Search" id="search-bar">
		<button id="search-button"><span><i class="fa fa-search" aria-hidden="true"></i></button>
		<div class="nav-buttons">
		<button id="home-button">Home</button>
		<button id="profile-button"><a href="profile.php?user='.$user_id.'">Profile</a></button>
		<button class="dropdown">My Groups
  		<div class="dropdown-content">
			   <div id="req_groups_btn" href="#">Requested Groups
			   <div id="req_groups_dropdown">';
		
	   while($groupPending=mysqli_fetch_array($pending)){
		   $navBarHtml.='<a href="group.php?group='.$groupPending['group_name'].'">'.$groupPending['group_name'].'</a>';
 		 	 	 
	   }
		   $navBarHtml.='</div></div><div id="joined_groups"></div>';

		  while($group=mysqli_fetch_array($result)){
		   $navBarHtml.='<a href="group.php?group='.$group['group_name'].'">'.$group['group_name'].'</a>';
 		 	 	 
	   } 
 		 $navBarHtml.='</div>
						</button>
							<button id="logOut-button"><a href="logout.php">Log Out</a></button>
						</div>
					</nav>';
    
    echo $navBarHtml;
    }
}