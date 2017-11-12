<?php

class Login{


 public static function isLoggedIn($mysqli){
  if(isset($_COOKIE['SNID']))
  {
    $hashed_token=sha1($_COOKIE['SNID']);
    $result=$mysqli->query("SELECT * from t_login_tokens where token='$hashed_token'");
    if($result->num_rows>0){
      $user=$result->fetch_assoc();
      $user_id=$user['user_id'];
      if(isset($_COOKIE['SNID_C'])){
      return $user_id;
      } else{
        $cstrong=true;
        $newToken = bin2hex(openssl_random_pseudo_bytes(64,$cstrong));
        $hashed_newToken=sha1($newToken);
        $mysqli->query("INSERT INTO t_login_tokens(token,user_id) VALUES('$hashed_newToken',$user_id)");
        $mysqli->query("DELETE FROM t_login_tokens where token='$hashed_token' and user_id=$user_id");
        setcookie("SNID",$newToken,time()+60*60*24*7,'/',NULL,NULL,TRUE);
        setcookie("SNID_C",sha1(time()),time()+60*60*24*3,'/',NULL,NULL,TRUE);
        return $user_id;
      }
    }
  }
  return false;
}


}