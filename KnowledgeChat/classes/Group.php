<?php

class Group{

    private $group_name;
    private $mysqli;
    private $group_description;
    private $group_topic;
    private $group_type;
    private $isGroupAdmin;
    private $group_image;

     public function __construct($_name,$conn,$_description,$_topic,$_type,$_image,$_isGroupAdmin){

        $this->group_name=ucfirst($_name);
        $this->mysqli=$conn;
        $this->group_description=$_description;
        $this->group_topic=$_topic;
        $this->group_type=$_type;
        $this->group_image=$_image;
        $this->isGroupAdmin=$_isGroupAdmin;
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
            <button class="group_members">View Members</button>
            <button class="group_settings"><i class="fa fa-cog" aria-hidden="true"></i> Settings</button>';

        echo $header_html;
     }

     public function getPosts(){

        
     }
}