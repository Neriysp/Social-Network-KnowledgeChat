<?php

class Sanitize{
 
 
    public static function e($string){
         htmlspecialchars($string,ENT_QUOTES,'UTF-8');
}

    public static function prepDb($string,$mysqli){
    
      return  $mysqli->escape_string($this->e($string));

    }

}