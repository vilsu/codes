<?php

// Check for the existing Cookie
// TODO muuta $_COOKIE to $_SESSION such that cookies are stored to Server

if (isset($_COOKIE['login']) ) {
    //1. read the first word in Cookie of the form 
        //"email@gmail.com,ca05106e445c15197f7213bc12648524
    //Then, store this word to $email 
    $cookie_tripped = explode(",", $_COOKIE['login']);   
    $email = $cookie_tripped[0];
    $result = pg_prepare($dbconn, "query1", 'SELECT passhash_md5 FROM users 
                         WHERE email = $1;');
    $result = pg_execute($dbconn, "query1", array($email));
    if(!$result) {
        exit;
    }

    // to take the passhash out of the cookie
    $passhash_md5_cookie = $cookie_tripped[1];
    if($result == $passhash_md5_cookie) {
        $result = pg_prepare($dbconn, "query7", "UPDATE users SET logged_in = $1
            WHERE email = $2;");
        $result = pg_execute($dbconn, "query7", array("true", $email));
        $logged_in = true;
    }
    else {
        $result = pg_execute($dbconn, "query7", array("false", $email));
        $logged_in = false;
    }
}

// no pg_close() here
?>
