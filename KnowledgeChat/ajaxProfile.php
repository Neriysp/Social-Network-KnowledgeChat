<?php
require 'db.php';
require 'classes/Login.php';
require 'classes/Sanitize.php';
require 'classes/Profile.php';
require 'classes/Reporter.php';

if(isset($_POST["action"]))
{

    if($_POST["action"] == "insert")
    {
        $user_id=Login::isLoggedIn($mysqli);
        $body=Sanitize::prepDb($_POST['body_post'],$mysqli);
        if($_FILES["image"]["tmp_name"]==null)
        {
           $result= $mysqli->query("SELECT f_insert_post('$body',$user_id) as last_inserted_post")or die($mysqli->error);
            
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
                    $image = Sanitize::prepDb((file_get_contents($_FILES["image"]["tmp_name"])),$mysqli);
                    $result=$mysqli->query("SELECT f_insert_post_with_photo('$body',$user_id,'$image') as last_inserted_post")or die($mysqli->error);
                        if($result->num_rows>0){
                        $post_id=$result->fetch_assoc();
                        $last_post_id=$post_id['last_inserted_post'];
                            echo json_encode(['post_id'=>$last_post_id,'imgsrc'=>'data:image/jpeg;base64,'.base64_encode(file_get_contents($_FILES["image"]["tmp_name"]))]);
                        }else{
                            throw error;
                            }
                    }else{
                        echo json_encode(['Please pick a file with size smaller than 1 Mb!']);
                    }
                }else{
                    echo json_encode(['Error!']);
                }
                    
            //}
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
        $mysqli->query("insert into t_comments(body,user_id,post_id,comment_data) values ('$body',$user_id,$post_id,now())");
        $fullName=Login::getFistLastName($user_id,$mysqli);

        echo json_encode(['first_name'=>$fullName['first_name'],'last_name'=>$fullName['last_name']]);
    }   
   
    if($_POST['functionName']=='create_new_group'){
        if(isset($_POST['name']) && isset($_POST['description'])
        && isset($_POST['topic']) && isset($_POST['typeOfGroup'])){
            $user_id=Login::isLoggedIn($mysqli);
            $group_name=Sanitize::prepDb($_POST['name'],$mysqli);
            $group_description=Sanitize::prepDb($_POST['description'],$mysqli);
            $group_topic=Sanitize::prepDb($_POST['topic'],$mysqli);
            $typeOfGroup=Sanitize::prepDb($_POST['typeOfGroup'],$mysqli);
            $defaultImgPath='c:/xampp/htdocs/KnowledgeChatPhp/new/KnowledgeChat/images/group.png';
            if(isset($_POST['addedMembers'])){
                $initial_members=Sanitize::prepDb($_POST['addedMembers'],$mysqli);
                $mysqli->query("insert into t_groups(group_name,group_description,group_topic,group_type,group_admin,group_image)
                                 values('$group_name','$group_description','$group_topic','$typeOfGroup',$user_id,LOAD_FILE('$defaultImgPath'))");
                echo json_encode(['location'=>"group.php?group=$group_name"]);
            }
        else{
            $mysqli->query("insert into t_groups(group_name,group_description,group_topic,group_type,group_admin,group_image)
                                 values('$group_name','$group_description','$group_topic','$typeOfGroup',$user_id,LOAD_FILE('$defaultImgPath'))");
                echo json_encode(['location'=>"group.php?group=$group_name"]);
        }
        }
        else{
            Reporter::report_err("Error while creating the group!");
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

}