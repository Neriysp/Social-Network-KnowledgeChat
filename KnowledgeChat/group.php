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

   $result=$mysqli->query("select * from t_users
                          left join t_group_user on t_users.id=t_group_user.id_user
                          where t_users.id=$user_id");
      if($result->num_rows>0){
        $user=$result->fetch_assoc();
        $firstName=$user['first_name'];
        $lastName=$user['last_name'];
        $profile_pic=$user['prof_image'];
        $isPartofGroup=($user['group_name']!=null?true:false);
      }
    $group_name=Sanitize::prepDb($_GET['group'],$mysqli);
    $result=$mysqli->query("SELECT * from t_groups where group_name='$group_name'");
    if($result->num_rows>0){
        $group=$result->fetch_assoc();
        $group_description=$group['group_description'];
        $group_topic=$group['group_topic'];
        $group_type=$group['group_type'];
        $group_admin_id=$group['group_admin'];
        $group_image=$group['group_image'];

     if($group_admin_id==$user_id){
        $isGroupAdmin=true;
    }
    else{
      $isGroupAdmin=false;
    }
    $GroupPage= new Group($group_name,$mysqli,$group_description,$group_topic,$group_type,$group_image,$isGroupAdmin,$isPartofGroup);
    
     require 'realGroup.php';
    }
    else{
         Reporter::report_err("Group with this name might not exist!");
    }
    
 }
else{
  header("location:profile.php?user=$user_id");
}
}


?>
