<?php


class Profile{

    public static function getPosts($profile_id,$mysqli){

      $posts=$mysqli->query("select * from t_posts join t_users on t_posts.user_id=t_users.id where user_id=$profile_id");
    
      $posts_html='';
      if($posts->num_rows>0){
      while($post=mysqli_fetch_array($posts)){

          $posts_html .= '<div class="card">'
          .($post['image']!=null ?
          '<img src="data:image/jpeg;base64,'.base64_encode($post['image'] ).'" class="img-profile profile_picture">':'').'
          <a href="#" class="user">'.ucfirst($post['first_name']).' '.ucfirst($post['last_name']).'</a>'
          .($post['group_name']!=null ?
          ' on <a href="#" class="friend">'.$post['group_name'].'</a> group.':'').'
          </p><a href="#" class="time">'.Profile::time_elapsed_string($post['post_date']).'</a>
          <p>'.$post['body'].'</p>'.($post['image']!=null ?'
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
        ';
        }
      }
      echo $posts_html;
    }



    public static function time_elapsed_string($datetime, $full = false) {
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