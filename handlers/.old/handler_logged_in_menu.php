<?php

// Check for the existing Cookie

if (isset($_COOKIE['login']) ) {
    //1. read the first word in Cookie of the form 
        //"email@gmail.com,ca05106e445c15197f7213bc12648524
    //Then, store this word to $email 
    $cookie_tripped = explode(",", $_COOKIE['login']);      // use explode here, split for regex
    $email = $cookie_tripped[0];
    $result = pg_prepare($dbconn, "query1", 'SELECT passhash_md5 FROM users 
                         WHERE email = $1;');
    $result = pg_execute($dbconn, "query1", array($email));

    if(!$result) {
        echo "An error occurred - Hhhhhhhhh!\n";
        exit;
    }

    // to take the passhash out of the cookie
    $passhash_md5_cookie = $cookie_tripped[1];
    if($result == $passhash_md5_cookie) {
        header("Location: ../index.php");
        die("logged in");
    }
    // laitetaan login -lomake nakyviin
    include 'lomakkeet/lomake_login.php';
}

?>
