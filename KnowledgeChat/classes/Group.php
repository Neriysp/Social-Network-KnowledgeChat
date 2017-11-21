<?php

class Group{

    private $group_name;
    private $mysqli;
    private $group_description;
    private $group_topic;
    private $group_type;
    private $isGroupAdmin;
    private $group_image;
    private $isPartofGroup;
    private $visitor_firstName;
    private $visitor_lastName;
    private $visitor_profile_pic;
 
     public function __construct($_name,$conn,$_description,$_topic,$_type,$_image,$_isGroupAdmin,$_isPartofGroup,$_firstName,$_lastName,$_profile_pic){

        $this->group_name=$_name;
        $this->mysqli=$conn;
        $this->group_description=$_description;
        $this->group_topic=$_topic;
        $this->group_type=$_type;
        $this->group_image=$_image;
        $this->isGroupAdmin=$_isGroupAdmin;
        $this->isPartofGroup=$_isPartofGroup;
        $this->visitor_firstName=ucfirst($_firstName);
        $this->visitor_lastName=ucfirst($_lastName);
        $this->visitor_profile_pic=$_profile_pic;
        
    }

     public function getGroupHeader(){

        $header_html=($this->group_image!=null ?
        '<div class="profile-photo">
            <img class="profile_picture" 
            src="data:image/jpeg;base64,'.base64_encode($this->group_image).'"
            height="100px" width="100px">
            </div>':'').'
            <p>'.$this->group_name.'</p>
            <div class="description">
            <p>Topic:'.$this->group_topic.'</p>
            <p>Group Description:<br>
            '.$this->group_description.'</p>
            <div class="Group-popularity">
            <p><span>Popularity:<i class="fa fa-users" aria-hidden="true"></i></span>500 members are part of this group!
            </p>
            </div>
            </div> 
            '.($this->isGroupAdmin ? ($this->group_type=="closed" ?
            '<button data-popup-open="popup-joinGroupRequests" id="join_requests"><a id="nr_reqto_join">X</a>Join Requests</button> 
            <button id="group_settings"><i class="fa fa-cog" aria-hidden="true"></i> Settings</button>':'') :
             '<button id="group_settings"><i class="fa fa-cog" aria-hidden="true"></i> Settings</button>').
            ($this->isPartofGroup=="part" ? '':($this->isPartofGroup=="notpart" ? ($this->group_type=="open" ?
            '<button id="group_open_join" onclick="joinOpenGroup(event)">Join Group</button>'
            :($this->group_type=="closed" ?'<button onclick="RequestTojoinClosedGroup(event)" id="group_request_join">Request to join Group</button>':''))
            :'<button style="disabled = true;background-color:#dddddd;">Request sent</button>'));

            
        echo $header_html;
     }

     public function getPosts(){

      $posts=$this->mysqli->query("select * from t_group_posts
                                   join t_users on t_users.id=t_group_posts.user_id 
                                   where t_group_posts.group_name='$this->group_name' ORDER BY t_group_posts.id_post DESC") or die($this->mysqli->error);
    
      $posts_html=($this->isPartofGroup=="part" ? '<div class="card" id="card_of_create_post">
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
                    <input type="hidden" name="group" id="group" value='.$this->group_name.' />
                    <span><i class="fa fa-lg fa-youtube-play" aria-hidden="true">
                    </i>
                    </span>
                    <span><i class="fa fa-code fa-lg" aria-hidden="true"></i></span>
			        <input type="submit" class="post_btn" name="insert" id="insert" value="Post"/>
      </form>
            </div>':'').'<div class="Posted_posts">'.'
            <div class="card" style="display:none;">'
          .($this->visitor_profile_pic!=null ?
          '<img src="data:image/jpeg;base64,'.base64_encode($this->visitor_profile_pic).'" id="main_pic" class="img-profile profile_picture">':'').'
          <a href="#" class="user">'.$this->visitor_firstName.' '.$this->visitor_lastName.'</a>
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
              <div class="prof_img"><img src="data:image/jpeg;base64,'.base64_encode($this->visitor_profile_pic).'
              " class="img-profile profile_picture" style="width:30px;height:30px;margin-top:3px;"></div>
              <div class="input"><textarea class="new_comment_area" onkeypress="newcomment(event)" placeholder="Write a comment..."></textarea>
              <input type="hidden" name="post_id" class="post_id_hidden" value="-1" /> </div>
            </div>
            <div class="comments_w">
               <div class="comment_child" style="display:none;">
                <input type="hidden" name="post_id" class="" value="-1" />
                <div class="prof_img"><img src="data:image/jpeg;base64,"
                 class="img-profile profile_picture" style="width:35px;height:35px;margin-top:3px;">
                 <a href="#" class="user"></a>
                 </div>
                 <div class="output"></div>
                 <div class="comment_footer" style="margin-left:50px;">
                 <a class="like" style="margin-right:5px; margin-bottom:-3px;">Like</a>
                 <a class="comment" style="margin-right:3px; margin-bottom:-3px;">Reply</a>
                 <a  class="time"></a>
                 </div>
              </div>
            </div>
          </div>
    	</div>';
      if($posts->num_rows>0){
      while($post=mysqli_fetch_array($posts)){
         $comments_html=$this->getComments($post['id_post']);
          $posts_html .='<div class="card">'
          .($post['prof_image']!=null ?
          '<img src="data:image/jpeg;base64,'.base64_encode($post['prof_image']).'" id="main_pic" class="img-profile profile_picture">':'').'
          <a href="#" class="user">'.$post['first_name'].' '.$post['last_name'].'</a>'
          //TODO:Kjo do te jete per eventin ne te cilin po e ben kete postim
          .($post['event_id']!=null ?
          ' on <a href="#" class="friend">'.$post['group_name'].'</a> group.':'').'
          <br><a  class="time">'.G::time_elapsed_string($post['post_date']).'</a>
          <p class="body">'.$post['body'].'</p>'.($post['image']!=null ?'
          <img src="data:image/jpeg;base64,'.base64_encode($post['image'] ).'" class="img-primary">':'').
          ' <div class="footer">
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
              <div class="input"><textarea class="new_comment_area" onkeypress="newcomment(event)" placeholder="Write a comment..."></textarea>
              <input type="hidden" name="post_id" class="post_id_hidden" value="'.$post['id_post'].'" /> </div>
            </div>
            <div class="comments_w">
            '.$comments_html.'
          </div>
    	</div>';
        }
      }
      echo $posts_html.'</div>';
    }

    public function getComments($post_id){
        $comments=$this->mysqli->query( "select t_group_comments.id_comment as comm_id,body,likes,nr_replies,first_name,last_name,prof_image,comment_data 
                                        from t_group_comments join t_users on t_group_comments.user_id=t_users.id
                                        where t_group_comments.group_post_id= $post_id ORDER BY t_group_comments.id_comment DESC");
      
        $comments_html='<div class="comment_child" style="display:none;">
                <input type="hidden" name="post_id" class="" value="-1" />
                <div class="prof_img"><img src="data:image/jpeg;base64,"
                 class="img-profile profile_picture" style="width:35px;height:35px;margin-top:3px;">
                 <a href="#" class="user"></a>
                 </div>
                 <div class="output"></div>
                 <div class="comment_footer" style="margin-left:50px;">
                 <a class="like" style="margin-right:5px; margin-bottom:-3px;">Like</a>
                 <a class="comment" style="margin-right:3px; margin-bottom:-3px;">Reply</a>
                 <a  class="time"></a>
                 </div>
              </div>';
        $nrOfShownComments=2;
    if($comments->num_rows>0){
        for($i=0;$i<$comments->num_rows;$i++){
            if($comment=mysqli_fetch_array($comments)){
                if($i<$nrOfShownComments){
                $comments_html.='
                <div class="comment_child">
                    <input type="hidden" name="post_id" class="" value="'.$comment['comm_id'].'" />
                    <div class="prof_img"><img src="data:image/jpeg;base64,'.base64_encode($comment['prof_image']).'"
                    class="img-profile profile_picture" style="width:35px;height:35px;margin-top:3px;">
                    <a href="#" class="user">'.$comment['first_name'].' '.$comment['last_name'].'</a>
                    </div>
                    <div class="output">'.$comment['body'].'</div>
                    <div class="comment_footer" style="margin-left:50px;">
                    <a class="like" style="margin-right:5px; margin-bottom:-3px;">Like</a>
                    <a class="comment" style="margin-right:3px; margin-bottom:-3px;">Reply</a>
                    <a  class="time">'.G::time_elapsed_string($comment['comment_data']).'</a>
                    </div>
                </div>';
                }else{
                    $comments_html.='
                        <div class="comment_child_hidden" style="display:none;">
                            <input type="hidden" name="post_id" class="" value="'.$comment['comm_id'].'" />
                            <div class="prof_img"><img src="data:image/jpeg;base64,'.base64_encode($comment['prof_image']).'"
                            class="img-profile profile_picture" style="width:35px;height:35px;margin-top:3px;">
                            <a href="#" class="user">'.$comment['first_name'].' '.$comment['last_name'].'</a>
                            </div>
                            <div class="output">'.$comment['body'].'</div>
                            <div class="comment_footer" style="margin-left:50px;">
                            <a class="like" style="margin-right:5px; margin-bottom:-3px;">Like</a>
                            <a class="comment" style="margin-right:3px; margin-bottom:-3px;">Reply</a>
                            <a  class="time">'.G::time_elapsed_string($comment['comment_data']).'</a>
                            </div>
                        </div>';
                }
            }
        }
        
        }
            $nrOfMoreComments=$comments->num_rows-$nrOfShownComments;
            return ($comments->num_rows<=3?$comments_html.'</div>':$comments_html.'
            </div>
            <a  class="view_more_comments" onclick="viewMoreComments(event)">View '.$nrOfMoreComments.' more comments</a>') ;
    }

}