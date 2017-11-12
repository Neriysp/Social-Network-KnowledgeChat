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
<body>
	<div class="wrapper">
	<nav class="navbar box">
		<div id="title-logo" style="font-size: 25px">Kchat</div>
		<input type="text" name="search-bar" placeholder="Search for anything..." id="search-bar">
		<button id="search-button"><span><i class="fa fa-search" aria-hidden="true"></i></span>
    </button>
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
    <div class="close_chat">
    <button class="hide_chat">
    <i class="fa fa-chevron-right" aria-hidden="true"></i></button>
    </div>    
	<!--Chat Sidebar-->
	<div class="sidebar box">

	</div>
	<!--Header_Group-->
	<div class="group_head box">
	<div class="profile-photo">
	<img class="profile_picture" src="photos/aa.jpg"
	height="100px" width="100px">
	</div>
	<p>Node JS Group</p>
	<div class="description">
	<p>Main field:Coding</p>
	<p>Group Description:<br>
	This is an advanced Node Js group,We COOL!</p>
	<div class="Group-popularity">
	<p><span>Popularity:<i class="fa fa-users" aria-hidden="true"></i></span>500 members are part of this group!
	</p>
	</div>
    </div> 
    <button class="group_members">View Members</button>
    <button class="group_settings"><i class="fa fa-cog" aria-hidden="true"></i> Settings</button>
	</div>
	<!--Main Event-->
	<div class="main_event box">
		<div class="live_event"> 
            <div class="create_post">
            <p><i class="fa fa-calendar" aria-hidden="true"></i>  Live event</p>
            </div>
            <p id="head_event"><h3>Task: Create a HTML 5 page using div-s!</h3></p>
            <p id="difficulty_event"><h4>Difficulty:Medium</h4></p>   
        <button class="mark_event_done">Mark as done</button>
        </div>
        <div class="next_event_vote">
            <div class="create_post">
            <p><i class="fa fa-plus" aria-hidden="true"></i>  Next event vote</p>
            </div>
        <button class="event_history">Event history</button>
        <button class="suggest_main_event">Suggest next event</button>
        </div>
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
    	<div class="input_comments">
			<div class="create_post">
			<p><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ask a question</p>
			</div>
			<p><textarea class="new_post" rows="4" placeholder="Write something..."></textarea></p>
			<button id="post_btn_comm"><a href="#">Post</a></button>
    	</div>
    	<div class="comments-container">
        <ul id="comments-list" class="comments-list">
            <li>
                <div class="comment-main-level">
                    <!-- Avatar -->
                    <!-- Contenedor del Comentario -->
                    <div class="comment-box">
                        <div class="comment-head">
                            <h6 class="comment-name by-author">Agustin Ortiz</a></h6>
                            <span>20 minutes ago</span>
                            <i class="fa fa-reply"></i>
                            <i class="fa fa-heart"></i>
                        </div>
                        <div class="comment-content">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                        </div>
                        <button class="show_more_comments"><span><i class="fa fa-level-down" aria-hidden="true"></i></span> Show replies</button>
                    </div>
                </div>
                <!-- Respuestas de los comentarios -->
                <ul class="comments-list reply-list" id="reply-list">
                    <li>
                        <!-- Contenedor del Comentario -->
                        <div class="comment-main-reply">
                        <div class="comment-box">
                            <div class="comment-head">
                                <h6 class="comment-name">Lorena Rojero</a></h6>
                                <span>10 minutes ago</span>
                                <i class="fa fa-reply"></i>
                                <i class="fa fa-heart"></i>
                            </div>
                            <div class="comment-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                            </div>
                            <button class="show_more_comments"><span><i class="fa fa-level-down" aria-hidden="true"></i></span> Show replies</button>
                        </div>
                       </div>
                    <ul class="comments-list reply-list" id="reply-list-nested">
                    <li>
                        <!-- Contenedor del Comentario -->
                        <div class="comment-box">
                            <div class="comment-head">
                                <h6 class="comment-name">Lorena Rojero</a></h6>
                                <span>10 minutes ago</span>
                                <i class="fa fa-reply"></i>
                                <i class="fa fa-heart"></i>
                            </div>
                            <div class="comment-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                            </div>
                        </div>
                    </li>

                    <li>
                        <!-- Contenedor del Comentario -->
                        <div class="comment-box">
                            <div class="comment-head">
                                <h6 class="comment-name by-author">Agustin Ortiz</a></h6>
                                <span>10 minutes ago</span>
                                <i class="fa fa-reply"></i>
                                <i class="fa fa-heart"></i>
                            </div>
                            <div class="comment-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                            </div>
                        </div>
                    </li>
                </ul>
              </li>
                    <li>
                        <!-- Contenedor del Comentario -->
                        <div class="comment-main-reply">
                        <div class="comment-box">
                            <div class="comment-head">
                                <h6 class="comment-name by-author">Agustin Ortiz</a></h6>
                                <span>10 minutes ago</span>
                                <i class="fa fa-reply"></i>
                                <i class="fa fa-heart"></i>
                            </div>
                            <div class="comment-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                            </div>
                            <button class="show_more_comments"><span><i class="fa fa-level-down" aria-hidden="true"></i></span> Show replies</button>
                        </div>
                    </div>
                    <ul class="comments-list reply-list" id="reply-list-nested">
                    <li>
                        <!-- Contenedor del Comentario -->
                        <div class="comment-box">
                            <div class="comment-head">
                                <h6 class="comment-name">Lorena Rojero</a></h6>
                                <span>10 minutes ago</span>
                                <i class="fa fa-reply"></i>
                                <i class="fa fa-heart"></i>
                            </div>
                            <div class="comment-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                            </div>
                        </div>
                    </li>

                    <li>
                        <!-- Contenedor del Comentario -->
                        <div class="comment-box">
                            <div class="comment-head">
                                <h6 class="comment-name by-author">Agustin Ortiz</a></h6>
                                <span>10 minutes ago</span>
                                <i class="fa fa-reply"></i>
                                <i class="fa fa-heart"></i>
                            </div>
                            <div class="comment-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                            </div>
                        </div>
                    </li>
                </ul>
                </ul>
            </li>
        </li>
            <li>
                <div class="comment-main-level">
                    <!-- Contenedor del Comentario -->
                    <div class="comment-box">
                        <div class="comment-head">
                            <h6 class="comment-name"></h6>
                            <span>10 minutes ago</span>
                            <i class="fa fa-reply"></i>
                            <i class="fa fa-heart"></i>
                        </div>
                        <div class="comment-content">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                        </div>
                        <button class="show_more_comments"><span><i class="fa fa-level-down" aria-hidden="true"></i></span> Show replies</button>
                    </div>
                </div>
                                <ul class="comments-list reply-list" id="reply-list">
                    <li>
                        <!-- Contenedor del Comentario -->
                        <div class="comment-main-reply">
                        <div class="comment-box">
                            <div class="comment-head">
                                <h6 class="comment-name">Lorena Rojero</a></h6>
                                <span>10 minutes ago</span>
                                <i class="fa fa-reply"></i>
                                <i class="fa fa-heart"></i>
                            </div>
                            <div class="comment-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                            </div>
                            <button class="show_more_comments"><span><i class="fa fa-level-down" aria-hidden="true"></i></span> Show replies</button>
                        </div>
                       </div>

                    <ul class="comments-list reply-list" id="reply-list-nested">
                    <li>
                        <!-- Contenedor del Comentario -->
                        <div class="comment-box">
                            <div class="comment-head">
                                <h6 class="comment-name">Lorena Rojero</a></h6>
                                <span>10 minutes ago</span>
                                <i class="fa fa-reply"></i>
                                <i class="fa fa-heart"></i>
                            </div>
                            <div class="comment-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                            </div>
                        </div>
                    </li>

                    <li>
                        <!-- Contenedor del Comentario -->
                        <div class="comment-box">
                            <div class="comment-head">
                                <h6 class="comment-name by-author">Agustin Ortiz</a></h6>
                                <span>10 minutes ago</span>
                                <i class="fa fa-reply"></i>
                                <i class="fa fa-heart"></i>
                            </div>
                            <div class="comment-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                            </div>
                        </div>
                    </li>
                </ul>
                </li>
                    <li>
                        <!-- Contenedor del Comentario -->
                        <div class="comment-main-reply">
                        <div class="comment-box">
                            <div class="comment-head">
                                <h6 class="comment-name by-author">Agustin Ortiz</a></h6>
                                <span>10 minutes ago</span>
                                <i class="fa fa-reply"></i>
                                <i class="fa fa-heart"></i>
                            </div>
                            <div class="comment-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                            </div>
                            <button class="show_more_comments"><span><i class="fa fa-level-down" aria-hidden="true"></i></span> Show replies</button>
                        </div>
                    </div>
                    <ul class="comments-list reply-list" id="reply-list-nested">
                    <li>
                        <!-- Contenedor del Comentario -->
                        <div class="comment-box">
                            <div class="comment-head">
                                <h6 class="comment-name">Lorena Rojero</a></h6>
                                <span>10 minutes ago</span>
                                <i class="fa fa-reply"></i>
                                <i class="fa fa-heart"></i>
                            </div>
                            <div class="comment-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                            </div>
                        </div>
                    </li>

                    <li>
                        <!-- Contenedor del Comentario -->
                        <div class="comment-box">
                            <div class="comment-head">
                                <h6 class="comment-name by-author">Agustin Ortiz</a></h6>
                                <span>10 minutes ago</span>
                                <i class="fa fa-reply"></i>
                                <i class="fa fa-heart"></i>
                            </div>
                            <div class="comment-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                            </div>
                        </div>
                    </li>
                </ul>
                </li>
                </ul>
            </li>
        </ul>
    </div>
    	</div>
    	<div id="posts">
    		<div class="posts box">
		<div class="card">
			<div class="create_post">
			<p><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Create a Group Post</p>
			</div>
			<p><textarea class="new_post" rows="4" placeholder="Post your creative work!"></textarea></p>
                    <span><i class="fa fa-lg fa-camera-retro" aria-hidden="true"></i></span>
                    <span><i class="fa fa-lg fa-youtube-play" aria-hidden="true"></i></span>
                    <span><i class="fa fa-code fa-lg" aria-hidden="true"></i></span>
			<button id="post_btn"><a href="#">Post</a></button>
		</div>
		<div class="Posted_posts">
	<div class="card">
  		<img src="download.gif" class="img-profile profile_picture">
  			<p class="who">
    		<a href="#" class="user">Ben Durra
  			</p>
  			<a href="#" class="time">9 hrs</a>
  			<p>Accidental Samoa and other clichés</p>
  			<img src="download.gif" class="img-primary">
  			<div class="footer">
   			 <div class="controls">
             <a href="#" class="like">
                <i class="fa fa-thumbs-up" style="margin-right: 5px;" aria-hidden="true"></i>Like</a>
             <a href="#" class="comment">
                <i class="fa fa-comment" style="margin-right: 5px;" aria-hidden="true"></i>Comment</a>
             <a href="#" class="share">
                <i class="fa fa-share-alt" style="margin-right: 5px;" aria-hidden="true"></i>Share</a>
            </div>
           <div class="new_comment">
              <div class="prof_img"><img src="download.gif" class="img-profile profile_picture"></div>
              <div class="input"><textarea class="new_comment_area" placeholder="Write a comment..."></textarea> </div>
            </div>
            <div class="comments_w">
              <div class="comment_child">
                <div class="prof_img"><img src="download.gif" class="img-profile profile_picture"></div>
                 <div class="output ">Ketu eshte kommenti i bishes!Ketu eshte kommenti i bishes!Ketu eshte kommenti i bishes!Ketu eshte kommenti i bishes!Ketu eshte kommenti i bishes!Ketu eshte kommenti i bishes!Ketu eshte kommenti i bishes!Ketu eshte kommenti i bishes!</div>
              </div>
              <div class="comment_child">
                <div class="prof_img"><img src="download.gif" class="img-profile profile_picture"></div>
                 <div class="output ">Ketu eshte kommenti i bishes!Ketu eshte kommenti i bishes!Ketu eshte kommenti i bishes!</div>
              </div>
              <div class="comment_child">
                <div class="prof_img"><img src="download.gif" class="img-profile profile_picture"></div>
                 <div class="output ">Ketu eshte kommenti i bishes!</div>
              </div>
            </div>
 		 </div>
	</div>
		</div>
		</div>
	<div class="right-sidebar box">
    <div class="right_sidebar_ads">

    </div>
	</div>
    </div>
    </div>
	</div>
</div>
</body>
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/group.js"></script>
</html>
