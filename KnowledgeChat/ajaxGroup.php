<?php
require 'db.php';
require 'classes/Login.php';
require 'classes/Sanitize.php';
require 'classes/Group.php';
require 'classes/Reporter.php';

if(isset($_POST["action"]))
{

    if($_POST["action"] == "insert" && isset($_POST["group"]) && (isset($_POST['body_post'])||$_FILES["image"]["tmp_name"]!=null))
    {
        
        $user_id=Login::isLoggedIn($mysqli);
        if(isset($_POST['body_post'])){
        $body=Sanitize::prepDb($_POST['body_post'],$mysqli);
        }else $body='';
        $group_name=Sanitize::prepDb($_POST["group"],$mysqli);
        $resultGroup= $mysqli->query("SELECT * from t_group_users where group_name='$group_name' and id_user=$user_id")or die($mysqli->error);
        if($resultGroup->num_rows>0){
        if($_FILES["image"]["tmp_name"]==null)
        {
           $result= $mysqli->query("SELECT f_insert_post_group('$body',$user_id,'$group_name') as last_inserted_post")or die($mysqli->error);
            
           if($result->num_rows>0){
                 $post_id=$result->fetch_assoc();
                    $last_post_id=$post_id['last_inserted_post'];
                          echo json_encode(['post_id'=>$last_post_id]);
             }else{
                 throw error;
             }
        
        }
        else {
            //TODO:PERMIRESIM PER KONTORLLIN E IMAZHIT MOS KA NDONJE SQL-INJECTION OSE ESHTE ME NJDONJE PROBLEM 
            // if(file_get_contents($_FILES["image"]["tmp_name"])!= strip_tags(file_get_contents($_FILES["image"]["tmp_name"]))){
            //     echo "ERROR";
            // }
            // else{
                if($_FILES["image"]["error"]===0){
                    if($_FILES["image"]["size"]<1000000){
                    $image = $mysqli->escape_string(file_get_contents($_FILES["image"]["tmp_name"]));
                    $result=$mysqli->query("SELECT f_insert_post_group_with_photo('$body',$user_id,'$image','$group_name') as last_inserted_post")or die($mysqli->error);
                        if($result->num_rows>0){
                        $post_id=$result->fetch_assoc();
                        $last_post_id=$post_id['last_inserted_post'];
                            echo json_encode(['post_id'=>$last_post_id,'imgsrc'=>'data:image/jpeg;base64,'.base64_encode(file_get_contents($_FILES["image"]["tmp_name"]))]);
                        }else{
                            throw error;
                            }
                    }else{
                        echo json_encode(['error'=>'Please pick a file with size smaller than 1 Mb!']);
                    }
                }else{
                    echo json_encode(['Error!']);
                }
                    
            //}
        }

    }else{
        echo json_encode(['error'=>'Incorrect Submition!']);
    }
}

    if($_POST["action"] == "change_prof_pic")
    {
        $user_id=Login::isLoggedIn($mysqli);
        
        if($_FILES["profile_photo"]["tmp_name"]!=null)
        {
            if($_FILES["profile_photo"]["error"]===0){
                    if($_FILES["profile_photo"]["size"]<1000000){
            $image = Sanitize::prepDb((file_get_contents($_FILES["profile_photo"]["tmp_name"])),$mysqli);


            $mysqli->query("Update t_users set prof_image ='$image' where id=$user_id");
            
            echo json_encode('data:image/jpeg;base64,'.base64_encode(file_get_contents($_FILES["profile_photo"]["tmp_name"])));
                    }else{
                        echo json_encode(['Please pick a file with size smaller than 1 Mb!']);
                    }
                }else{
                    echo json_encode(['Error!']);
                }
        }
   
    }

}

if(isset($_POST["functionName"])){

    if($_POST['functionName']=='newcomment' && isset($_POST['body']) && isset($_POST['post_id'])){

        $user_id=Login::isLoggedIn($mysqli);
        $body=Sanitize::prepDb($_POST['body'],$mysqli);
        $post_id=Sanitize::prepDb($_POST['post_id'],$mysqli);
        if($post_id==-1){
            $result=$mysqli->query("select id from t_posts where user_id=$user_id order by id desc limit 1 ");
            $post=$result->fetch_assoc();
            $post_id=$post['id'];
        }
       $result=$mysqli->query("select  * from t_group_posts
                        join t_group_users on t_group_users.group_name=t_group_posts.group_name
                        where t_group_posts.id_post=$post_id and t_group_users.id_user=$user_id");
        
        if($result->num_rows>0){
        $mysqli->query("insert into t_group_comments(body,user_id,group_post_id,comment_data) values ( '$body',$user_id,$post_id,now())");
        $fullName=Login::getFistLastName($user_id,$mysqli);
        echo json_encode(['first_name'=>$fullName['first_name'],'last_name'=>$fullName['last_name']]);
        }else{
             echo json_encode(['error'=>'Incorrect Submition!']);
        }
    }   
   
     if($_POST['functionName']=='reqToJoinGroup' && isset($_POST['group_name']) && !empty($_POST['group_name'])){
        
        $user_id=Login::isLoggedIn($mysqli);
        $group_name=Sanitize::prepDb($_POST['group_name'],$mysqli);


        $result=$mysqli->query("select f_insert_request_join_closed_group($user_id,'$group_name') as rows_inserted");


        if($result->num_rows>0){
            $out=$result->fetch_assoc();
            $out=$out['rows_inserted'];

            if($out==1){
                
                echo json_encode(['success'=>'Request Sent']);
            }
            else{
                echo json_encode(['error'=>'Request already sent!']);
            }
        }
        else{
            echo json_encode(['error'=>'ERROR!']);
        }

     }
     
     if($_POST['functionName']=='JoinOpenGroup' && isset($_POST['group_name']) && !empty($_POST['group_name'])){
       
        $user_id=Login::isLoggedIn($mysqli);
        $group_name=Sanitize::prepDb($_POST['group_name'],$mysqli);
            
        $mysqli->query("INSERT into t_group_users(id_user,group_name,join_date) values($user_id,'$group_name',now())") or die($mysqli->error);

        echo json_encode(['success'=>'User added successfully']);

     }

 if($_POST['functionName']=='AcceptReqClosedGroup' && isset($_POST['group_name']) && !empty($_POST['group_name'])
     && isset($_POST['user_id']) && !empty($_POST['user_id'])){
       
        $user_id=Login::isLoggedIn($mysqli);
        $group_name=Sanitize::prepDb($_POST['group_name'],$mysqli);
        $user_id=Sanitize::prepDb($_POST['user_id'],$mysqli);  
       if( $mysqli->query("DELETE from t_req_join_closed where user_id=$user_id and group_name='$group_name'") or die($mysqli->error)){  

        $mysqli->query("INSERT into t_group_users(id_user,group_name,join_date) values($user_id,'$group_name',now())") or die($mysqli->error);

       }
        echo json_encode(['success'=>'User added successfully']);

     }
     
     if($_POST['functionName']=='RejectReqClosedGroup' && isset($_POST['group_name']) && !empty($_POST['group_name'])
     && isset($_POST['user_id']) && !empty($_POST['user_id'])){
       
        $user_id=Login::isLoggedIn($mysqli);
        $group_name=Sanitize::prepDb($_POST['group_name'],$mysqli);
        $user_id=Sanitize::prepDb($_POST['user_id'],$mysqli);  
       if( $mysqli->query("DELETE from t_req_join_closed where user_id=$user_id and group_name='$group_name'") or die($mysqli->error)){  
        //FIXME:GATI PER KUR TE KRIJOHEN NOTIFICATIONS
        // $mysqli->query("INSERT into t_notifications(id_user,body,notification_date) values($user_id,'You were rejected from group'.'$group_name'
        // ,now())") or die($mysqli->error);
       }
        echo json_encode(['success'=>'User rejected successfully']);

     }
}
   //TODO:FIXME:PERMIRESIMI PER COMMENTET QE TE MARRESH ME AJAX
    // if($_POST['functionName']=='fetchMoreComments' && isset($_POST['post_id'])){
 
    //     $post_id=$mysqli->escape_string($_POST['post_id']);

    //     $comments=$mysqli->query( "select t_comments.id as comm_id,body,likes,nr_replies,first_name,last_name,prof_image,comment_data 
    //                                     from t_comments join t_users on t_comments.user_id=t_users.id
    //                                         where post_id= $post_id ORDER BY t_comments.id DESC
    //                                         ORDER BY t_comments.id DESC LIMIT 3, 18446744073709551615");
    //     $comments->fetch_assoc();
    //                                         if($comments->num_rows>0){
    //                                                    echo json_encode("Here");die();
    //                                         }else{
    //                                                    echo json_encode(" NOT Here");die();
    //                                         }
    //         $comments_html.='';

    //         while($comment=mysqli_fetch_array($comments)){
    //         $comments_html.='
    //           <div class="comment_child">
    //             <input type="hidden" name="post_id" class="" value="'.$comment['comm_id'].'" />
    //             <div class="prof_img"><img src="data:image/jpeg;base64,'.base64_encode($comment['prof_image']).'"
    //              class="img-profile profile_picture" style="width:35px;height:35px;margin-top:3px;">
    //              <a href="#" class="user">'.$comment['first_name'].' '.$comment['last_name'].'</a>
    //              </div>
    //              <div class="output">'.$comment['body'].'</div>
    //              <div class="comment_footer" style="margin-left:50px;">
    //              <a class="like" style="margin-right:5px; margin-bottom:-3px;">Like</a>
    //              <a class="comment" style="margin-right:3px; margin-bottom:-3px;">Reply</a>
    //              <a  class="time">'.Profile::time_elapsed_string($comment['comment_data']).'</a>
    //              </div>
    //           </div>';
    //      }

    //         echo json_encode($comments_html);
    // }