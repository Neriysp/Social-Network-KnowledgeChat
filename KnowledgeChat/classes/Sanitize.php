<?php

class Sanitize{
 
 
    public static function e($string){
        return htmlspecialchars($string,ENT_QUOTES,'UTF-8');
}

    public static function prepDb($string,$mysqli){
    
      return  $mysqli->escape_string(Sanitize::e($string));

    }

}