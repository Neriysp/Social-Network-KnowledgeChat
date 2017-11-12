<?php

class Reporter{

    public static function report_err($string){

        header("location:error.php?err=$string");
    }
    
    public static function report_suc($string){

        header("location:success.php?suc=$string");
    }
}