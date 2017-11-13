<?php


class Profile{

    private $profile_id;
    private $mysqli;
    private $first_name;
    private $last_name;
    private $prof_image;
    private $isOwnProfile;
    private $visitor_profile_pic;

    public function __construct($_profile_id,$conn,$isOwnProfile,$profile_pic){

        $this->profile_id=$_profile_id;
        $this->mysqli=$conn;
        $this->isOwnProfile=$isOwnProfile;
        $this->visitor_profile_pic=$profile_pic;
    }

    public function getUserData(){

         $result=$this->mysqli->query("select * from t_users where id=$this->profile_id");

         if($result->num_rows==0){
             Reporter::report_err("This page isn't available.The link you followed may be broken, or the page may have been removed.");
         }else{
         $user=$result->fetch_assoc();
         
         $this->first_name=ucfirst($user['first_name']);
         $this->last_name=ucfirst($user['last_name']);
         $this->prof_image=$user['prof_image'];


         $sidebar_html=($this->prof_image!=null ?
                    '<div class="profile-photo">
                    <img src="data:image/jpeg;base64,'.base64_encode($this->prof_image).'" height="100px" width="100px" id="prof_pic">			
                    </div>':'').'
                    <div class="description">
                <p>'.$this->first_name.' '.$this->last_name.'</p>
                        <p>Proffesion:Software Engeenier</p>
                        <p>About me:<br>
                        I am a code lover, i like to code!</p>
                    </div>'.($this->isOwnProfile ? 
                    '<div class="Actions">
                            Actions:
                            <p>
                            <form id="profile_pic_form" method="post" enctype="multipart/form-data">
                             <label for="profile_photo" class="btn">
                             <span id="upload_new_photo" style="margin-bottom:7px;margin-top:7px;">
                             Update profile picture</span></i>
                             </label>
                            <input type="file" style="display:none;" name="profile_photo" id="profile_photo" /> 
                            <input type="hidden" name="action" id="action" value="change_prof_pic" />
                           <!-- <input type="submit"  class="post_btn" name="insert" id="change_prof_pic" value="Post"/>-->
                            </form>
                        </p>
                                <p><button>Create a new Group</button></p>
                                <br>
                                <p>
                                <button class="btn" data-popup-open="popup-1" href="#">Join Existing Groups</button>
                                </p>
                            </div>':'').'
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
            ';
        echo $sidebar_html;
         }
    }

    public function getPosts(){

      $posts=$this->mysqli->query("select * from t_posts where user_id=$this->profile_id ORDER BY id DESC");
    
      $posts_html=($this->isOwnProfile ? '<div class="card" id="card_of_create_post">
			<div class="create_post">
			<p><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Create a Post</p>
			</div>
			<form id="new_post_form" method="post" enctype="multipart/form-data">
			<p><textarea name="body_post" class="new_post" rows="4" placeholder="What\'s on your mind?"></textarea></p>
                    <span>
                      <label for="image" class="btn"><i class="fa fa-lg fa-camera-retro" aria-hidden="true"></i>
                    </label>
                      <input type="file" style="display:none;" name="image" id="image" />
                    </span>
                    <input type="hidden" name="action" id="action" value="insert" />
                    <span><i class="fa fa-lg fa-youtube-play" aria-hidden="true">
                    </i>
                    </span>
                    <span><i class="fa fa-code fa-lg" aria-hidden="true"></i></span>
			        <input type="submit" class="post_btn" name="insert" id="insert" value="Post"/>
      </form>
            </div>':'').'<div class="Posted_posts">'.'
            <div class="card" style="display:none;">'
          .($this->prof_image!=null ?
          '<img src="data:image/jpeg;base64,'.base64_encode($this->prof_image).'" id="main_pic" class="img-profile profile_picture">':'').'
          <a href="#" class="user">'.$this->first_name.' '.$this->last_name.'</a>
          <br><a  class="time"></a>
          <p class="body"></p>
          <img src="" class="img-primary">
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
              <div class="prof_img"><img src="" class="img-profile profile_picture"></div>
              <div class="input"><textarea class="new_comment_area" placeholder="Write a comment..."></textarea> </div>
            </div>
            <div class="comments_w">
              <div class="comment_child">
                <div class="prof_img"><img src="" class="img-profile profile_picture"></div>
                 <div class="output ">Ketu eshte nje sample comment!</div>
              </div>
            </div>
          </div>
    	</div>';
      if($posts->num_rows>0){
      while($post=mysqli_fetch_array($posts)){

          $posts_html .='<div class="card">'
          .($this->prof_image!=null ?
          '<img src="data:image/jpeg;base64,'.base64_encode($this->prof_image).'" id="main_pic" class="img-profile profile_picture">':'').'
          <a href="#" class="user">'.$this->first_name.' '.$this->last_name.'</a>'
          .($post['group_name']!=null ?
          ' on <a href="#" class="friend">'.$post['group_name'].'</a> group.':'').'
          <br><a  class="time">'.$this->time_elapsed_string($post['post_date']).'</a>
          <p class="body">'.$post['body'].'</p>'.($post['image']!=null ?'
          <img src="data:image/jpeg;base64,'.base64_encode($post['image'] ).'" class="img-primary">':'').'
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
              <div class="prof_img"><img src="data:image/jpeg;base64,'.base64_encode($this->visitor_profile_pic).'"
              class="img-profile profile_picture" style="width:30px;height:30px;margin-top:3px;"></div>
              <div class="input"><textarea class="new_comment_area" placeholder="Write a comment..."></textarea> </div>
            </div>
            <div class="comments_w">
              <div class="comment_child">
                <div class="prof_img"><img src="" class="img-profile profile_picture"></div>
                 <div class="output ">Ketu eshte nje sample comment!</div>
              </div>
            </div>
          </div>
    	</div>';
        }
      }
      echo $posts_html.'</div>';
    }

    public function getRightSidebar(){
        $rightSidebar_html=($this->isOwnProfile ? '':'<div class="right_sidebar_ads">

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
            </div>');
        
            echo $rightSidebar_html;
    }



    public function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
}