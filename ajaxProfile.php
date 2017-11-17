<?php
require 'db.php';
require 'classes/Login.php';
require 'classes/Sanitize.php';

if(isset($_POST["action"]))
{

    if($_POST["action"] == "insert")
    {
        $user_id=Login::isLoggedIn($mysqli);
        $body=$_POST['body_post'];
        if($_FILES["image"]["tmp_name"]==null)
        {
            $mysqli->query("Insert into T_posts(body,user_id,post_date) values('$body',$user_id,now())");
            
        
        }
        else {
            // if(file_get_contents($_FILES["image"]["tmp_name"])!= strip_tags(file_get_contents($_FILES["image"]["tmp_name"]))){
            //     echo "ERROR";
            // }
            // else{
                if($_FILES["image"]["error"]===0){
                    if($_FILES["image"]["size"]<1000000){
                    $image = $mysqli->escape_string(file_get_contents($_FILES["image"]["tmp_name"]));
                    $mysqli->query("Insert into T_posts(image,body,user_id,post_date) values('$image','$body',$user_id,now())");
                    echo json_encode('data:image/jpeg;base64,'.base64_encode(file_get_contents($_FILES["image"]["tmp_name"])));
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
            $image = $mysqli->escape_string(file_get_contents($_FILES["profile_photo"]["tmp_name"]));


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
        $body=$mysqli->escape_string($_POST['body']);
        $post_id=$mysqli->escape_string($_POST['post_id']);
        if($post_id==-1){
            $result=$mysqli->query("select id from t_posts where user_id=$user_id order by id desc limit 1 ");
            $post=$result->fetch_assoc();
            $post_id=$post['id'];
        }
        $mysqli->query("insert into t_comments(body,user_id,post_id,comment_data) values ('$body',$user_id,$post_id,now())");
        $fullName=Login::getFistLastName($user_id,$mysqli);

        echo json_encode(['first_name'=>$fullName['first_name'],'last_name'=>$fullName['last_name']]);
    }


}

