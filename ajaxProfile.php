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
            
            echo json_encode($body);
        }
        else {
            // if(file_get_contents($_FILES["image"]["tmp_name"])!= strip_tags(file_get_contents($_FILES["image"]["tmp_name"]))){
            //     echo "ERROR";
            // }
            // else{
                    $image = $mysqli->escape_string(file_get_contents($_FILES["image"]["tmp_name"]));
                    $mysqli->query("Insert into T_posts(image,body,user_id,post_date) values('$image','$body',$user_id,now())");
                    echo json_encode([$body,'data:image/jpeg;base64,'.base64_encode(file_get_contents($_FILES["image"]["tmp_name"]))]);
            //}
        }

    }



}