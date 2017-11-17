<?php

$email=$mysqli->escape_string($_POST['email']);
$result=$mysqli->query("Select * from t_users where email='$email'");

if($result->num_rows>0){

    $user=$result->fetch_assoc();

    if(password_verify($_POST['password'],$user['password'])){
        // This is how we'll know the user is logged in
        $_SESSION['logged_in'] = true;
        $user_id=$user['id'];
        $cstrong=true;
        $token = bin2hex(openssl_random_pseudo_bytes(64,$cstrong));
        $hashed_token=sha1($token);
        $mysqli->query("INSERT INTO t_login_tokens(token,user_id) VALUES('$hashed_token',$user_id)");
        //NULL i fundit nese do e hedhesh live eshte per https: duhet TRUE dmth
        setcookie("SNID",$token,time()+60*60*24*7,'/',NULL,NULL,TRUE);
        setcookie("SNID_C",sha1(time()),time()+60*60*24*3,'/',NULL,NULL,TRUE);
        header("location: profile.php?user=$user_id");
    }
    else{
           Reporter::report_err("Wrong password!");
    }
}
else{
     Reporter::report_err("There is no user with this email adress! Please sign up before you log in!");
}