<?php
require 'Navbar.php';
class Group extends Navbar{

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
    private $resultRequest;
    private $eventHistory;
    private $nextEventResult;
    private $visitor_user_id;

     public function __construct($_name,$conn,$_description,$_topic,$_type,$_image,$_isGroupAdmin,$_isPartofGroup
     ,$_firstName,$_lastName,$_profile_pic,$_user_id){

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
        $this->visitor_user_id=$_user_id;
    }

     public function getGroupHeader(){

        $resultRequest=$this->mysqli->query("select * from t_req_join_closed
                              join t_users on t_req_join_closed.user_id=t_users.id 
                              where t_req_join_closed.group_name='$this->group_name'");
        $nextEventResult=$this->mysqli->query("SELECT * from t_next_event_suggestions
                                               join t_users on t_users.id=t_next_event_suggestions.user_id
                                               where t_next_event_suggestions.group_name='$this->group_name'");

        $this->resultRequest=$resultRequest;
        $this->nextEventResult=$nextEventResult;

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
            '<button data-popup-open="popup-joinGroupRequests" id="join_requests">'.
            ($resultRequest->num_rows>0?'<a id="nr_reqto_join">'.$resultRequest->num_rows.'</a>':'').'Join Requests</button> 
            <button id="group_settings"><i class="fa fa-cog" aria-hidden="true"></i> Settings</button><br><br>
            <button data-popup-open="popup-nextEventSuggestions" id="next_event_sug">'.
            ($nextEventResult->num_rows>0?'<a id="nr_reqto_join_sugg">'.$nextEventResult->num_rows.'</a>':'').'Next Event Suggestions</button>':
            '<button id="group_settings"><i class="fa fa-cog" aria-hidden="true"></i> Settings</button>') :
             '').
            ($this->isPartofGroup=="part" ? '':($this->isPartofGroup=="notpart" ? ($this->group_type=="open" ?
            '<button id="group_open_join" onclick="joinOpenGroup(event)">Join Group</button>'
            :($this->group_type=="closed" ?'<button onclick="RequestTojoinClosedGroup(event)" id="group_request_join">Request to join Group</button>':''))
            :'<button style="disabled = true;background-color:#dddddd;">Request sent</button>'));

            
        echo $header_html;
     }

     public function getPosts(){

        if((!($this->isPartofGroup=="part")) && $this->group_type=="closed"){
                echo '<p>Closed group, you have to join the group in order to see the posts!</p>';
        }else{
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
          <div class="footer">'.($this->isPartofGroup=="part" ?
            '<div class="controls">
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
            </div>':'').'
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
          <a href="#" class="user">'.ucfirst($post['first_name']).' '.ucfirst($post['last_name']).'</a>'
          //TODO:Kjo do te jete per eventin ne te cilin po e ben kete postim
          .($post['event_id']!=null ?
          ' on <a href="#" class="friend">'.$post['group_name'].'</a> group.':'').'
          <br><a  class="time">'.G::time_elapsed_string($post['post_date']).'</a>
          <p class="body">'.$post['body'].'</p>'.($post['image']!=null ?'
          <img src="data:image/jpeg;base64,'.base64_encode($post['image'] ).'" class="img-primary">':'').
          ' <div class="footer">'.
            ($this->isPartofGroup=="part" ?
            '<div class="controls">
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
            </div>':'').'
            <div class="comments_w">
            '.$comments_html.'
          </div>
    	</div>';
        }
      }
      echo $posts_html.'</div>';
    }
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
                    <a href="#" class="user">'.ucfirst($comment['first_name']).' '.ucfirst($comment['last_name']).'</a>
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

    public function popupRequestsToJoinGroup(){
       
        $popupHtml='<div class="popup" data-popup="popup-joinGroupRequests">
    <div class="popup-inner">
      <p><h2>Requests to join the group</h2></p><br>
	<div id="requested_users">';

         while($request=mysqli_fetch_array($this->resultRequest)){

           $popupHtml.='<div class="popup_tojoin_row">
                    <img src="data:image/jpeg;base64,'.base64_encode($request['prof_image']).'" class="prof_req_photo">  
                    <div id="name_requester">'.$request['first_name'].' '.$request['last_name'].'</div>
                    <div id="accept_reject_btn">
                    <button  onclick="acceptReq(event)">Accept</button>
                    <button  onclick="rejectReq(event)">Reject</button>  
                    <input type="hidden" name="user_id" id="user_id" value="'.$request['user_id'].'" />  
                    </div>
                 </div>';
            }
     $popupHtml.='</div>
                <a class="popup-close" data-popup-close="popup-joinGroupRequests">x</a>
            </div>
        </div>';
    
    echo $popupHtml;

    }
      public function getChatSidebar()
    {
       $result=$this->mysqli->query("SELECT * from t_group_users
                                    join t_users on t_group_users.id_user=t_users.id 
                                    where group_name='$this->group_name'");
        $sidebarHtml='<ul id="chatUl">';

       while($user=mysqli_fetch_array($result)){
            $sidebarHtml.=' <li><a href=profile.php?user='.$user['id_user']
            .'><img src="data:image/jpeg;base64,'.base64_encode($user['prof_image']).'" class="prof_req_photo_chat">'
            .ucfirst($user['first_name']).' '.ucfirst($user['last_name']).'</a></li>';
        }
        $sidebarHtml.='</ul>';


        echo $sidebarHtml;
    }

    public function getEvents(){
        $historyEventHtml='<ul class="event_history_data">';

        $eventHtml='<div class="live_event"> 
            <div class="create_post">
            <p><i class="fa fa-calendar" aria-hidden="true"></i>  Live event</p>
            </div>
            <div id="head_event">';

            $result=$this->mysqli->query("SELECT * from t_events
                                          join t_users on t_users.id=t_events.suggested_by
                                          where t_events.group_name='$this->group_name'");
        if($result->num_rows>0){
            while($event=mysqli_fetch_array($result)){
                if($event['state']=="inProgress"){
                    $eventHtml.='<b>Task:</b>'.$event['task'].'
            <div id="created_date" class="time">'.G::time_elapsed_string($event['event_date']).'</div></div>
            <div id="difficulty_event"><b>Difficulty:</b>
            <span style="background-color:'.($event['difficulty']=="medium"?'yellow':($event['difficulty']=="hard"?'red':'green')).'">
            '.ucfirst($event['difficulty']).'</span></div> 
            <div id="suggested_by"><a href="profile.php?user='.$event['suggested_by'].'">Suggested by:'.ucfirst($event['first_name'])
            .' '.ucfirst($event['last_name']).'</a></div>
            '.($this->isGroupAdmin?'<button onclick="markEventDone()" class="complete_event">Complete Event</button>':
                '<button  class="mark_event_done">Mark as done</button>').'</div>';
                }else{
                    $historyEventHtml.='
                    <li><div class="task"><b>Task: </b>'.$event['task'].'</div><div class="difficulty"><b>Difficulty:</b>
                    <span style="background-color:'.($event['difficulty']=="medium"?'yellow':($event['difficulty']=="hard"?'red':'green')).'">
                    '.ucfirst($event['difficulty']).'</span></div>
                    <div class="suggested_by"><a href="profile.php?user='.$event['suggested_by'].'">Suggested by:'.ucfirst($event['first_name'])
                     .' '.ucfirst($event['last_name']).'</a></div>
                    </li>';
                }
            }
        }else{
            $eventHtml.='
            <div id="created_date" class="time"></div></div>
            <div id="difficulty_event"></div> 
            <div id="suggested_by"></div>
            </div>';
        }
        $this->eventHistory=$historyEventHtml;

        $nextEventVoteHtml='
        <div class="next_event_vote">
            <div class="create_post">
            <p><i class="fa fa-plus" aria-hidden="true"></i>  Next event vote</p>
        </div>
         <ul class="next_event_suggestions_posted">';

        $result=$this->mysqli->query("SELECT * from t_next_event
                                      join t_users on t_users.id=t_next_event.user_id 
                                      where group_name='$this->group_name'");
         
        $res=$this->mysqli->query("SELECT * from t_new_event_vote where
                                   user_id=$this->visitor_user_id");


             $hashSet = array();
             while($votePerEvent=mysqli_fetch_array($res)){
                $hashSet[$votePerEvent['event_suggestion_id']]=$votePerEvent['vote'];
             }
         
        if($result->num_rows>0){
            while($nextEvent=mysqli_fetch_array($result)){
                $nextEventVoteHtml.='<li class="parent_sugg"><div class="task"><b>Task: </b>'.$nextEvent['task'].'</div><div class="difficulty"><b>Difficulty:</b>
                    <span style="background-color:'.($nextEvent['difficulty']=="medium"?'yellow':($nextEvent['difficulty']=="hard"?'red':'green')).'">
                    '.ucfirst($nextEvent['difficulty']).'</span></div>
                    <div id="suggestion_action_btn">
                    '.$this->getVoteForEvent($nextEvent['id_next_event'],$hashSet).'
                    <input type="hidden" name="id_next_event" id="id_next_event" value="'.$nextEvent['id_next_event'].'" />  
                     </div>
                    <div class="suggested_by_sug"><a href="profile.php?user='.$nextEvent['user_id'].'">Suggested by:'.ucfirst($nextEvent['first_name'])
                     .' '.ucfirst($nextEvent['last_name']).'</a></div>
                    </li>';
            }
        
        }

         $nextEventVoteHtml.='</ul><button class="event_history" data-popup-open="popup-eventHistory">Event history</button>
        <button class="suggest_main_event" data-popup-open="popup-suggestEvent">Suggest next event</button>
        </div>';
        echo $eventHtml.$nextEventVoteHtml;
    }

    public function getVoteForEvent($idEvent,$hashSet){
    
        $votingButtonHtml='
         <a  class="upVoteEvent" style="font-size: 30px;padding:10px;" onclick="upVote(event)"><i  class="fa fa-thumbs-up icon-large ThumbUp" aria-hidden="true"></i></a>
         <a  class="downVoteEvent" style="font-size: 30px;padding:10px;"  onclick="downVote(event)"><i  class="fa fa-thumbs-down icon-4x ThumbDown" aria-hidden="true"></i></a> 
         ';

            if(array_key_exists($idEvent,$hashSet)){
                if($hashSet[$idEvent]=='up'){
                    $votingButtonHtml='
                    <a  class="upVoteEvent" style="font-size: 30px;padding:10px;" onclick="upVote(event)"><i  class="fa fa-thumbs-up icon-large ThumbUp clicked" aria-hidden="true"></i></a>
                    <a  class="downVoteEvent" style="font-size: 30px;padding:10px;"  onclick="downVote(event)"><i  class="fa fa-thumbs-down icon-4x ThumbDown" aria-hidden="true"></i></a> 
                    ';
                }
                else{
                    $votingButtonHtml='
                    <a  class="upVoteEvent" style="font-size: 30px;padding:10px;" onclick="upVote(event)"><i  class="fa fa-thumbs-up icon-large ThumbUp" aria-hidden="true"></i></a>
                    <a  class="downVoteEvent" style="font-size: 30px;padding:10px;"  onclick="downVote(event)"><i  class="fa fa-thumbs-down icon-4x ThumbDown clicked" aria-hidden="true"></i></a> 
                    ';
                }

        }

        return $votingButtonHtml;
    }

    public function getPopupEventHistory(){

        $popupEventHistory='
        <div class="popup" data-popup="popup-eventHistory">
            <div class="popup-inner">
             <p><h2>Event History</h2></p><br>
                '.$this->eventHistory.'
                <a class="popup-close" data-popup-close="popup-eventHistory" href="#">x</a>
            </div>
        </div>';

        echo $popupEventHistory;
    }

    public function getPopupSuggestEvent(){
        $popupSuggestEventHtml='  <div class="popup" data-popup="popup-suggestEvent">
            <div class="popup-inner">
            <p><h2>Suggest Event</h2></p><br>
                <div class="container_suggestEvent">
                <textarea rows="3" placeholder="Type event task..." class="new_post" id="suggest_event_task"></textarea><br>
                <b><label>Choose group type</label></b><br>
                <label class="radlabel"><input id="rad" type="radio" name="type_of_event"  value="easy" checked="checked"> Easy</label><br>
                <label class="radlabel"><input id="rad" type="radio" name="type_of_event" value="medium"> Medium</label><br>
                <label class="radlabel"><input id="rad" type="radio" name="type_of_event" value="hard"> Hard</label><br>
                <button onclick="suggestEvent(event)" id="submit_suggested_event">Submit</button>
                </div>
                 <a class="popup-close" data-popup-close="popup-suggestEvent" href="#">x</a>
            </div>
    </div>';
    echo $popupSuggestEventHtml;        
    }

    public function getPopupNextEventSuggestions(){

        $nextEventSuggestionsHtml='
        <div class="popup" data-popup="popup-nextEventSuggestions">
            <div class="popup-inner">
            <p><h2>Next Event Suggestions</h2></p><br>
                <ul class="next_event_suggestions">';

            while($event=mysqli_fetch_array($this->nextEventResult)){
                 $nextEventSuggestionsHtml.='<li class="parent_sugg"><div class="task"><b>Task: </b>'.$event['task'].'</div><div class="difficulty"><b>Difficulty:</b>
                    <span style="background-color:'.($event['difficulty']=="medium"?'yellow':($event['difficulty']=="hard"?'red':'green')).'">
                    '.ucfirst($event['difficulty']).'</span></div>
                    <div id="suggestion_action_btn">
                     <button  onclick="acceptSug(event)">Accept</button>
                     <button  onclick="rejectSug(event)">Reject</button> 
                     <input type="hidden" name="event_suggestion_id" id="event_suggestion_id" value="'.$event['id_event_suggestion'].'" />  
                     </div>
                    <div class="suggested_by_sug"><a href="profile.php?user='.$event['user_id'].'">Suggested by:'.ucfirst($event['first_name'])
                     .' '.ucfirst($event['last_name']).'</a></div>
                    </li>';
            }

                $nextEventSuggestionsHtml.='</ul>
                <a class="popup-close" data-popup-close="popup-nextEventSuggestions" href="#">x</a>
            </div>
    </div>';

        echo  $nextEventSuggestionsHtml;
    }

}