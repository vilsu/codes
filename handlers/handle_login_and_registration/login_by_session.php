<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
if(!$dbconn) {
    echo "An error occurred - Hhhh\n";
    exit;
}

// 1. If the user is not authenticated, he is thrown back to the login page
// 2. If the user is authenticated, he get true for login var 
// 3. Then when the user is browsing the main page or other pages that need auth, they just check if the login -var is set.


session_save_path("/tmp/");
session_start();

// This needs to before any session variables and random nunmber generation
if( $_SESSION['login']['logged_in'] == 0 ){
    $random_number = rand(1,100000);
    $session_id = session_id($random_number);
}


$result = pg_prepare($dbconn, "query22", "SELECT passhash_md5 FROM users
        WHERE email=$1;");

$passhash_md5 = pg_execute($dbconn, "query22", array($_POST['login']['email']));
// users from registration/login form
if ($passhash_md5 == md5($_POST['login']['password'])) {
    $_SESSION['login']['logged_in'] = 1;
    $_SESSION['login']['email'] = $_POST['login']['email'];
    $_SESSION['login']['passhash_md5'] = md5($_POST['login']['password']);
}

$passhash_md5_2 = pg_execute($dbconn, "query22", array($_SESSION['login']['email']));
// users staying in the site
if ($passhash_md5_2 == $_SESSION['login']['passhash_md5']) {
    $_SESSION['login']['logged_in'] = 1;
}


// http://stackoverflow.com/questions/415005/php-session-variables-not-carrying-over-to-my-logged-in-page-but-session-id-is

// no pg_close() here
?>
