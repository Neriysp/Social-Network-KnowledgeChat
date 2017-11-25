<?php
require 'db.php';
require_once 'classes/Login.php';
require_once 'classes/Reporter.php';
require_once 'classes/Sanitize.php';
require 'classes/Group.php';
require 'classes/Global.php';

if(!$user_id=Login::isLoggedIn($mysqli)){
  //Rasti kur kerkon grupin nga url direkt pa bere login
  header("location:index.php");
}else{

if(isset($_GET['group']) && !empty($_GET['group'])){
 $group_name=Sanitize::prepDb($_GET['group'],$mysqli);

   $result=$mysqli->query("select * from t_users
                          left join t_group_users on t_users.id=t_group_users.id_user
                          where t_users.id=$user_id and t_group_users.group_name='$group_name'") or die($mysqli->error);
      if($result->num_rows>0){
        $user=$result->fetch_assoc();
        $firstName=$user['first_name'];
        $lastName=$user['last_name'];
        $profile_pic=$user['prof_image'];
        $isPartofGroup=($user['group_name']!=null ? "part":"notpart");
      } else {
          $firstName='';
          $lastName='';
          $profile_pic='';
          $isPartofGroup="notpart";
        }

        $result=$mysqli->query("SELECT * from t_groups where group_name='$group_name'");
        $group=$result->fetch_assoc();
      if(!($group['group_type']=="private" && $isPartofGroup=="notpart")){
        $group_type=$group['group_type'];
        $group_description=$group['group_description'];
        $group_topic=$group['group_topic'];
        $group_admin_id=$group['group_admin'];
        $group_image=$group['group_image'];
      
        if($group_type=="closed"){
          $result=$mysqli->query("select * from t_req_join_closed where user_id=$user_id and group_name='$group_name'") or die($mysqli->error);
          if($result->num_rows>0){
                 $firstName='';
                 $lastName='';
                 $profile_pic='';
                 $isPartofGroup="requested";
          }
        }
     if($group_admin_id==$user_id){
        $isGroupAdmin=true;
    }
    else{
      $isGroupAdmin=false;
    }
    $GroupPage= new Group($group_name,$mysqli,$group_description,$group_topic
    ,$group_type,$group_image,$isGroupAdmin,$isPartofGroup,$firstName,$lastName,$profile_pic);
    
     require 'realGroup.php';
    }
    else{
         Reporter::report_err("Group with this name might not exist or it might be private!");
    }
    
 }
else{
  header("location:profile.php?user=$user_id");
}
}


?>
